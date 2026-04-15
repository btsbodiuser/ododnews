@extends('admin.layout')
@section('title', 'Медиа сан')
@section('heading', 'Медиа сан')

@section('actions')
    <button onclick="document.getElementById('upload-zone').classList.toggle('hidden')" class="btn btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        Файл оруулах
    </button>
    <button onclick="toggleSelectMode()" class="btn btn-secondary btn-sm" id="select-mode-btn">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Сонгох
    </button>
@endsection

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="card p-4 text-center">
        <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['total']) }}</p>
        <p class="text-xs text-zinc-500 mt-1">Нийт файл</p>
    </div>
    <div class="card p-4 text-center">
        <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['images']) }}</p>
        <p class="text-xs text-zinc-500 mt-1">Зураг</p>
    </div>
    <div class="card p-4 text-center">
        <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['size'] > 1048576 ? round($stats['size'] / 1048576, 1) . ' MB' : round($stats['size'] / 1024, 1) . ' KB' }}</p>
        <p class="text-xs text-zinc-500 mt-1">Нийт хэмжээ</p>
    </div>
</div>

{{-- Upload Zone (hidden by default) --}}
<div id="upload-zone" class="hidden mb-6">
    <div class="card p-6">
        <div id="drop-area" class="border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-2xl p-10 text-center hover:border-blue-400 dark:hover:border-blue-600 transition-colors cursor-pointer"
             ondrop="handleDrop(event)" ondragover="event.preventDefault(); this.classList.add('border-blue-500','bg-blue-50','dark:bg-blue-900/10')" ondragleave="this.classList.remove('border-blue-500','bg-blue-50','dark:bg-blue-900/10')">
            <svg class="w-12 h-12 mx-auto text-zinc-300 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
            <p class="text-zinc-600 dark:text-zinc-400 font-medium">Файлуудаа чирж оруулах эсвэл</p>
            <label class="inline-block mt-3 btn btn-primary btn-sm cursor-pointer">
                Файл сонгох
                <input type="file" multiple class="hidden" id="file-input" onchange="uploadFiles(this.files)">
            </label>
            <div class="flex items-center gap-4 mt-4 justify-center">
                <select id="upload-folder" class="input w-48 text-sm">
                    <option value="general">Ерөнхий</option>
                    <option value="articles">Мэдээ</option>
                    <option value="authors">Нийтлэгч</option>
                    <option value="categories">Ангилал</option>
                    @foreach($folders as $f)
                        @if(!in_array($f, ['general','articles','authors','categories']))
                            <option value="{{ $f }}">{{ $f }}</option>
                        @endif
                    @endforeach
                </select>
                <input type="text" id="new-folder" class="input w-48 text-sm" placeholder="Шинэ хавтас...">
            </div>
            <p class="text-xs text-zinc-400 mt-3">Нэг файл 10MB хүртэл. Нэг удаад 30 файл хүртэл.</p>
        </div>

        {{-- Upload Progress --}}
        <div id="upload-progress" class="hidden mt-4 space-y-2"></div>
    </div>
</div>

