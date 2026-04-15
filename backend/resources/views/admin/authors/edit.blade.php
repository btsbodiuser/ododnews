@extends('admin.layout')
@section('title', 'Нийтлэгч засах')
@section('heading', 'Нийтлэгч засах')

@section('content')
<form method="POST" action="{{ route('admin.authors.update', $author) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.authors._form')
</form>
@endsection
