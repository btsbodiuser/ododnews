@extends('admin.layout')
@section('title', 'Зар сурталчилгаа')
@section('heading', 'Зар сурталчилгаа')
@section('actions')
    <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">+ Зар нэмэх</a>
@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="card p-5 space-y-4 lg:col-span-1">
        <h3 class="font-semibold">Байршлууд (slots)</h3>
        <form method="POST" action="{{ route('admin.ads.slots.store') }}" class="space-y-2">
            @csrf
            <input name="code" placeholder="код (home_top)" class="input" required>
            <input name="name" placeholder="Нэр" class="input" required>
            <input name="size" placeholder="Хэмжээ (728x90)" class="input">
            <button class="btn btn-secondary w-full">Байршил нэмэх</button>
        </form>
        <div class="space-y-1">
            @foreach($slots as $s)
                <div class="flex items-center justify-between text-sm border border-zinc-100 dark:border-zinc-800 rounded-lg px-3 py-2">
                    <div>
                        <p class="font-medium">{{ $s->name }}</p>
                        <p class="text-xs text-zinc-500"><code>{{ $s->code }}</code> · {{ $s->size ?? '—' }} · {{ $s->ads_count }} зар</p>
                    </div>
                    <form method="POST" action="{{ route('admin.ads.slots.destroy', $s) }}" onsubmit="return confirm('Устгах уу?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">×</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card overflow-hidden lg:col-span-2">
        <h3 class="font-semibold p-5 border-b border-zinc-100 dark:border-zinc-800">Зарууд</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>Нэр</th><th>Байршил</th><th>Төрөл</th><th>Идэвхтэй</th><th>Imp / Click</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse($ads as $ad)
                        <tr>
                            <td class="font-medium">{{ $ad->name }}</td>
                            <td><span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-600">{{ $ad->slot?->name }}</span></td>
                            <td>{{ $ad->type }}</td>
                            <td>{!! $ad->is_active ? '✓' : '—' !!}</td>
                            <td class="text-xs text-zinc-500">{{ $ad->impressions }} / {{ $ad->clicks }}</td>
                            <td class="space-x-1">
                                <a href="{{ route('admin.ads.edit', $ad) }}" class="btn btn-sm btn-secondary">Засах</a>
                                <form method="POST" action="{{ route('admin.ads.destroy', $ad) }}" class="inline" onsubmit="return confirm('Устгах уу?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">×</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-8 text-sm text-zinc-400">Зар алга</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4">{{ $ads->links() }}</div>
@endsection