{{-- Filters --}}
<div class="card mb-6">
    <form method="GET" class="flex flex-wrap items-end gap-3 p-4">
        <div class="flex-1 min-w-[200px]">
            <label class="label">Хайх</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Файлын нэр..." class="input">
        </div>
        <div class="w-40">
            <label class="label">Хавтас</label>
            <select name="folder" class="input">
                <option value="">Бүгд</option>
                @foreach($folders as $f)
                    <option value="{{ $f }}" {{ request('folder') === $f ? 'selected' : '' }}>{{ $f }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-40">
            <label class="label">Төрөл</label>
            <select name="type" class="input">
                <option value="">Бүгд</option>
                <option value="images" {{ request('type') === 'images' ? 'selected' : '' }}>Зураг</option>
            </select>
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Шүүх</button>
        @if(request()->hasAny(['search', 'folder', 'type']))
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary btn-sm">Цэвэрлэх</a>
        @endif
    </form>
</div>

{{-- Bulk Actions (hidden) --}}
<div id="bulk-bar" class="hidden mb-4 card p-3 flex items-center gap-3 border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20">
    <span class="text-sm text-blue-700 dark:text-blue-400"><strong id="selected-count">0</strong> файл сонгогдсон</span>
    <button onclick="bulkDelete()" class="btn btn-danger btn-sm ml-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Устгах
    </button>
    <button onclick="cancelSelect()" class="btn btn-secondary btn-sm">Болих</button>
</div>

{{-- Media Grid --}}
<div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3" id="media-grid">
    @forelse($media as $item)
        <div class="media-item group relative rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden bg-white dark:bg-zinc-900 hover:border-blue-400 dark:hover:border-blue-600 transition-all cursor-pointer"
             data-id="{{ $item->id }}" data-url="{{ $item->url }}" data-path="{{ $item->path }}" data-name="{{ $item->original_name }}"
             onclick="handleItemClick(this)">
            {{-- Checkbox (select mode) --}}
            <div class="select-check hidden absolute top-2 left-2 z-10">
                <div class="h-5 w-5 rounded border-2 border-white/80 bg-white/50 dark:bg-zinc-800/50 flex items-center justify-center shadow">
                    <svg class="w-3 h-3 text-blue-600 hidden check-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
            </div>

            {{-- Preview --}}
            @if(str_starts_with($item->mime_type, 'image/'))
                <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                    <img src="{{ $item->url }}" alt="{{ $item->alt ?? $item->original_name }}" class="w-full h-full object-cover" loading="lazy">
                </div>
            @else
                <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg class="w-10 h-10 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
            @endif

            {{-- Info overlay --}}
            <div class="p-2">
                <p class="text-xs font-medium text-zinc-700 dark:text-zinc-300 truncate">{{ $item->original_name }}</p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-[10px] text-zinc-400">{{ $item->size_human }}</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500">{{ $item->folder }}</span>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="absolute top-2 right-2 hidden group-hover:flex items-center gap-1 no-select-mode">
                <button onclick="event.stopPropagation(); copyUrl('{{ $item->url }}')" class="h-7 w-7 rounded-lg bg-white/90 dark:bg-zinc-800/90 flex items-center justify-center text-zinc-500 hover:text-blue-600 shadow transition-colors" title="URL хуулах">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                </button>
                <button onclick="event.stopPropagation(); deleteItem({{ $item->id }}, this)" class="h-7 w-7 rounded-lg bg-white/90 dark:bg-zinc-800/90 flex items-center justify-center text-zinc-500 hover:text-red-600 shadow transition-colors" title="Устгах">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 text-center text-zinc-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-zinc-200 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="font-medium">Медиа файл олдсонгүй</p>
            <p class="text-sm mt-1">Файл оруулж эхлээрэй</p>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $media->links() }}</div>

{{-- Detail sidebar (slides in) --}}
<div id="detail-panel" class="fixed inset-y-0 right-0 z-40 w-80 bg-white dark:bg-zinc-900 border-l border-zinc-200 dark:border-zinc-800 shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex items-center justify-between p-4 border-b border-zinc-200 dark:border-zinc-800">
        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">Дэлгэрэнгүй</h3>
        <button onclick="closeDetail()" class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="detail-content"></div>
</div>
<div id="detail-overlay" class="fixed inset-0 z-30 bg-black/30 hidden" onclick="closeDetail()"></div>

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let selectMode = false;
let selectedIds = new Set();

// Upload
function uploadFiles(files) {
    const folder = document.getElementById('new-folder').value.trim() || document.getElementById('upload-folder').value;
    const progress = document.getElementById('upload-progress');
    progress.classList.remove('hidden');
    progress.innerHTML = '<div class="flex items-center gap-3"><div class="h-2 flex-1 rounded-full bg-zinc-200 dark:bg-zinc-700 overflow-hidden"><div class="h-full bg-blue-600 rounded-full transition-all duration-500 w-0" id="upload-bar"></div></div><span class="text-sm text-zinc-500" id="upload-text">Оруулж байна...</span></div>';

    const formData = new FormData();
    for (const file of files) formData.append('files[]', file);
    formData.append('folder', folder);
    formData.append('_token', csrfToken);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("admin.media.store") }}');
    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const pct = Math.round(e.loaded / e.total * 100);
            document.getElementById('upload-bar').style.width = pct + '%';
            document.getElementById('upload-text').textContent = pct + '%';
        }
    };
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('upload-text').textContent = '✓ Амжилттай!';
            setTimeout(() => location.reload(), 800);
        } else {
            document.getElementById('upload-text').textContent = '✗ Алдаа гарлаа';
            progress.classList.add('text-red-500');
        }
    };
    xhr.send(formData);
}

