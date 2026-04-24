@extends('admin.layout')
@section('title', 'Захиалагч')
@section('heading', 'Имэйл захиалагч')
@section('actions')
    <a href="{{ route('admin.subscribers.export') }}" class="btn btn-secondary">CSV татах</a>
@endsection

@section('content')
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
    @foreach(['all' => 'Нийт', 'active' => 'Идэвхтэй', 'pending' => 'Хүлээж буй', 'unsubscribed' => 'Татгалзсан'] as $k => $v)
        <div class="card p-4">
            <p class="text-xs uppercase text-zinc-500">{{ $v }}</p>
            <p class="mt-1 text-2xl font-bold">{{ number_format($totals[$k]) }}</p>
        </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-3 gap-4">
    <form method="POST" action="{{ route('admin.subscribers.store') }}" class="card p-5 space-y-3 lg:col-span-1">
        @csrf
        <h3 class="font-semibold">Гар захиалагч нэмэх</h3>
        <input type="email" name="email" placeholder="email@жишээ.mn" class="input" required>
        <input type="text" name="name" placeholder="Нэр (заавал биш)" class="input">
        <button class="btn btn-primary w-full">Нэмэх</button>
    </form>

    <div class="card overflow-hidden lg:col-span-2">
        <form method="GET" class="flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 px-5 py-3">
            <input name="search" value="{{ request('search') }}" placeholder="Имэйл хайх" class="input flex-1">
            <select name="status" class="input w-40">
                <option value="">Бүх төлөв</option>
                @foreach(['active', 'pending', 'unsubscribed', 'bounced'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                @endforeach
            </select>
            <button class="btn btn-secondary">Шүүх</button>
        </form>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>Имэйл</th><th>Нэр</th><th>Төлөв</th><th>Эх үүсвэр</th><th>Огноо</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $s)
                        <tr>
                            <td class="text-sm">{{ $s->email }}</td>
                            <td class="text-sm">{{ $s->name ?? '—' }}</td>
                            <td><span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">{{ $s->status }}</span></td>
                            <td class="text-xs text-zinc-500">{{ $s->source ?? '—' }}</td>
                            <td class="text-xs text-zinc-500">{{ $s->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.subscribers.destroy', $s) }}" onsubmit="return confirm('Устгах уу?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">×</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-8 text-sm text-zinc-400">Захиалагч алга</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4">{{ $subscribers->links() }}</div>
@endsection
