<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::withCount('articles');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tags = $query->orderBy('name')->paginate(30)->withQueryString();

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191|unique:tags,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Tag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Шошго амжилттай үүсгэлээ.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191|unique:tags,name,' . $tag->id,
        ]);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Шошго амжилттай шинэчлэгдлээ.');
    }

    public function destroy(Tag $tag)
    {
        $tag->articles()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Шошго амжилттай устгагдлаа.');
    }
}
