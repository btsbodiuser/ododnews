{{--
    Media Picker Modal - Reusable component
    Usage: @include('admin.media._picker')

    Open from JS: openMediaPicker({ inputName, multiple, onSelect(files) })
    Each file: { id, url, path, original_name, mime_type, size_human, folder }
--}}
<div id="media-picker-overlay" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm hidden" onclick="closeMediaPicker()"></div>
<div id="media-picker-modal" class="fixed inset-4 lg:inset-10 z-[70] bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 hidden flex flex-col overflow-hidden">
    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-3 border-b border-zinc-200 dark:border-zinc-800">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Медиа сан</h3>
        <div class="flex items-center gap-3">
            <label class="btn btn-primary btn-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Файл оруулах
                <input type="file" multiple class="hidden" id="picker-file-input" onchange="pickerUploadFiles(this.files)">
            </label>
            <button onclick="closeMediaPicker()" class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex items-center gap-3 px-5 py-3 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/50">
        <input type="text" id="picker-search" placeholder="Хайх..." class="input flex-1" oninput="pickerDebounceLoad()">
        <select id="picker-folder" class="input w-40" onchange="pickerLoadMedia()">
            <option value="">Бүх хавтас</option>
            <option value="general">Ерөнхий</option>
            <option value="articles">Мэдээ</option>
            <option value="authors">Нийтлэгч</option>
        </select>
        <select id="picker-type" class="input w-40" onchange="pickerLoadMedia()">
            <option value="images">Зураг</option>
            <option value="">Бүгд</option>
        </select>
    </div>

    {{-- Upload progress --}}
    <div id="picker-upload-progress" class="hidden px-5 py-2 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center gap-3">
            <div class="h-2 flex-1 rounded-full bg-zinc-200 dark:bg-zinc-700 overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full transition-all duration-500 w-0" id="picker-upload-bar"></div>
            </div>
            <span class="text-sm text-zinc-500" id="picker-upload-text">0%</span>
        </div>
    </div>

    {{-- Grid --}}
    <div class="flex-1 overflow-y-auto p-4" id="picker-grid-wrap">
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3" id="picker-grid"></div>
        <div class="text-center py-8 text-zinc-400 hidden" id="picker-empty">
            <svg class="w-12 h-12 mx-auto mb-3 text-zinc-200 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm">Медиа файл олдсонгүй</p>
        </div>
        <div class="text-center py-4 hidden" id="picker-load-more">
            <button onclick="pickerLoadMore()" class="btn btn-secondary btn-sm">Цааш үзэх</button>
        </div>
    </div>

    {{-- Footer --}}
    <div class="flex items-center justify-between px-5 py-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/50">
        <span class="text-sm text-zinc-500" id="picker-selected-info">Сонгогдсон: 0</span>
        <div class="flex gap-2">
            <button onclick="closeMediaPicker()" class="btn btn-secondary btn-sm">Болих</button>
            <button onclick="pickerConfirm()" class="btn btn-primary btn-sm" id="picker-confirm-btn" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Сонгох
            </button>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
