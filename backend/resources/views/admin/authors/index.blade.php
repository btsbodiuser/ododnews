@extends('admin.layout')
@section('title', 'Нийтлэгч')
@section('heading', 'Нийтлэгч')

@section('actions')
    <a href="{{ route('admin.authors.create') }}" class="btn btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Нийтлэгч нэмэх
    </a>
@endsection

@section('content')
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($authors as $author)
        <div class="card p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-zinc-200 dark:bg-zinc-700 text-lg font-bold text-zinc-500 dark:text-zinc-300 overflow-hidden">
                    @if($author->avatar)
                        <img src="{{ asset('storage/' . $author->avatar) }}" alt="" class="h-full w-full object-cover">
                    @else
                        {{ mb_substr($author->name, 0, 1) }}
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $author->name }}</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $author->position ?? 'Нийтлэгч' }}</p>
                    <div class="mt-1 flex items-center gap-3 text-xs text-zinc-400 dark:text-zinc-500">
                        <span>{{ $author->articles_count }} мэдээ</span>
                    </div>
                </div>
            </div>
            @if($author->bio)
                <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">{{ $author->bio }}</p>
            @endif
            <div class="mt-4 flex gap-2 border-t border-zinc-100 dark:border-zinc-800 pt-3">
                <a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-secondary btn-sm flex-1 justify-center">Засах</a>
                <form method="POST" action="{{ route('admin.authors.destroy', $author) }}" onsubmit="return confirm('Устгахдаа итгэлтэй байна уу?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Устгах</button>
                </form>
            </div>
        </div>
    @empty
        <div class="sm:col-span-3 py-12 text-center text-zinc-400">Нийтлэгч олдсонгүй</div>
    @endforelse
</div>
<div class="mt-4">{{ $authors->links() }}</div>
@endsection
