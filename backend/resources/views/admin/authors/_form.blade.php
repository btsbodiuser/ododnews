{{-- Shared author form partial --}}
<div class="max-w-2xl">
    <div class="card p-5 space-y-4">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="name" class="label">Нэр <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $author->name ?? '') }}" class="input" required>
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="position" class="label">Албан тушаал</label>
                <input type="text" id="position" name="position" value="{{ old('position', $author->position ?? '') }}" class="input">
            </div>
        </div>

        <div>
            <label for="bio" class="label">Намтар</label>
            <textarea id="bio" name="bio" rows="3" class="input" maxlength="1000">{{ old('bio', $author->bio ?? '') }}</textarea>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="avatar" class="label">Зураг</label>
                @if(isset($author) && $author->avatar)
                    <div class="mb-2 flex items-center gap-3" id="author-avatar-preview">
                        <img src="{{ asset('storage/' . $author->avatar) }}" alt="" class="h-12 w-12 rounded-full object-cover border border-zinc-200" id="author-avatar-img">
                        <span class="text-xs text-zinc-400">Одоогийн зураг</span>
                    </div>
                @else
                    <div class="mb-2 flex items-center gap-3 hidden" id="author-avatar-preview">
                        <img src="" alt="" class="h-12 w-12 rounded-full object-cover border border-zinc-200" id="author-avatar-img">
                        <span class="text-xs text-zinc-400">Сонгосон зураг</span>
                    </div>
                @endif
                <input type="hidden" name="avatar_path" id="avatar_path" value="">
                <div class="flex gap-2">
                    <button type="button" onclick="openMediaPicker({ multiple: false, onSelect: selectAuthorAvatar })" class="btn btn-secondary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Медиа сангаас
                    </button>
                    <label class="btn btn-secondary btn-sm cursor-pointer">
                        Файл
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
                    </label>
                </div>
                @error('avatar') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="user_id" class="label">Холбоотой хэрэглэгч</label>
                <select id="user_id" name="user_id" class="input">
                    <option value="">— Сонгох —</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ old('user_id', $author->user_id ?? '') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="social_links" class="label">Сошиал холбоос (JSON)</label>
            <input type="text" id="social_links" name="social_links"
                value="{{ old('social_links', isset($author) && $author->social_links ? json_encode($author->social_links) : '') }}"
                class="input font-mono text-sm" placeholder='{"facebook":"url","twitter":"url"}'>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Хадгалах
        </button>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Буцах</a>
    </div>
</div>

@include('admin.media._picker')

@push('scripts')
<script>
    function selectAuthorAvatar(file) {
        const preview = document.getElementById('author-avatar-preview');
        const img = document.getElementById('author-avatar-img');
        const pathInput = document.getElementById('avatar_path');
        if (img) img.src = file.url;
        if (preview) preview.classList.remove('hidden');
        if (pathInput) pathInput.value = file.path;
    }
</script>
@endpush
