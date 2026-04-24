@extends('admin.layout')
@section('title', 'Хэрэглэгч засах')
@section('heading', 'Хэрэглэгч засах')

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}" class="card max-w-xl p-6 space-y-4">
    @csrf @method('PATCH')
    <div>
        <label class="label">Нэр</label>
        <input type="text" name="name" value="{{ $user->name }}" class="input" required>
    </div>
    <div>
        <label class="label">Имэйл</label>
        <input type="email" name="email" value="{{ $user->email }}" class="input" required>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="label">Эрх</label>
            <select name="role" class="input">
                @foreach(['author' => 'Сэтгүүлч', 'editor' => 'Эрхлэгч', 'admin' => 'Админ'] as $k => $v)
                    <option value="{{ $k }}" @selected(($user->role ?? 'author') === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label">Төлөв</label>
            <select name="status" class="input">
                @foreach(['active' => 'Идэвхтэй', 'suspended' => 'Хориглосон', 'invited' => 'Урилгатай'] as $k => $v)
                    <option value="{{ $k }}" @selected(($user->status ?? 'active') === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label class="label">Шинэ нууц үг (заавал биш)</label>
        <input type="password" name="password" class="input" minlength="8">
    </div>
    <div class="flex gap-2">
        <button class="btn btn-primary">Хадгалах</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Болих</a>
    </div>
</form>
@endsection
