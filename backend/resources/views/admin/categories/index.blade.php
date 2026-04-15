@extends('admin.layout')
@section('title', 'Ангилал')
@section('heading', 'Ангилал')

@section('actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Ангилал нэмэх
    </a>
@endsection

@section('content')
<div class="card table-wrapper">
    <table>
        <thead>
            <tr>
                <th class="w-12">#</th>
                <th>Өнгө</th>
                <th>Нэр</th>
                <th>Англи нэр</th>
                <th>Slug</th>
                <th>Мэдээ</th>
                <th>Дараалал</th>
                <th>Төлөв</th>
                <th class="w-24"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="text-zinc-400">{{ $category->id }}</td>
                    <td>
                        <div class="h-6 w-6 rounded-full border border-zinc-200" style="background: {{ $category->color ?? '#e4e4e7' }}"></div>
                    </td>
                    <td class="font-medium text-zinc-900 dark:text-zinc-100">{{ $category->name }}</td>
                    <td class="text-zinc-500 dark:text-zinc-400">{{ $category->name_en ?? '—' }}</td>
                    <td class="text-zinc-400 text-xs font-mono">{{ $category->slug }}</td>
                    <td>
                        <span class="badge bg-zinc-100 text-zinc-700">{{ $category->articles_count }}</span>
                    </td>
                    <td class="text-zinc-500 dark:text-zinc-400">{{ $category->sort_order }}</td>
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">Идэвхтэй</span>
                        @else
                            <span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400">Идэвхгүй</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Засах">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Устгахдаа итгэлтэй байна уу?')">
                                @csrf @method('DELETE')
                                <button class="rounded-lg p-1.5 text-zinc-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition-colors" title="Устгах">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="py-12 text-center text-zinc-400">Ангилал олдсонгүй</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $categories->links() }}</div>
@endsection
