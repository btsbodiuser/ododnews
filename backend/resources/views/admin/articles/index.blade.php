@extends('admin.layout')
@section('title', 'Мэдээ')
@section('heading', 'Мэдээ')

@section('actions')
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Мэдээ нэмэх
    </a>
@endsection

@section('content')
{{-- Filters --}}
<div class="card mb-6">
    <form method="GET" class="flex flex-wrap items-end gap-3 p-4">
        <div class="flex-1 min-w-[200px]">
            <label class="label">Хайх</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Гарчиг..." class="input">
        </div>
        <div class="w-40">
            <label class="label">Төлөв</label>
            <select name="status" class="input">
                <option value="">Бүгд</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Нийтэлсэн</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Ноорог</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Архив</option>
            </select>
        </div>
        <div class="w-48">
            <label class="label">Ангилал</label>
            <select name="category" class="input">
                <option value="">Бүгд</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Шүүх</button>
        @if(request()->hasAny(['search', 'status', 'category']))
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">Цэвэрлэх</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card table-wrapper">
    <table>
        <thead>
            <tr>
                <th class="w-12">#</th>
                <th>Гарчиг</th>
                <th>Ангилал</th>
                <th>Нийтлэгч</th>
                <th>Төлөв</th>
                <th>Үзэлт</th>
                <th>Огноо</th>
                <th class="w-24"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td class="text-zinc-400">{{ $article->id }}</td>
                    <td>
                        <div class="max-w-sm">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="font-medium text-zinc-900 dark:text-zinc-100 hover:text-blue-600 dark:hover:text-blue-400 line-clamp-1">{{ $article->title }}</a>
                            <div class="mt-0.5 flex gap-1.5">
                                @if($article->is_featured)
                                    <span class="badge bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">Онцлох</span>
                                @endif
                                @if($article->is_breaking)
                                    <span class="badge bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400">Яаралтай</span>
                                @endif
                                @if($article->is_trending)
                                    <span class="badge bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400">Трэнд</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($article->category)
                            <span class="badge" style="background: {{ $article->category->color }}20; color: {{ $article->category->color }}">{{ $article->category->name }}</span>
                        @endif
                    </td>
                    <td class="text-zinc-500 dark:text-zinc-400">{{ $article->author?->name ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $article->status === 'published' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400' : ($article->status === 'draft' ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' : 'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400') }}">
                            {{ $article->status === 'published' ? 'Нийтэлсэн' : ($article->status === 'draft' ? 'Ноорог' : 'Архив') }}
                        </span>
                    </td>
                    <td class="text-zinc-500 dark:text-zinc-400">{{ number_format($article->views_count) }}</td>
                    <td class="text-zinc-500 dark:text-zinc-400 text-xs">{{ $article->created_at->format('Y.m.d') }}</td>
                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Засах">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Устгахдаа итгэлтэй байна уу?')">
                                @csrf @method('DELETE')
                                <button class="rounded-lg p-1.5 text-zinc-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition-colors" title="Устгах">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="py-12 text-center text-zinc-400">Мэдээ олдсонгүй</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $articles->links() }}
</div>
@endsection
