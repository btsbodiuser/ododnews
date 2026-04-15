{{-- Shared category form partial --}}
<div class="max-w-2xl">
    <div class="card p-5 space-y-4">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="name" class="label">Нэр <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" class="input" required>
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="name_en" class="label">Англи нэр</label>
                <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $category->name_en ?? '') }}" class="input">
            </div>
        </div>

        <div>
            <label for="description" class="label">Тайлбар</label>
            <textarea id="description" name="description" rows="2" class="input">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label for="color" class="label">Өнгө</label>
                <div class="flex items-center gap-2">
                    <input type="color" id="color" name="color" value="{{ old('color', $category->color ?? '#3B82F6') }}" class="h-10 w-12 cursor-pointer rounded border border-zinc-200 p-1">
                    <input type="text" value="{{ old('color', $category->color ?? '#3B82F6') }}" class="input font-mono text-sm" oninput="document.getElementById('color').value=this.value" id="color_text">
                </div>
            </div>
            <div>
                <label for="parent_id" class="label">Дэд ангилал</label>
                <select id="parent_id" name="parent_id" class="input">
                    <option value="">— Үндсэн —</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $category->parent_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sort_order" class="label">Дараалал</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="input" min="0">
            </div>
        </div>

        <div class="flex gap-6 pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-zinc-300 dark:border-zinc-600 text-blue-600 focus:ring-blue-500 dark:bg-zinc-800"
                    {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                <span class="text-sm dark:text-zinc-300">Идэвхтэй</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="show_in_menu" value="0">
                <input type="checkbox" name="show_in_menu" value="1" class="h-4 w-4 rounded border-zinc-300 dark:border-zinc-600 text-blue-600 focus:ring-blue-500 dark:bg-zinc-800"
                    {{ old('show_in_menu', $category->show_in_menu ?? true) ? 'checked' : '' }}>
                <span class="text-sm dark:text-zinc-300">Цэсэнд харуулах</span>
            </label>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Хадгалах
        </button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Буцах</a>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('color').addEventListener('input', function() {
        document.getElementById('color_text').value = this.value;
    });
</script>
@endpush
