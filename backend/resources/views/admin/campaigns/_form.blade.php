@csrf
<div class="grid lg:grid-cols-3 gap-6">
    <div class="card p-6 space-y-4 lg:col-span-2">
        <div>
            <label class="label">Гарчиг (subject)</label>
            <input name="subject" value="{{ old('subject', $campaign->subject ?? '') }}" class="input" required>
        </div>
        <div>
            <label class="label">HTML агуулга</label>
            <textarea name="html_body" rows="14" class="input font-mono text-xs">{{ old('html_body', $campaign->html_body ?? '') }}</textarea>
        </div>
        <div>
            <label class="label">Plain text (заавал биш)</label>
            <textarea name="plain_body" rows="6" class="input font-mono text-xs">{{ old('plain_body', $campaign->plain_body ?? '') }}</textarea>
        </div>
    </div>
    <div class="card p-6 space-y-4">
        <div>
            <label class="label">Илгээгчийн нэр</label>
            <input name="from_name" value="{{ old('from_name', $campaign->from_name ?? 'ODOD News') }}" class="input">
        </div>
        <div>
            <label class="label">Илгээгчийн имэйл</label>
            <input name="from_email" type="email" value="{{ old('from_email', $campaign->from_email ?? 'news@ododnews.mn') }}" class="input">
        </div>
        <div>
            <label class="label">Товлох (заавал биш)</label>
            <input name="scheduled_at" type="datetime-local" value="{{ old('scheduled_at', optional($campaign->scheduled_at ?? null)->format('Y-m-d\TH:i')) }}" class="input">
        </div>
        <button class="btn btn-primary w-full">Хадгалах</button>
    </div>
</div>
