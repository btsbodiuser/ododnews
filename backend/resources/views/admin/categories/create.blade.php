@extends('admin.layout')
@section('title', 'Ангилал нэмэх')
@section('heading', 'Ангилал нэмэх')

@section('content')
<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    @include('admin.categories._form')
</form>
@endsection
