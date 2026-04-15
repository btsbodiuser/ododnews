@extends('admin.layout')
@section('title', 'Хянах самбар')
@section('heading', 'Хянах самбар')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-8">
    <div class="card p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['articles'] }}</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Нийт мэдээ</p>
            </div>
        </div>
    </div>
    <div class="card p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['published'] }}</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Нийтлэгдсэн</p>
            </div>
        </div>
    </div>
    <div class="card p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['categories'] }}</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Ангилал</p>
            </div>
        </div>
    </div>
    <div class="card p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['views']) }}</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Нийт үзэлт</p>
            </div>
        </div>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    {{-- Latest Articles --}}
    <div class="card">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 px-5 py-4">
            <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Сүүлийн мэдээнүүд</h2>
            <a href="{{ route('admin.articles.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Бүгдийг харах →</a>
        </div>
        <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
            @forelse($latestArticles as $article)
                <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:text-blue-600 dark:hover:text-blue-400 line-clamp-1">{{ $article->title }}</a>
                        <div class="mt-0.5 flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                            @if($article->category)
                                <span class="badge" style="background: {{ $article->category->color }}20; color: {{ $article->category->color }}">{{ $article->category->name }}</span>
                            @endif
                            <span>{{ $article->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <span class="badge {{ $article->status === 'published' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                        {{ $article->status === 'published' ? 'Нийтэлсэн' : 'Ноорог' }}
                    </span>
                </div>
            @empty
                <p class="px-5 py-8 text-center text-sm text-zinc-400">Мэдээ байхгүй</p>
            @endforelse
        </div>
    </div>

    {{-- Popular Articles --}}
    <div class="card">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 px-5 py-4">
            <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Эрэлттэй мэдээнүүд</h2>
        </div>
        <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
            @forelse($popularArticles as $i => $article)
                <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-xs font-bold text-zinc-500 dark:text-zinc-400">{{ $i + 1 }}</span>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:text-blue-600 dark:hover:text-blue-400 line-clamp-1">{{ $article->title }}</a>
                        <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($article->views_count) }} үзэлт</p>
                    </div>
                </div>
            @empty
                <p class="px-5 py-8 text-center text-sm text-zinc-400">Мэдээ байхгүй</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
