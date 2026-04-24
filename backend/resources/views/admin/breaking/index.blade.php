@extends('admin.layout')
@section('title', 'Яаралтай мэдээ')
@section('heading', 'Яаралтай мэдээ ба мэдэгдэл')
@section('actions')
    <a href="{{ route('admin.breaking.create') }}" class="btn btn-primary">+ Шинэ alert</a>
@endsection

@section('content')
<div class="card overflow-hidden">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>Гарчиг</th><th>Зэрэг</th><th>Төлөв</th><th>Push</th><th>Хугацаа</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($alerts as $a)
                    <tr>
                        <td class="font-medium max-w-md">{{ $a->headline }}</td>
                        <td>
                            @php $color = ['low'=>'zinc','medium'=>'blue','high'=>'amber','urgent'=>'red'][$a->priority] ?? 'zinc'; @endphp
                            <span class="badge bg-{{ $color }}-100 dark:bg-{{ $color }}-900/40 text-{{ $color }}-700 dark:text-{{ $color }}-400">{{ $a->priority }}</span>
                        </td>
                        <td><span class="badge bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">{{ $a->status }}</span></td>
                        <td>{{ $a->push_sent ? '✓ илгээсэн' : '—' }}</td>
                        <td class="text-xs text-zinc-500">{{ $a->starts_at?->format('m-d H:i') }} → {{ $a->ends_at?->format('m-d H:i') ?? '∞' }}</td>
                        <td class="space-x-1 whitespace-nowrap">
                            <a href="{{ route('admin.breaking.edit', $a) }}" class="btn btn-sm btn-secondary">Засах</a>
                            @if(! $a->push_sent)
                                <form method="POST" action="{{ route('admin.breaking.push', $a) }}" class="inline" onsubmit="return confirm('Push мэдэгдэл илгээх үү?')">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">Push</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.breaking.destroy', $a) }}" class="inline" onsubmit="return confirm('Устгах уу?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">×</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-8 text-sm text-zinc-400">Alert алга</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $alerts->links() }}</div>
@endsection
