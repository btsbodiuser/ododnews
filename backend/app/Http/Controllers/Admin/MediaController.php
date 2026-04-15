<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query()->latest();

        if ($request->filled('folder')) {
            $query->where('folder', $request->folder);
        }

        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type') && $request->type === 'images') {
            $query->images();
        }

        $media = $query->paginate(36)->withQueryString();
        $folders = Media::select('folder')->distinct()->orderBy('folder')->pluck('folder');
        $stats = [
            'total' => Media::count(),
            'images' => Media::images()->count(),
            'size' => Media::sum('size'),
        ];

        return view('admin.media.index', compact('media', 'folders', 'stats'));
    }

    /**
     * Upload one or many files.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'files' => 'required|array|max:30',
            'files.*' => 'file|max:10240',
            'folder' => 'nullable|string|max:50',
        ]);

        $folder = $request->input('folder', 'general');
        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store("media/{$folder}", 'public');

            $uploaded[] = Media::create([
                'filename' => basename($path),
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'folder' => $folder,
            ]);
        }

        return response()->json([
            'success' => true,
            'files' => collect($uploaded)->map(fn ($m) => [
                'id' => $m->id,
                'url' => $m->url,
                'original_name' => $m->original_name,
                'size_human' => $m->size_human,
            ]),
        ]);
    }

    /**
     * JSON endpoint for media picker (AJAX).
     */
    public function browse(Request $request): JsonResponse
    {
        $query = Media::query()->latest();

        if ($request->filled('folder')) {
            $query->where('folder', $request->folder);
        }

        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type') && $request->type === 'images') {
            $query->images();
        }

        $media = $query->paginate(36);

        return response()->json([
            'data' => $media->map(fn ($m) => [
                'id' => $m->id,
                'url' => $m->url,
                'path' => $m->path,
                'original_name' => $m->original_name,
                'mime_type' => $m->mime_type,
                'size_human' => $m->size_human,
                'folder' => $m->folder,
                'created_at' => $m->created_at->format('Y.m.d'),
            ]),
            'next_page' => $media->hasMorePages() ? $media->currentPage() + 1 : null,
        ]);
    }

    public function update(Request $request, Media $medium): JsonResponse
    {
        $validated = $request->validate([
            'alt' => 'nullable|string|max:255',
            'folder' => 'nullable|string|max:50',
        ]);

        $medium->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Media $medium): JsonResponse
    {
        Storage::disk($medium->disk)->delete($medium->path);
        $medium->delete();

        return response()->json(['success' => true]);
    }

    public function bulkDestroy(Request $request): JsonResponse
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:uploads,id']);

        $items = Media::whereIn('id', $request->ids)->get();
        foreach ($items as $item) {
            Storage::disk($item->disk)->delete($item->path);
            $item->delete();
        }

        return response()->json(['success' => true, 'deleted' => count($items)]);
    }
}
