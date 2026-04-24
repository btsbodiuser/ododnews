@csrf
<div class="card max-w-2xl p-6 space-y-4">
    <div>
        <label class="label">Гарчиг</label>
        <input name="headline" value="{{ old('headline', $alert->headline ?? '') }}" class="input" required>
    </div>
    <div>
        <label class="label">Тайлбар</label>
        <textarea name="message" rows="3" class="input">{{ old('message', $alert->message ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Холбогдох нийтлэл</label>
            <select name="article_id" class="input">
                <option value="">— сонгох —</option>
                @foreach($articles as $art)
                    <option value="{{ $art->id }}" @selected(old('article_id', $alert->article_id ?? null) == $art->id)>{{ $art->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label">Гадаад линк</label>
            <input name="url" value="{{ old('url', $alert->url ?? '') }}" class="input" placeholder="https://...">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Зэрэг</label>
            <select name="priority" class="input">
                @foreach(['low' => 'Бага', 'medium' => 'Дунд', 'high' => 'Өндөр', 'urgent' => 'Маш яаралтай'] as $k => $v)
                    <option value="{{ $k }}" @selected(old('priority', $alert->priority ?? 'medium') === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label">Төлөв</label>
            <select name="status" class="input">
                @foreach(['draft' => 'Ноорог', 'active' => 'Идэвхтэй', 'expired' => 'Дууссан'] as $k => $v)
                    <option value="{{ $k }}" @selected(old('status', $alert->status ?? 'draft') === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Эхлэх</label>
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($alert->starts_at ?? null)->format('Y-m-d\TH:i')) }}" class="input">
        </div>
        <div>
            <label class="label">Дуусах</label>
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at', optional($alert->ends_at ?? null)->format('Y-m-d\TH:i')) }}" class="input">
        </div>
    </div>
    <div class="flex gap-2">
        <button class="btn btn-primary">Хадгалах</button>
        <a href="{{ route('admin.breaking.index') }}" class="btn btn-secondary">Болих</a>
    </div>
</div>
