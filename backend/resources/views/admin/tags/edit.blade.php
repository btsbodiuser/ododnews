@extends('admin.layout')
@section('title', 'Шошго засах')
@section('heading', 'Шошго засах')

@section('content')
<div class="max-w-md">
    <form method="POST" action="{{ route('admin.tags.update', $tag) }}">
        @csrf
        @method('PUT')
        <div class="card p-5">
            <label for="name" class="label">Нэр <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $tag->name) }}" class="input" required autofocus>
            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            <p class="mt-2 text-xs text-zinc-400 dark:text-zinc-500">Slug: <code class="font-mono">{{ $tag->slug }}</code></p>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Хадгалах
            </button>
            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Буцах</a>
        </div>
    </form>
</div>
@endsection
