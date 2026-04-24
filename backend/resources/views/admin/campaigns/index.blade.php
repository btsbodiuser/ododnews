@extends('admin.layout')
@section('title', 'Кампанит')
@section('heading', 'Имэйл кампанитууд')
@section('actions')
    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">+ Кампанит үүсгэх</a>
@endsection

@section('content')
<div class="card overflow-hidden">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>Гарчиг</th><th>Төлөв</th><th>Хүлээн авагч</th><th>Нээлт</th><th>Товшилт</th><th>Огноо</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($campaigns as $c)
                    <tr>
                        <td class="font-medium">{{ $c->subject }}</td>
                        <td><span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">{{ $c->status }}</span></td>
                        <td>{{ $c->recipients_count }}</td>
                        <td>{{ $c->opens_count }}</td>
                        <td>{{ $c->clicks_count }}</td>
                        <td class="text-xs text-zinc-500">{{ ($c->sent_at ?? $c->created_at)->format('Y-m-d H:i') }}</td>
                        <td class="space-x-1 whitespace-nowrap">
                            <a href="{{ route('admin.campaigns.edit', $c) }}" class="btn btn-sm btn-secondary">Засах</a>
                            @if($c->status === 'draft')
                                <form method="POST" action="{{ route('admin.campaigns.send', $c) }}" class="inline" onsubmit="return confirm('Илгээх үү?')">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">Илгээх</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.campaigns.destroy', $c) }}" class="inline" onsubmit="return confirm('Устгах уу?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">×</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-8 text-sm text-zinc-400">Кампанит алга</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $campaigns->links() }}</div>
@endsection
