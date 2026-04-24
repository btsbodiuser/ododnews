@extends('admin.layout')
@section('title', 'Зар засах')
@section('heading', $ad->name)

@section('content')
<form method="POST" action="{{ route('admin.ads.update', $ad) }}" enctype="multipart/form-data">
    @method('PATCH')
    @include('admin.ads._form')
</form>
@endsection
