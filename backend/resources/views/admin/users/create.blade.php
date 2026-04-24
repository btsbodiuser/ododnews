@extends('admin.layout')
@section('title', 'Урих')
@section('heading', 'Шинэ хэрэглэгч урих')

@section('content')
<form method="POST" action="{{ route('admin.users.store') }}" class="card max-w-xl p-6 space-y-4">
    @csrf
    <div>
        <label class="label">Нэр</label>
        <input type="text" name="name" class="input" required>
    </div>
    <div>
        <label class="label">Имэйл</label>
        <input type="email" name="email" class="input" required>
    </div>
    <div>
        <label class="label">Эрх</label>
        <select name="role" class="input">
            <option value="author">Сэтгүүлч</option>
            <option value="editor">Эрхлэгч</option>
            <option value="admin">Админ</option>
        </select>
    </div>
    <div class="flex gap-2">
        <button class="btn btn-primary">Урилга илгээх</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Болих</a>
    </div>
</form>
@endsection
