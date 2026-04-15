@extends('admin.layout')
@section('title', 'Ангилал засах')
@section('heading', 'Ангилал засах')

@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}">
    @csrf
    @method('PUT')
    @include('admin.categories._form')
</form>
@endsection
