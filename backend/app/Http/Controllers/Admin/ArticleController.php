<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category', 'author', 'tags');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $articles = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'authors', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|max:5120',
            'featured_video' => 'nullable|url|max:500',
            'gallery_files' => 'nullable|array|max:20',
            'gallery_files.*' => 'image|max:5120',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'is_trending' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
            'source_name' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:500',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_breaking'] = $request->boolean('is_breaking');
        $validated['is_trending'] = $request->boolean('is_trending');
        $validated['reading_time'] = $this->calculateReadingTime($validated['body']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        } elseif ($request->filled('featured_image_path')) {
            $validated['featured_image'] = $request->input('featured_image_path');
        }

        // Gallery
        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $gallery[] = $file->store('articles/gallery', 'public');
            }
        }
        $validated['gallery'] = $gallery ?: null;
        unset($validated['gallery_files']);

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article = Article::create($validated);

        if ($request->filled('tags')) {
            $article->tags()->sync($request->tags);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Мэдээ амжилттай үүсгэлээ.');
    }

    public function edit(Article $article)
    {
        $article->load('tags');
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.edit', compact('article', 'categories', 'authors', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|max:5120',
            'featured_video' => 'nullable|url|max:500',
            'gallery_files' => 'nullable|array|max:20',
            'gallery_files.*' => 'image|max:5120',
            'existing_gallery' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'is_trending' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
            'source_name' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:500',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_breaking'] = $request->boolean('is_breaking');
        $validated['is_trending'] = $request->boolean('is_trending');
        $validated['reading_time'] = $this->calculateReadingTime($validated['body']);
        unset($validated['featured_image']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        } elseif ($request->filled('featured_image_path')) {
            $validated['featured_image'] = $request->input('featured_image_path');
        }

        // Gallery: keep existing + add new
        $gallery = $request->input('existing_gallery', []);
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $gallery[] = $file->store('articles/gallery', 'public');
            }
        }
        $validated['gallery'] = $gallery ?: null;
        unset($validated['gallery_files'], $validated['existing_gallery']);

        if ($validated['status'] === 'published' && ! $article->published_at) {
            $validated['published_at'] = now();
        }

        $article->update($validated);
        $article->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.articles.index')->with('success', 'Мэдээ амжилттай шинэчлэгдлээ.');
    }

    public function destroy(Article $article)
    {
        $article->tags()->detach();
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Мэдээ амжилттай устгагдлаа.');
    }

    private function calculateReadingTime(string $body): int
    {
        $text = strip_tags($body);
        $wordCount = str_word_count($text);

        return max(1, (int) ceil($wordCount / 200));
    }
}
