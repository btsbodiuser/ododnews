@extends('admin.layout')
@section('title', 'SEO')
@section('heading', 'SEO ба meta')

@section('content')
@if($missingMeta > 0)
    <div class="card p-4 mb-4 border-l-4 border-amber-400">
        <p class="text-sm"><strong>{{ $missingMeta }}</strong> нийтлэлд SEO гарчиг эсвэл тайлбар дутуу байна.</p>
    </div>
@endif

<form method="POST" action="{{ route('admin.seo.update') }}" class="card p-6 max-w-3xl space-y-5">
    @csrf @method('PATCH')

    <h3 class="font-semibold">Сайтын мета</h3>
    <div>
        <label class="label">Гарчиг</label>
        <input name="site_title" value="{{ $settings['site_title'] }}" class="input">
    </div>
    <div>
        <label class="label">Тайлбар</label>
        <textarea name="site_description" rows="3" class="input">{{ $settings['site_description'] }}</textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Default OG image (URL)</label>
            <input name="default_og_image" value="{{ $settings['default_og_image'] }}" class="input">
        </div>
        <div>
            <label class="label">Twitter handle</label>
            <input name="twitter_handle" value="{{ $settings['twitter_handle'] }}" class="input" placeholder="@ododnews">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Facebook App ID</label>
            <input name="fb_app_id" value="{{ $settings['fb_app_id'] }}" class="input">
        </div>
        <div>
            <label class="label">Google Search Console verification</label>
            <input name="google_verification" value="{{ $settings['google_verification'] }}" class="input">
        </div>
    </div>

    <h3 class="font-semibold pt-4 border-t border-zinc-100 dark:border-zinc-800">Технологи</h3>
    <div class="flex items-center gap-6">
        <label class="flex items-center gap-2"><input type="checkbox" name="enable_sitemap" value="1" @checked($settings['enable_sitemap']) /> Sitemap.xml идэвхтэй</label>
        <label class="flex items-center gap-2"><input type="checkbox" name="enable_schema" value="1" @checked($settings['enable_schema']) /> Schema.org JSON-LD</label>
    </div>
    <div>
        <label class="label">robots.txt агуулга</label>
        <textarea name="robots" rows="6" class="input font-mono text-xs">{{ $settings['robots'] }}</textarea>
        <p class="mt-1 text-xs text-zinc-500">URL: <code>{{ url('/robots.txt') }}</code> · <code>{{ url('/sitemap.xml') }}</code></p>
    </div>

    <div class="flex gap-2">
        <button class="btn btn-primary">Хадгалах</button>
        <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn btn-secondary">Sitemap үзэх</a>
    </div>
</form>
@endsection
