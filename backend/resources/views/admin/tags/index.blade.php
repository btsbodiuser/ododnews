@extends('admin.layout')
@section('title', 'Шошго')
@section('heading', 'Шошго')

@section('actions')
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Шошго нэмэх
    </a>
@endsection

@section('content')
{{-- Search --}}
<div class="card mb-6">
    <form method="GET" class="flex items-end gap-3 p-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Шошго хайх..." class="input">
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Хайх</button>
        @if(request('search'))
            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary btn-sm">Цэвэрлэх</a>
        @endif
    </form>
</div>

<div class="flex flex-wrap gap-3">
    @forelse($tags as $tag)
        <div class="card inline-flex items-center gap-3 px-4 py-3 group hover:shadow-md transition-shadow">
            <span class="text-sm font-medium dark:text-zinc-100">#{{ $tag->name }}</span>
            <span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400">{{ $tag->articles_count }}</span>
            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="{{ route('admin.tags.edit', $tag) }}" class="text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400" title="Засах">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('Устгах уу?')" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-zinc-400 hover:text-red-600 dark:hover:text-red-400" title="Устгах">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="py-12 text-center text-zinc-400 w-full">Шошго олдсонгүй</p>
    @endforelse
</div>
<div class="mt-4">{{ $tags->links() }}</div>
@endsection
