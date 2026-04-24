@extends('admin.layout')
@section('title', 'Хянах самбар')
@section('heading', 'Хянах самбар')

@section('content')
{{-- KPI cards --}}
<div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6 mb-6">
    @foreach([
        ['label' => 'Нийт мэдээ', 'value' => $stats['articles'], 'color' => 'blue'],
        ['label' => 'Нийтэлсэн', 'value' => $stats['published'], 'color' => 'emerald'],
        ['label' => 'Ноорог', 'value' => $stats['draft'], 'color' => 'amber'],
        ['label' => 'Товлогдсон', 'value' => $stats['scheduled'], 'color' => 'indigo'],
        ['label' => 'Нийт үзэлт', 'value' => number_format($stats['views']), 'color' => 'purple'],
        ['label' => 'Захиалагч', 'value' => $stats['subscribers'], 'color' => 'pink'],
    ] as $k)
        <div class="card p-4">
            <p class="text-xs uppercase tracking-wide text-zinc-500">{{ $k['label'] }}</p>
            <p class="mt-1 text-2xl font-bold">{{ $k['value'] }}</p>
        </div>
    @endforeach
</div>

{{-- Action items --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('admin.comments.index') }}" class="card p-4 flex items-center gap-3 hover:shadow-md transition-shadow">
        <div class="h-10 w-10 rounded-lg bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 flex items-center justify-center font-bold">{{ $stats['comments_pending'] }}</div>
        <div><p class="text-sm font-medium">Хүлээгдэж буй сэтгэгдэл</p><p class="text-xs text-zinc-500">Шалгах хэрэгтэй</p></div>
    </a>
    <a href="{{ route('admin.articles.index', ['status' => 'draft']) }}" class="card p-4 flex items-center gap-3 hover:shadow-md transition-shadow">
        <div class="h-10 w-10 rounded-lg bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">{{ $stats['draft'] }}</div>
        <div><p class="text-sm font-medium">Хянах ёстой нийтлэл</p><p class="text-xs text-zinc-500">Ноорог төлөвт</p></div>
    </a>
    <a href="{{ route('admin.breaking.index') }}" class="card p-4 flex items-center gap-3 hover:shadow-md transition-shadow">
        <div class="h-10 w-10 rounded-lg bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400 flex items-center justify-center font-bold">{{ $stats['breaking_active'] }}</div>
        <div><p class="text-sm font-medium">Идэвхтэй яаралтай мэдээ</p><p class="text-xs text-zinc-500">Push илгээх боломжтой</p></div>
    </a>
</div>

{{-- Chart + trending --}}
<div class="grid gap-6 lg:grid-cols-3 mb-6">
    <div class="card p-5 lg:col-span-2">
        <h2 class="font-semibold mb-4">7 хоногийн нийтлэл</h2>
        <div class="flex items-end gap-2 h-40">
            @php $max = max(1, collect($chart)->max('value')); @endphp
            @foreach($chart as $point)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-blue-500/80 dark:bg-blue-400/80 rounded-t" style="height: {{ ($point['value'] / $max) * 100 }}%"></div>
                    <span class="text-[10px] text-zinc-500">{{ $point['label'] }}</span>
                    <span class="text-[10px] font-semibold">{{ $point['value'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card p-5">
        <h2 class="font-semibold mb-4">Эрэлттэй сэдэв</h2>
        <div class="space-y-2">
            @forelse($trendingTopics as $tag)
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium">#{{ $tag->name }}</span>
                    <span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">{{ $tag->articles_count }}</span>
                </div>
            @empty
                <p class="text-sm text-zinc-400 text-center py-4">Сэдэв алга</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Latest + Popular --}}
<div class="grid gap-6 lg:grid-cols-2">
    <div class="card">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 px-5 py-4">
            <h2 class="font-semibold">Сүүлийн мэдээнүүд</h2>
            <a href="{{ route('admin.articles.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Бүгд →</a>
        </div>
        <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
            @forelse($latestArticles as $article)
                <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-sm font-medium hover:text-blue-600 line-clamp-1">{{ $article->title }}</a>
                        <div class="mt-0.5 flex items-center gap-2 text-xs text-zinc-500">
                            @if($article->category)<span class="badge" style="background: {{ $article->category->color }}20; color: {{ $article->category->color }}">{{ $article->category->name }}</span>@endif
                            <span>{{ $article->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <span class="badge {{ $article->status === 'published' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600' }}">
                        {{ $article->status === 'published' ? 'Нийтэлсэн' : ($article->status === 'draft' ? 'Ноорог' : 'Архив') }}
                    </span>
                </div>
            @empty
                <p class="px-5 py-8 text-center text-sm text-zinc-400">Мэдээ алга</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 px-5 py-4">
            <h2 class="font-semibold">Эрэлттэй мэдээнүүд</h2>
        </div>
        <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
            @forelse($popularArticles as $i => $article)
                <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-xs font-bold">{{ $i + 1 }}</span>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-sm font-medium hover:text-blue-600 line-clamp-1">{{ $article->title }}</a>
                        <p class="mt-0.5 text-xs text-zinc-500">{{ number_format($article->views_count) }} үзэлт</p>
                    </div>
                </div>
            @empty
                <p class="px-5 py-8 text-center text-sm text-zinc-400">Мэдээ алга</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Recent activity --}}
<div class="card mt-6">
    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 px-5 py-4">
        <h2 class="font-semibold">Сүүлийн үйлдэл</h2>
        <a href="{{ route('admin.reports.index', ['tab' => 'audit']) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Лог →</a>
    </div>
    <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
        @forelse($recentActivity as $a)
            <div class="flex items-center gap-3 px-5 py-3 text-sm">
                <span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">{{ $a->action }}</span>
                <span class="flex-1 truncate">{{ $a->description ?: $a->subject_type }}</span>
                <span class="text-xs text-zinc-400">{{ $a->user?->name ?? 'system' }} · {{ $a->created_at->diffForHumans() }}</span>
            </div>
        @empty
            <p class="px-5 py-8 text-center text-sm text-zinc-400">Үйлдэл алга</p>
        @endforelse
    </div>
</div>
@endsection
