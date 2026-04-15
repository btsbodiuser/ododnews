<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('articles')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('admin.authors.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'bio' => 'nullable|string|max:1000',
            'position' => 'nullable|string|max:191',
            'avatar' => 'nullable|image|max:1024',
            'user_id' => 'nullable|exists:users,id',
            'social_links' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('authors', 'public');
        } elseif ($request->filled('avatar_path')) {
            $validated['avatar'] = $request->input('avatar_path');
        }

        if (! empty($validated['social_links'])) {
            $validated['social_links'] = json_decode($validated['social_links'], true);
        }

        Author::create($validated);

        return redirect()->route('admin.authors.index')->with('success', 'Нийтлэгч амжилттай үүсгэлээ.');
    }

    public function edit(Author $author)
    {
        $users = User::orderBy('name')->get();

        return view('admin.authors.edit', compact('author', 'users'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'bio' => 'nullable|string|max:1000',
            'position' => 'nullable|string|max:191',
            'avatar' => 'nullable|image|max:1024',
            'user_id' => 'nullable|exists:users,id',
            'social_links' => 'nullable|string',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('authors', 'public');
        } elseif ($request->filled('avatar_path')) {
            $validated['avatar'] = $request->input('avatar_path');
        } else {
            unset($validated['avatar']);
        }

        if (! empty($validated['social_links'])) {
            $validated['social_links'] = json_decode($validated['social_links'], true);
        }

        $author->update($validated);

        return redirect()->route('admin.authors.index')->with('success', 'Нийтлэгч амжилттай шинэчлэгдлээ.');
    }

    public function destroy(Author $author)
    {
        if ($author->articles()->exists()) {
            return back()->with('error', 'Мэдээтэй нийтлэгчийг устгах боломжгүй.');
        }

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Нийтлэгч амжилттай устгагдлаа.');
    }
}
