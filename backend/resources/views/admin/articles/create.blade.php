@extends('admin.layout')
@section('title', 'Мэдээ нэмэх')
@section('heading', 'Мэдээ нэмэх')

@section('content')
<form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.articles._form')
</form>
@endsection
