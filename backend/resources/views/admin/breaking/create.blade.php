@extends('admin.layout')
@section('title', 'Шинэ alert')
@section('heading', 'Шинэ яаралтай мэдээ')

@section('content')
@php $alert = null; @endphp
<form method="POST" action="{{ route('admin.breaking.store') }}">
    @include('admin.breaking._form')
</form>
@endsection
