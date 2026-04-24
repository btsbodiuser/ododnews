@extends('admin.layout')
@section('title', 'Тайлан')
@section('heading', 'Тайлан, лог, систем')

@section('content')
<div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-800 mb-6">
    @foreach(['overview' => 'Гүйцэтгэл', 'audit' => 'Аудит лог', 'errors' => 'Алдааны лог', 'health' => 'Системийн төлөв'] as $key => $label)
        <a href="{{ route('admin.reports.index', ['tab' => $key]) }}"
           class="px-4 py-2 text-sm font-medium border-b-2 {{ $tab === $key ? 'text-blue-600 border-blue-600' : 'text-zinc-500 border-transparent' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

@if($tab === 'overview')
    <div class="flex gap-2 mb-4">
        <a href="{{ route('admin.reports.export.articles') }}" class="btn btn-secondary">Нийтлэл CSV</a>
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card overflow-hidden">
            <h3 class="font-semibold p-5 border-b border-zinc-100 dark:border-zinc-800">Топ-20 нийтлэл</h3>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>#</th><th>Гарчиг</th><th>Үзэлт</th></tr></thead>
                    <tbody>
                        @foreach($perfTopArticles as $i => $a)
                            <tr>
                                <td class="text-zinc-400 text-xs">{{ $i + 1 }}</td>
                                <td class="text-sm">{{ $a->title }}</td>
                                <td>{{ number_format($a->views_count) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card overflow-hidden">
            <h3 class="font-semibold p-5 border-b border-zinc-100 dark:border-zinc-800">Ангилал тус бүрийн гүйцэтгэл</h3>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>Ангилал</th><th>Нийтлэл</th><th>Үзэлт</th></tr></thead>
                    <tbody>
                        @foreach($perfByCategory as $c)
                            <tr><td class="text-sm font-medium">{{ $c->name }}</td><td>{{ $c->article_count }}</td><td>{{ number_format($c->views) }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@if($tab === 'audit')
    <div class="flex gap-2 mb-4">
        <a href="{{ route('admin.reports.export.audit') }}" class="btn btn-secondary">Аудит CSV</a>
    </div>
    <div class="card overflow-hidden">
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Огноо</th><th>Хэрэглэгч</th><th>Үйлдэл</th><th>Объект</th><th>Тайлбар</th><th>IP</th></tr></thead>
                <tbody>
                    @foreach($audit as $r)
                        <tr>
                            <td class="text-xs text-zinc-500">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-sm">{{ $r->user?->email ?? 'system' }}</td>
                            <td><span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">{{ $r->action }}</span></td>
                            <td class="text-xs text-zinc-500">{{ class_basename($r->subject_type) }}{{ $r->subject_id ? '#'.$r->subject_id : '' }}</td>
                            <td class="text-sm">{{ $r->description }}</td>
                            <td class="text-xs text-zinc-500">{{ $r->ip }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $audit->links() }}</div>
@endif

@if($tab === 'errors')
    <div class="card p-5">
        <h3 class="font-semibold mb-3">storage/logs/laravel.log (сүүлийн 40 мөр)</h3>
        <pre class="font-mono text-xs bg-zinc-900 text-zinc-100 p-4 rounded-lg overflow-x-auto max-h-96">@foreach($errorLog as $line){{ $line }}
@endforeach</pre>
    </div>
@endif

@if($tab === 'health')
    <div class="card p-5">
        <h3 class="font-semibold mb-3">Системийн төлөв</h3>
        <div class="grid sm:grid-cols-2 gap-4 text-sm">
            @foreach($health as $key => $value)
                <div class="flex justify-between border-b border-zinc-100 dark:border-zinc-800 pb-2">
                    <span class="font-medium">{{ $key }}</span>
                    <span class="text-zinc-500">{{ is_bool($value) ? ($value ? '✓' : '✗') : $value }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
