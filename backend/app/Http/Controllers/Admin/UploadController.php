<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Handle image upload from TinyMCE editor.
     */
    public function editorImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $path = $request->file('file')->store('articles/content', 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
        ]);
    }

    /**
     * Handle gallery image uploads.
     */
    public function galleryImages(Request $request): JsonResponse
    {
        $request->validate([
            'files' => 'required|array|max:20',
            'files.*' => 'image|max:5120',
        ]);

        $paths = [];
        foreach ($request->file('files') as $file) {
            $paths[] = $file->store('articles/gallery', 'public');
        }

        return response()->json([
            'paths' => $paths,
            'urls' => array_map(fn ($p) => asset('storage/' . $p), $paths),
        ]);
    }
}