(function() {
    const pickerState = {
        isOpen: false,
        multiple: false,
        selected: new Map(), // id -> file object
        onSelect: null,
        page: 1,
        nextPage: null,
        debounceTimer: null,
    };

    const browseUrl = '{{ route("admin.media.browse") }}';
    const storeUrl = '{{ route("admin.media.store") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Public API
    window.openMediaPicker = function(opts = {}) {
        pickerState.multiple = opts.multiple || false;
        pickerState.onSelect = opts.onSelect || null;
        pickerState.selected.clear();
        pickerState.page = 1;

        document.getElementById('media-picker-overlay').classList.remove('hidden');
        document.getElementById('media-picker-modal').classList.remove('hidden');
        document.getElementById('picker-search').value = '';
        document.getElementById('picker-folder').value = '';
        document.getElementById('picker-type').value = 'images';
        updatePickerFooter();
        pickerLoadMedia();
        pickerState.isOpen = true;
    };

    window.closeMediaPicker = function() {
        document.getElementById('media-picker-overlay').classList.add('hidden');
        document.getElementById('media-picker-modal').classList.add('hidden');
        pickerState.isOpen = false;
    };

    window.pickerConfirm = function() {
        if (pickerState.onSelect && pickerState.selected.size > 0) {
            const files = Array.from(pickerState.selected.values());
            pickerState.onSelect(pickerState.multiple ? files : files[0]);
        }
        closeMediaPicker();
    };

    window.pickerLoadMedia = function() {
        pickerState.page = 1;
        fetchPickerMedia(false);
    };

    window.pickerLoadMore = function() {
        if (pickerState.nextPage) {
            pickerState.page = pickerState.nextPage;
            fetchPickerMedia(true);
        }
    };

    window.pickerDebounceLoad = function() {
        clearTimeout(pickerState.debounceTimer);
        pickerState.debounceTimer = setTimeout(pickerLoadMedia, 300);
    };

    window.pickerUploadFiles = function(files) {
        const folder = document.getElementById('picker-folder').value || 'general';
        const progress = document.getElementById('picker-upload-progress');
        progress.classList.remove('hidden');

        const formData = new FormData();
        for (const file of files) formData.append('files[]', file);
        formData.append('folder', folder);
        formData.append('_token', csrfToken);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', storeUrl);
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const pct = Math.round(e.loaded / e.total * 100);
                document.getElementById('picker-upload-bar').style.width = pct + '%';
                document.getElementById('picker-upload-text').textContent = pct + '%';
            }
        };
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('picker-upload-text').textContent = '✓';
                setTimeout(() => {
                    progress.classList.add('hidden');
                    document.getElementById('picker-upload-bar').style.width = '0%';
                    pickerLoadMedia();
                }, 600);
            } else {
                document.getElementById('picker-upload-text').textContent = '✗ Алдаа';
            }
        };
        xhr.send(formData);
        document.getElementById('picker-file-input').value = '';
    };

    function fetchPickerMedia(append) {
        const params = new URLSearchParams();
        const search = document.getElementById('picker-search').value.trim();
        const folder = document.getElementById('picker-folder').value;
        const type = document.getElementById('picker-type').value;

        if (search) params.set('search', search);
        if (folder) params.set('folder', folder);
        if (type) params.set('type', type);
        params.set('page', pickerState.page);

        fetch(browseUrl + '?' + params.toString(), {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin',
        })
        .then(r => r.json())
        .then(json => {
            const grid = document.getElementById('picker-grid');
            const empty = document.getElementById('picker-empty');
            const loadMore = document.getElementById('picker-load-more');

            if (!append) grid.innerHTML = '';

            pickerState.nextPage = json.next_page;

            if (json.data.length === 0 && !append) {
                empty.classList.remove('hidden');
                loadMore.classList.add('hidden');
                return;
            }

            empty.classList.add('hidden');
            loadMore.classList.toggle('hidden', !json.next_page);

            json.data.forEach(file => {
                const isSelected = pickerState.selected.has(file.id);
                const el = document.createElement('div');
                el.className = `picker-item relative rounded-xl border-2 ${isSelected ? 'border-blue-500 ring-2 ring-blue-500/30' : 'border-zinc-200 dark:border-zinc-700'} overflow-hidden cursor-pointer hover:border-blue-400 transition-all`;
                el.dataset.id = file.id;
                el.onclick = () => togglePickerItem(file, el);

                const isImage = file.mime_type.startsWith('image/');
                el.innerHTML = `
                    <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                        ${isImage
                            ? `<img src="${file.url}" class="w-full h-full object-cover" loading="lazy" alt="">`
                            : `<div class="w-full h-full flex items-center justify-center"><svg class="w-8 h-8 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg></div>`
                        }
                    </div>
                    <div class="p-1.5">
                        <p class="text-[11px] text-zinc-600 dark:text-zinc-400 truncate">${file.original_name}</p>
                        <p class="text-[10px] text-zinc-400">${file.size_human}</p>
                    </div>
                    <div class="absolute top-1.5 right-1.5 h-5 w-5 rounded-full border-2 ${isSelected ? 'bg-blue-600 border-blue-600' : 'border-white/80 bg-white/50 dark:bg-zinc-800/50 dark:border-zinc-600'} flex items-center justify-center shadow">
                        <svg class="w-3 h-3 text-white ${isSelected ? '' : 'hidden'}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                `;
                grid.appendChild(el);
            });
        });
    }

    function togglePickerItem(file, el) {
        if (pickerState.selected.has(file.id)) {
            pickerState.selected.delete(file.id);
            el.classList.remove('border-blue-500','ring-2','ring-blue-500/30');
            el.classList.add('border-zinc-200','dark:border-zinc-700');
            el.querySelector('.absolute > svg').classList.add('hidden');
            el.querySelector('.absolute').classList.remove('bg-blue-600','border-blue-600');
            el.querySelector('.absolute').classList.add('border-white/80','bg-white/50');
        } else {
            if (!pickerState.multiple) {
                // Deselect all others
                pickerState.selected.clear();
                document.querySelectorAll('.picker-item').forEach(item => {
                    item.classList.remove('border-blue-500','ring-2','ring-blue-500/30');
                    item.classList.add('border-zinc-200','dark:border-zinc-700');
                    const dot = item.querySelector('.absolute');
                    if (dot) {
                        dot.querySelector('svg').classList.add('hidden');
                        dot.classList.remove('bg-blue-600','border-blue-600');
                        dot.classList.add('border-white/80','bg-white/50');
                    }
                });
            }
            pickerState.selected.set(file.id, file);
            el.classList.add('border-blue-500','ring-2','ring-blue-500/30');
            el.classList.remove('border-zinc-200','dark:border-zinc-700');
            el.querySelector('.absolute > svg').classList.remove('hidden');
            el.querySelector('.absolute').classList.add('bg-blue-600','border-blue-600');
            el.querySelector('.absolute').classList.remove('border-white/80','bg-white/50');
        }
        updatePickerFooter();
    }

    function updatePickerFooter() {
        const count = pickerState.selected.size;
        document.getElementById('picker-selected-info').textContent = 'Сонгогдсон: ' + count;
        document.getElementById('picker-confirm-btn').disabled = count === 0;
    }
})();
</script>
@endpush
@endonce
