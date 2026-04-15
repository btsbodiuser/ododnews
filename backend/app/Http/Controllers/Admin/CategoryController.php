<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'name_en' => 'nullable|string|max:191',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'show_in_menu' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name_en'] ?? $validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['show_in_menu'] = $request->boolean('show_in_menu');

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Ангилал амжилттай үүсгэлээ.');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'name_en' => 'nullable|string|max:191',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'show_in_menu' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['show_in_menu'] = $request->boolean('show_in_menu');

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Ангилал амжилттай шинэчлэгдлээ.');
    }

    public function destroy(Category $category)
    {
        if ($category->articles()->exists()) {
            return back()->with('error', 'Мэдээтэй ангилалыг устгах боломжгүй.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Ангилал амжилттай устгагдлаа.');
    }
}