function handleDrop(e) {
    e.preventDefault();
    e.currentTarget.classList.remove('border-blue-500','bg-blue-50','dark:bg-blue-900/10');
    if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files);
}

// Select mode
function toggleSelectMode() {
    selectMode = !selectMode;
    selectedIds.clear();
    document.querySelectorAll('.select-check').forEach(el => el.classList.toggle('hidden', !selectMode));
    document.querySelectorAll('.no-select-mode').forEach(el => el.classList.toggle('hidden', selectMode));
    document.getElementById('bulk-bar').classList.toggle('hidden', !selectMode);
    document.getElementById('select-mode-btn').classList.toggle('btn-primary', selectMode);
    document.getElementById('select-mode-btn').classList.toggle('btn-secondary', !selectMode);
    updateSelectedCount();
    // Clear all checks
    document.querySelectorAll('.media-item').forEach(el => {
        el.classList.remove('ring-2','ring-blue-500');
        el.querySelector('.check-icon')?.classList.add('hidden');
    });
}

function cancelSelect() { if (selectMode) toggleSelectMode(); }

function handleItemClick(el) {
    if (selectMode) {
        const id = parseInt(el.dataset.id);
        const icon = el.querySelector('.check-icon');
        if (selectedIds.has(id)) {
            selectedIds.delete(id);
            el.classList.remove('ring-2','ring-blue-500');
            icon?.classList.add('hidden');
        } else {
            selectedIds.add(id);
            el.classList.add('ring-2','ring-blue-500');
            icon?.classList.remove('hidden');
        }
        updateSelectedCount();
    } else {
        showDetail(el);
    }
}

function updateSelectedCount() {
    document.getElementById('selected-count').textContent = selectedIds.size;
}

// Detail panel
function showDetail(el) {
    const url = el.dataset.url;
    const name = el.dataset.name;
    const id = el.dataset.id;
    const isImage = el.querySelector('img');

    document.getElementById('detail-content').innerHTML = `
        ${isImage ? `<img src="${url}" class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700" alt="">` : `<div class="w-full aspect-square rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center"><svg class="w-16 h-16 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg></div>`}
        <div>
            <label class="label">Файлын нэр</label>
            <p class="text-sm text-zinc-700 dark:text-zinc-300 break-all">${name}</p>
        </div>
        <div>
            <label class="label">URL</label>
            <div class="flex gap-2">
                <input type="text" value="${url}" class="input text-xs flex-1" readonly id="detail-url">
                <button onclick="copyUrl('${url}')" class="btn btn-secondary btn-sm shrink-0">Хуулах</button>
            </div>
        </div>
        <div class="flex gap-2 pt-2 border-t border-zinc-200 dark:border-zinc-700">
            <a href="${url}" target="_blank" class="btn btn-secondary btn-sm flex-1 justify-center">Нээх</a>
            <button onclick="deleteItem(${id}); closeDetail();" class="btn btn-danger btn-sm flex-1 justify-center">Устгах</button>
        </div>
    `;
    document.getElementById('detail-panel').classList.remove('translate-x-full');
    document.getElementById('detail-overlay').classList.remove('hidden');
}

function closeDetail() {
    document.getElementById('detail-panel').classList.add('translate-x-full');
    document.getElementById('detail-overlay').classList.add('hidden');
}

// Copy URL
function copyUrl(url) {
    navigator.clipboard.writeText(url);
    // Brief visual feedback
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-6 right-6 z-50 rounded-xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 px-4 py-2.5 text-sm font-medium shadow-xl';
    toast.textContent = 'URL хуулагдлаа!';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
}

// Delete single
function deleteItem(id, btn) {
    if (!confirm('Устгахдаа итгэлтэй байна уу?')) return;
    fetch(`{{ route('admin.media.index') }}/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    }).then(r => {
        if (r.ok) {
            const el = document.querySelector(`[data-id="${id}"]`);
            if (el) el.remove();
        }
    });
}

// Bulk delete
function bulkDelete() {
    if (!selectedIds.size || !confirm(`${selectedIds.size} файл устгах уу?`)) return;
    fetch('{{ route("admin.media.bulk-destroy") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ ids: [...selectedIds] }),
    }).then(r => {
        if (r.ok) location.reload();
    });
}
</script>
@endpush
@endsection
