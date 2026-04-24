@extends('admin.layout')
@section('title', 'Alert засах')
@section('heading', $alert->headline)

@section('content')
<form method="POST" action="{{ route('admin.breaking.update', $alert) }}">
    @method('PATCH')
    @include('admin.breaking._form')
</form>
@endsection
