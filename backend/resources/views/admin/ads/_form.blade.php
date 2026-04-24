@csrf
<div class="card max-w-2xl p-6 space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Байршил</label>
            <select name="slot_id" class="input" required>
                @foreach($slots as $s)
                    <option value="{{ $s->id }}" @selected(old('slot_id', $ad->slot_id ?? null) == $s->id)>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label">Төрөл</label>
            <select name="type" class="input">
                @foreach(['image' => 'Зураг', 'html' => 'HTML', 'adsense' => 'Google AdSense'] as $k => $v)
                    <option value="{{ $k }}" @selected(old('type', $ad->type ?? 'image') === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label class="label">Нэр</label>
        <input name="name" value="{{ old('name', $ad->name ?? '') }}" class="input" required>
    </div>
    <div>
        <label class="label">Зураг</label>
        <input type="file" name="image" class="input" accept="image/*">
        @if(! empty($ad->image_path))<img src="{{ asset('storage/' . $ad->image_path) }}" class="mt-2 h-20">@endif
    </div>
    <div>
        <label class="label">HTML / AdSense код</label>
        <textarea name="html_code" rows="5" class="input font-mono text-xs">{{ old('html_code', $ad->html_code ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Зорилтот линк</label>
            <input name="target_url" value="{{ old('target_url', $ad->target_url ?? '') }}" class="input" placeholder="https://...">
        </div>
        <div>
            <label class="label">Гео (улсын код)</label>
            <input name="geo_targets" value="{{ old('geo_targets', $ad->geo_targets ?? '') }}" class="input" placeholder="MN,US,JP">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Эхлэх</label>
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($ad->starts_at ?? null)->format('Y-m-d\TH:i')) }}" class="input">
        </div>
        <div>
            <label class="label">Дуусах</label>
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at', optional($ad->ends_at ?? null)->format('Y-m-d\TH:i')) }}" class="input">
        </div>
    </div>
    <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $ad->is_active ?? true))> Идэвхтэй</label>
    <div class="flex gap-2">
        <button class="btn btn-primary">Хадгалах</button>
        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">Болих</a>
    </div>
</div>
