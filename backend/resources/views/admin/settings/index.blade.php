@extends('admin.layout')
@section('title', 'Тохиргоо')
@section('heading', 'Сайтын тохиргоо')

@section('content')
<div x-data="{ tab: 'general' }">
    <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-800 mb-6">
        @foreach(['general' => 'Үндсэн', 'social' => 'Сошиал', 'analytics' => 'Аналитик', 'mail' => 'Имэйл'] as $key => $label)
            <button @click="tab = '{{ $key }}'" :class="tab === '{{ $key }}' ? 'text-blue-600 border-blue-600' : 'text-zinc-500 border-transparent'" class="px-4 py-2 text-sm font-medium border-b-2">{{ $label }}</button>
        @endforeach
    </div>

    {{-- General --}}
    <div x-show="tab === 'general'">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="card p-6 max-w-2xl space-y-4">
            @csrf @method('PATCH')
            <input type="hidden" name="group" value="general">
            <div>
                <label class="label">Сайтын нэр</label>
                <input name="site_name" value="{{ $settings['general']['site_name'] }}" class="input">
            </div>
            <div>
                <label class="label">Уриа</label>
                <input name="site_tagline" value="{{ $settings['general']['site_tagline'] }}" class="input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Лого</label>
                    <input type="file" name="logo" class="input" accept="image/*">
                    @if($settings['general']['logo'])<img src="{{ asset('storage/' . $settings['general']['logo']) }}" class="mt-2 h-12">@endif
                </div>
                <div>
                    <label class="label">Favicon</label>
                    <input type="file" name="favicon" class="input" accept="image/*">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label">Хэл</label>
                    <select name="language" class="input">
                        <option value="mn" @selected($settings['general']['language'] === 'mn')>Монгол</option>
                        <option value="en" @selected($settings['general']['language'] === 'en')>English</option>
                    </select>
                </div>
                <div>
                    <label class="label">Цагийн бүс</label>
                    <input name="timezone" value="{{ $settings['general']['timezone'] }}" class="input">
                </div>
            </div>
            <label class="flex items-center gap-2 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                <input type="checkbox" name="maintenance" value="1" @checked($settings['general']['maintenance'])>
                <span class="text-sm">Засварын горимд оруулах</span>
            </label>
            <button class="btn btn-primary">Хадгалах</button>
        </form>
    </div>

    {{-- Social --}}
    <div x-show="tab === 'social'" x-cloak>
        <form method="POST" action="{{ route('admin.settings.update') }}" class="card p-6 max-w-2xl space-y-4">
            @csrf @method('PATCH')
            <input type="hidden" name="group" value="social">
            @foreach($settings['social'] as $key => $val)
                <div>
                    <label class="label capitalize">{{ $key }} URL</label>
                    <input name="{{ $key }}" value="{{ $val }}" class="input" placeholder="https://...">
                </div>
            @endforeach
            <button class="btn btn-primary">Хадгалах</button>
        </form>
    </div>

    {{-- Analytics --}}
    <div x-show="tab === 'analytics'" x-cloak>
        <form method="POST" action="{{ route('admin.settings.update') }}" class="card p-6 max-w-2xl space-y-4">
            @csrf @method('PATCH')
            <input type="hidden" name="group" value="analytics">
            <div>
                <label class="label">Google Analytics ID</label>
                <input name="ga_id" value="{{ $settings['analytics']['ga_id'] }}" class="input" placeholder="G-XXXXXXX">
            </div>
            <div>
                <label class="label">Facebook Pixel ID</label>
                <input name="fb_pixel" value="{{ $settings['analytics']['fb_pixel'] }}" class="input">
            </div>
            <div>
                <label class="label">Custom &lt;head&gt; HTML</label>
                <textarea name="head_html" rows="5" class="input font-mono text-xs">{{ $settings['analytics']['head_html'] }}</textarea>
            </div>
            <div>
                <label class="label">Custom &lt;body&gt; HTML</label>
                <textarea name="body_html" rows="5" class="input font-mono text-xs">{{ $settings['analytics']['body_html'] }}</textarea>
            </div>
            <button class="btn btn-primary">Хадгалах</button>
        </form>
    </div>

    {{-- Mail --}}
    <div x-show="tab === 'mail'" x-cloak>
        <form method="POST" action="{{ route('admin.settings.update') }}" class="card p-6 max-w-2xl space-y-4">
            @csrf @method('PATCH')
            <input type="hidden" name="group" value="mail">
            <div>
                <label class="label">Драйвер</label>
                <select name="driver" class="input">
                    <option value="smtp" @selected($settings['mail']['driver'] === 'smtp')>SMTP</option>
                    <option value="mailchimp" @selected($settings['mail']['driver'] === 'mailchimp')>Mailchimp</option>
                </select>
            </div>
            <div>
                <label class="label">Mailchimp API key</label>
                <input name="mailchimp_key" value="{{ $settings['mail']['mailchimp_key'] }}" class="input">
            </div>
            <div>
                <label class="label">Mailchimp List ID</label>
                <input name="mailchimp_list" value="{{ $settings['mail']['mailchimp_list'] }}" class="input">
            </div>
            <button class="btn btn-primary">Хадгалах</button>
        </form>
    </div>
</div>

<style>[x-cloak] { display: none !important; }</style>
@endsection
