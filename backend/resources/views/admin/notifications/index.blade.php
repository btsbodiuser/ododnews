@extends('admin.layout')
@section('title', 'Мэдэгдэл')
@section('heading', 'Бүх мэдэгдэл')
@section('actions')
    <form method="POST" action="{{ route('admin.notifications.read-all') }}">
        @csrf
        <button class="btn btn-secondary">Бүгдийг унших</button>
    </form>
@endsection

@section('content')
<div class="card divide-y divide-zinc-100 dark:divide-zinc-800">
    @forelse($notifications as $n)
        <a href="{{ route('admin.notifications.read', $n) }}" class="flex items-start gap-3 px-5 py-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $n->read_at ? 'opacity-60' : '' }}">
            <span @class([
                'mt-1 inline-block h-2 w-2 rounded-full shrink-0',
                'bg-blue-500' => $n->level === 'info',
                'bg-emerald-500' => $n->level === 'success',
                'bg-amber-500' => $n->level === 'warning',
                'bg-red-500' => $n->level === 'danger',
            ])></span>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium">{{ $n->title }}</p>
                @if($n->message)<p class="mt-0.5 text-xs text-zinc-500 line-clamp-2">{{ $n->message }}</p>@endif
                <p class="mt-1 text-[11px] text-zinc-400">{{ $n->created_at->diffForHumans() }} · {{ $n->type }}</p>
            </div>
            @if(! $n->read_at)<span class="badge bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-[10px]">Шинэ</span>@endif
        </a>
    @empty
        <p class="px-5 py-8 text-center text-sm text-zinc-400">Мэдэгдэл алга</p>
    @endforelse
</div>
<div class="mt-4">{{ $notifications->links() }}</div>
@endsection
