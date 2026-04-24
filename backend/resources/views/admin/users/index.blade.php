@extends('admin.layout')
@section('title', 'Хэрэглэгч')
@section('heading', 'Хэрэглэгч ба эрхүүд')
@section('actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Хэрэглэгч урих</a>
@endsection

@section('content')
<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Нэр / имэйл" class="input w-64">
        <select name="role" class="input w-40">
            <option value="">Бүх эрх</option>
            @foreach(['admin' => 'Админ', 'editor' => 'Эрхлэгч', 'author' => 'Сэтгүүлч'] as $k => $v)
                <option value="{{ $k }}" @selected(request('role') === $k)>{{ $v }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary">Шүүх</button>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Нэр</th><th>Имэйл</th><th>Эрх</th><th>Төлөв</th><th>2FA</th><th>Сүүлд орсон</th><th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-bold">{{ mb_substr($u->name, 0, 1) }}</div>
                                <span class="font-medium">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="text-sm">{{ $u->email }}</td>
                        <td><span class="badge bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400">{{ $u->role ?? 'author' }}</span></td>
                        <td>
                            @if(($u->status ?? 'active') === 'active')
                                <span class="badge bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">Идэвхтэй</span>
                            @elseif($u->status === 'suspended')
                                <span class="badge bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400">Хориглосон</span>
                            @else
                                <span class="badge bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">Урилгатай</span>
                            @endif
                        </td>
                        <td>{{ $u->two_factor_enabled ? '✓' : '—' }}</td>
                        <td class="text-xs text-zinc-500">{{ $u->last_login_at?->diffForHumans() ?? '—' }}</td>
                        <td class="space-x-1 whitespace-nowrap">
                            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-secondary">Засах</a>
                            <form method="POST" action="{{ route('admin.users.suspend', $u) }}" class="inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-secondary">{{ $u->status === 'suspended' ? 'Сэргээх' : 'Хориглох' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="return confirm('Устгах уу?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Устгах</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
