@extends('admin.layout')
@section('title', 'Зар нэмэх')
@section('heading', 'Шинэ зар')

@section('content')
<form method="POST" action="{{ route('admin.ads.store') }}" enctype="multipart/form-data">
    @include('admin.ads._form')
</form>
@endsection
