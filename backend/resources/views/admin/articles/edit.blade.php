@extends('admin.layout')
@section('title', 'Мэдээ засах')
@section('heading', 'Мэдээ засах')

@section('content')
<form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.articles._form')
</form>
@endsection
