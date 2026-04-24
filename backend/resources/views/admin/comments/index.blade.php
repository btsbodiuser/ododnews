@extends('admin.layout')
@section('title', 'Сэтгэгдэл')
@section('heading', 'Сэтгэгдэл, модераци')

@section('content')
<div class="card mb-4 p-4">
    <div class="flex flex-wrap items-center gap-2">
        @foreach(['pending' => 'Хүлээгдэж буй', 'approved' => 'Зөвшөөрсөн', 'rejected' => 'Татгалзсан', 'spam' => 'Спам'] as $key => $label)
            <a href="{{ route('admin.comments.index', ['status' => $key]) }}"
               class="badge {{ $status === $key ? 'bg-blue-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}">
                {{ $label }} ({{ $counts[$key] ?? 0 }})
            </a>
        @endforeach
        <form method="GET" class="ml-auto flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Хайх..." class="input w-64">
            <button class="btn btn-secondary">Хайх</button>
        </form>
    </div>
</div>

<form method="POST" action="{{ route('admin.comments.bulk') }}">
    @csrf
    <div class="card overflow-hidden">
        <div class="flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 px-5 py-3 text-sm">
            <select name="action" class="input w-40">
                <option value="">Бөөнөөр…</option>
                <option value="approve">Зөвшөөрөх</option>
                <option value="reject">Татгалзах</option>
                <option value="spam">Спам гэх</option>
                <option value="delete">Устгах</option>
            </select>
            <button class="btn btn-secondary btn-sm">Хэрэгжүүлэх</button>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" onchange="document.querySelectorAll('.row-cb').forEach(c => c.checked = this.checked)"></th>
                        <th>Сэтгэгдэл</th>
                        <th>Нийтлэл</th>
                        <th>Зохиогч</th>
                        <th>Огноо</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $c)
                        <tr>
                            <td><input type="checkbox" name="ids[]" value="{{ $c->id }}" class="row-cb"></td>
                            <td class="max-w-md">
                                <p class="line-clamp-2 text-sm">{{ $c->body }}</p>
                                @if($c->is_flagged)<span class="badge bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 text-[10px] mt-1">Тэмдэглэгдсэн</span>@endif
                            </td>
                            <td class="max-w-xs">
                                <a href="{{ route('admin.articles.edit', $c->article_id) }}" class="text-sm hover:text-blue-600 line-clamp-1">{{ $c->article?->title }}</a>
                            </td>
                            <td>
                                <p class="text-sm">{{ $c->user?->name ?? $c->author_name }}</p>
                                <p class="text-xs text-zinc-400">{{ $c->author_email }}</p>
                                @if($c->author_ip)<p class="text-[10px] text-zinc-400">{{ $c->author_ip }}</p>@endif
                            </td>
                            <td class="text-xs text-zinc-500">{{ $c->created_at->diffForHumans() }}</td>
                            <td class="space-x-1 whitespace-nowrap">
                                <form method="POST" action="{{ route('admin.comments.update', $c) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button name="action" value="approve" class="btn btn-sm btn-secondary text-emerald-600">✓</button>
                                    <button name="action" value="reject" class="btn btn-sm btn-secondary text-amber-600">✗</button>
                                    <button name="action" value="spam" class="btn btn-sm btn-secondary text-red-600">!</button>
                                </form>
                                <form method="POST" action="{{ route('admin.comments.destroy', $c) }}" class="inline" onsubmit="return confirm('Устгах уу?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">🗑</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-8 text-sm text-zinc-400">Сэтгэгдэл алга</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</form>
<div class="mt-4">{{ $comments->links() }}</div>
@endsection
