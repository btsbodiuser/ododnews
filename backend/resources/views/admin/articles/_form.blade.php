{{-- Shared article form partial --}}
<div class="grid gap-6 lg:grid-cols-3">
    {{-- Main content --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Title & Excerpt --}}
        <div class="card p-5 space-y-4">
            <div>
                <label for="title" class="label">Гарчиг <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" class="input text-lg font-semibold" required placeholder="Мэдээний гарчиг...">
                @error('title') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="excerpt" class="label">Товч агуулга</label>
                <textarea id="excerpt" name="excerpt" rows="2" class="input" maxlength="500" placeholder="Мэдээний товч тайлбар...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                @error('excerpt') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- WYSIWYG Editor --}}
        <div class="card p-5">
            <label for="body" class="label mb-2">Агуулга <span class="text-red-500">*</span></label>
            <textarea id="body" name="body">{{ old('body', $article->body ?? '') }}</textarea>
            @error('body') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        {{-- Video Embed --}}
        <div class="card p-5 space-y-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/><path fill="#fff" d="M9.545 15.568V8.432L15.818 12z"/></svg>
                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">Видео</h3>
            </div>
            <div>
                <label for="featured_video" class="label">Видео URL (YouTube, Facebook, Embed)</label>
                <input type="url" id="featured_video" name="featured_video" value="{{ old('featured_video', $article->featured_video ?? '') }}" class="input" placeholder="https://www.youtube.com/watch?v=...">
                <p class="mt-1 text-xs text-zinc-400">YouTube, Facebook видео, эсвэл embed линк оруулна уу</p>
            </div>
            @if(isset($article) && $article->featured_video)
                <div class="rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-video">
                    <iframe src="{{ $article->featured_video }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>
            @endif
        </div>

        {{-- Gallery --}}
        <div class="card p-5 space-y-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">Зургийн цомог</h3>
            </div>

            {{-- Existing gallery --}}
            @if(isset($article) && $article->gallery)
                <div class="grid grid-cols-4 gap-3" id="existing-gallery">
                    @foreach($article->gallery as $i => $image)
                        <div class="relative group" id="gallery-item-{{ $i }}">
                            <img src="{{ asset('storage/' . $image) }}" class="w-full h-24 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <input type="hidden" name="existing_gallery[]" value="{{ $image }}">
                            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 hidden group-hover:flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-white text-xs shadow">×</button>
                        </div>
                    @endforeach
                </div>
            @endif

            <div>
                <div class="flex gap-2">
                    <button type="button" onclick="openMediaPicker({ multiple: true, onSelect: addGalleryFromMedia })" class="btn btn-secondary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Медиа сангаас
                    </button>
                    <label class="btn btn-secondary btn-sm cursor-pointer">
                        Файл сонгох
                        <input type="file" name="gallery_files[]" multiple accept="image/*" class="hidden">
                    </label>
                </div>
                <p class="mt-1 text-xs text-zinc-400">Нэг удаад 20 хүртэл зураг. Зураг бүр 5MB хүртэл.</p>
            </div>
        </div>

        {{-- Source Attribution --}}
        <div class="card p-5 space-y-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">Эх сурвалж</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="source_name" class="label">Эх сурвалжийн нэр</label>
                    <input type="text" id="source_name" name="source_name" value="{{ old('source_name', $article->source_name ?? '') }}" class="input" placeholder="CNN, BBC, Монцамэ...">
                </div>
                <div>
                    <label for="source_url" class="label">Эх сурвалжийн холбоос</label>
                    <input type="url" id="source_url" name="source_url" value="{{ old('source_url', $article->source_url ?? '') }}" class="input" placeholder="https://...">
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="card p-5 space-y-4">
            <div class="flex items-center gap-2 cursor-pointer" onclick="document.getElementById('seo-panel').classList.toggle('hidden')">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">SEO тохиргоо</h3>
                <svg class="w-4 h-4 text-zinc-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div id="seo-panel" class="{{ (old('seo_title', $article->seo_title ?? '') || old('seo_description', $article->seo_description ?? '')) ? '' : 'hidden' }} space-y-4">
                <div>
                    <label for="seo_title" class="label">SEO гарчиг</label>
                    <input type="text" id="seo_title" name="seo_title" value="{{ old('seo_title', $article->seo_title ?? '') }}" class="input" maxlength="255" placeholder="Хайлтын системд харагдах гарчиг...">
                    <p class="mt-1 text-xs text-zinc-400">Хоосон үед мэдээний гарчиг ашиглагдана</p>
                </div>
                <div>
                    <label for="seo_description" class="label">SEO тайлбар</label>
                    <textarea id="seo_description" name="seo_description" rows="2" class="input" maxlength="500" placeholder="Хайлтын системд харагдах тайлбар...">{{ old('seo_description', $article->seo_description ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-zinc-400">Хоосон үед товч агуулга ашиглагдана</p>
                </div>

                {{-- SEO Preview --}}
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 bg-zinc-50 dark:bg-zinc-800/50">
                    <p class="text-xs text-zinc-400 mb-2 uppercase tracking-wider font-medium">Google хайлтын урьдчилсан харагдац</p>
                    <p class="text-blue-700 dark:text-blue-400 text-base font-medium truncate" id="seo-preview-title">{{ $article->seo_title ?? $article->title ?? 'Мэдээний гарчиг' }}</p>
                    <p class="text-emerald-700 dark:text-emerald-500 text-xs mt-0.5">odod.mn › мэдээ</p>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1 line-clamp-2" id="seo-preview-desc">{{ $article->seo_description ?? $article->excerpt ?? 'Мэдээний товч тайлбар энд харагдана...' }}</p>
                </div>
            </div>
        </div>

        {{-- Tags --}}
        <div class="card p-5">
            <label class="label mb-2">Шошго</label>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <label class="inline-flex items-center gap-1.5 rounded-full border border-zinc-200 dark:border-zinc-700 px-3 py-1.5 text-sm cursor-pointer has-[:checked]:bg-blue-50 has-[:checked]:border-blue-300 has-[:checked]:text-blue-700 dark:has-[:checked]:bg-blue-900/30 dark:has-[:checked]:border-blue-700 dark:has-[:checked]:text-blue-400 dark:text-zinc-300 transition-colors">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="sr-only"
                            {{ in_array($tag->id, old('tags', isset($article) ? $article->tags->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                        {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Publish Settings --}}
        <div class="card p-5 space-y-4">
            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Нийтлэл
            </h3>
            <div>
                <label for="status" class="label">Төлөв <span class="text-red-500">*</span></label>
                <select id="status" name="status" class="input" required>
                    <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>📝 Ноорог</option>
                    <option value="published" {{ old('status', $article->status ?? '') === 'published' ? 'selected' : '' }}>✅ Нийтлэх</option>
                    <option value="archived" {{ old('status', $article->status ?? '') === 'archived' ? 'selected' : '' }}>📦 Архив</option>
                </select>
            </div>

            <div>
                <label for="category_id" class="label">Ангилал <span class="text-red-500">*</span></label>
                <select id="category_id" name="category_id" class="input" required>
                    <option value="">— Сонгох —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="author_id" class="label">Нийтлэгч <span class="text-red-500">*</span></label>
                <select id="author_id" name="author_id" class="input" required>
                    <option value="">— Сонгох —</option>
                    @foreach($authors as $author_option)
                        <option value="{{ $author_option->id }}" {{ old('author_id', $article->author_id ?? '') == $author_option->id ? 'selected' : '' }}>{{ $author_option->name }}</option>
                    @endforeach
                </select>
                @error('author_id') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="published_at" class="label">Нийтлэх огноо</label>
                <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', isset($article) && $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}" class="input">
            </div>

            @if(isset($article) && $article->reading_time)
                <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Уншихад ~{{ $article->reading_time }} мин
                </div>
            @endif
        </div>

        {{-- Featured Image --}}
        <div class="card p-5 space-y-4">
            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Нүүр зураг
            </h3>
            @if(isset($article) && $article->featured_image)
                <div class="rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700" id="featured-preview-wrap">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="" class="w-full h-40 object-cover" id="featured-preview">
                </div>
            @else
                <div class="rounded-xl border-2 border-dashed border-zinc-200 dark:border-zinc-700 p-6 text-center hidden" id="featured-preview-wrap">
                    <img src="" alt="" class="w-full h-40 object-cover rounded-lg" id="featured-preview">
                </div>
            @endif
            <input type="hidden" name="featured_image_path" id="featured_image_path" value="{{ old('featured_image_path', '') }}">
            <div class="flex gap-2">
                <button type="button" onclick="openMediaPicker({ multiple: false, onSelect: selectFeaturedImage })" class="btn btn-secondary btn-sm flex-1 justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Медиа сангаас сонгох
                </button>
                <label class="btn btn-secondary btn-sm cursor-pointer">
                    Файл
                    <input type="file" id="featured_image" name="featured_image" accept="image/*" onchange="previewFeaturedImage(this)" class="hidden">
                </label>
            </div>
            @error('featured_image') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        {{-- Article Flags --}}
        <div class="card p-5 space-y-3">
            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-1">Тохиргоо</h3>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-zinc-300 dark:border-zinc-600 text-amber-500 focus:ring-amber-500 dark:bg-zinc-800"
                    {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}>
                <span class="text-sm dark:text-zinc-300">⭐ Онцлох мэдээ</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_breaking" value="0">
                <input type="checkbox" name="is_breaking" value="1" class="h-4 w-4 rounded border-zinc-300 dark:border-zinc-600 text-red-500 focus:ring-red-500 dark:bg-zinc-800"
                    {{ old('is_breaking', $article->is_breaking ?? false) ? 'checked' : '' }}>
                <span class="text-sm dark:text-zinc-300">🔥 Яаралтай мэдээ</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_trending" value="0">
                <input type="checkbox" name="is_trending" value="1" class="h-4 w-4 rounded border-zinc-300 dark:border-zinc-600 text-blue-500 focus:ring-blue-500 dark:bg-zinc-800"
                    {{ old('is_trending', $article->is_trending ?? false) ? 'checked' : '' }}>
                <span class="text-sm dark:text-zinc-300">📈 Трэнд мэдээ</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary flex-1 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Хадгалах
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Буцах</a>
        </div>
    </div>
</div>

@push('scripts')
{{-- TinyMCE --}}
<script src="https://cdn.tiny.cloud/1/uudryvjo1tgr3yxgkc3ui32rva3dqnm8fg2gspbmby847ent/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');

    tinymce.init({
        selector: '#body',
        height: 500,
        menubar: 'file edit view insert format tools table',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount',
            'emoticons', 'codesample', 'quickbars'
        ],
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                 'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link image media | ' +
                 'table emoticons codesample | blockquote hr | ' +
                 'removeformat fullscreen code help',
        skin: isDark ? 'oxide-dark' : 'oxide',
        content_css: isDark ? 'dark' : 'default',
        branding: false,
        promotion: false,
        relative_urls: false,
        remove_script_host: false,

        // Image upload
        images_upload_url: '{{ route("admin.upload.editor-image") }}',
        images_upload_credentials: true,
        automatic_uploads: true,
        images_reuse_filename: true,
        file_picker_types: 'image media',

        // Image upload handler with CSRF
        images_upload_handler: function (blobInfo) {
            return new Promise(function (resolve, reject) {
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('{{ route("admin.upload.editor-image") }}', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) throw new Error('Зураг оруулахад алдаа гарлаа');
                    return response.json();
                })
                .then(json => resolve(json.location))
                .catch(err => reject(err.message));
            });
        },

        // Media embed
        media_live_embeds: true,
        media_url_resolver: function (data, resolve) {
            // YouTube
            if (data.url.match(/youtube\.com|youtu\.be/)) {
                const id = data.url.match(/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
                if (id) {
                    resolve({
                        html: '<iframe src="https://www.youtube.com/embed/' + id[1] +
                              '" width="100%" height="400" frameborder="0" allowfullscreen></iframe>'
                    });
                    return;
                }
            }
            resolve({ html: '' });
        },

        // Quickbars
        quickbars_selection_toolbar: 'bold italic | link blockquote',
        quickbars_insert_toolbar: 'image media table hr',

        // Content styling
        content_style: `
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                font-size: 16px;
                line-height: 1.7;
                max-width: 100%;
                padding: 1rem;
                ${isDark ? 'background: #18181b; color: #e4e4e7;' : ''}
            }
            img { max-width: 100%; height: auto; border-radius: 8px; }
            blockquote {
                border-left: 4px solid ${isDark ? '#3f3f46' : '#e4e4e7'};
                padding: 0.5rem 1rem;
                margin: 1rem 0;
                color: ${isDark ? '#a1a1aa' : '#71717a'};
                font-style: italic;
            }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid ${isDark ? '#3f3f46' : '#e4e4e7'}; padding: 8px 12px; }
            pre { background: ${isDark ? '#27272a' : '#f4f4f5'}; padding: 1rem; border-radius: 8px; overflow-x: auto; }
            a { color: #2563eb; }
            hr { border-color: ${isDark ? '#3f3f46' : '#e4e4e7'}; }
        `,

        setup: function (editor) {
            editor.on('change keyup', function () {
                editor.save();
            });
        }
    });

    // SEO preview
    document.getElementById('title')?.addEventListener('input', function () {
        const seoTitle = document.getElementById('seo_title');
        const preview = document.getElementById('seo-preview-title');
        if (preview) preview.textContent = seoTitle?.value || this.value || 'Мэдээний гарчиг';
    });
    document.getElementById('seo_title')?.addEventListener('input', function () {
        const preview = document.getElementById('seo-preview-title');
        if (preview) preview.textContent = this.value || document.getElementById('title')?.value || 'Мэдээний гарчиг';
    });
    document.getElementById('seo_description')?.addEventListener('input', function () {
        const preview = document.getElementById('seo-preview-desc');
        if (preview) preview.textContent = this.value || 'Мэдээний товч тайлбар энд харагдана...';
    });

    // Featured image preview
    function previewFeaturedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                let preview = document.getElementById('featured-preview');
                let wrap = document.getElementById('featured-preview-wrap');
                if (preview) {
                    preview.src = e.target.result;
                    if (wrap) wrap.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Media picker: select featured image
    function selectFeaturedImage(file) {
        const preview = document.getElementById('featured-preview');
        const wrap = document.getElementById('featured-preview-wrap');
        const pathInput = document.getElementById('featured_image_path');
        if (preview) {
            preview.src = file.url;
            if (wrap) {
                wrap.classList.remove('hidden', 'border-dashed', 'p-6');
                wrap.className = 'rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700';
            }
        }
        if (pathInput) pathInput.value = file.path;
    }

    // Media picker: add gallery images from media library
    function addGalleryFromMedia(files) {
        let gallery = document.getElementById('existing-gallery');
        if (!gallery) {
            gallery = document.createElement('div');
            gallery.id = 'existing-gallery';
            gallery.className = 'grid grid-cols-4 gap-3';
            const galleryCard = document.querySelector('[id="existing-gallery"]')?.parentElement
                || document.querySelector('.card:has([name="gallery_files[]"])');
            if (galleryCard) {
                galleryCard.insertBefore(gallery, galleryCard.querySelector('.flex.gap-2')?.parentElement || galleryCard.lastElementChild);
            }
        }
        files.forEach(file => {
            const idx = gallery.children.length;
            const div = document.createElement('div');
            div.className = 'relative group';
            div.id = 'gallery-item-' + idx;
            div.innerHTML = `
                <img src="${file.url}" class="w-full h-24 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700">
                <input type="hidden" name="existing_gallery[]" value="${file.path}">
                <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 hidden group-hover:flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-white text-xs shadow">×</button>
            `;
            gallery.appendChild(div);
        });
    }
</script>
@endpush

@include('admin.media._picker')
