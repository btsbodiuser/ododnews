@extends('admin.layout')
@section('title', 'Нийтлэгч нэмэх')
@section('heading', 'Нийтлэгч нэмэх')

@section('content')
<form method="POST" action="{{ route('admin.authors.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.authors._form')
</form>
@endsection
