@extends('admin.layout')
@section('title', 'Кампанит үүсгэх')
@section('heading', 'Шинэ имэйл кампанит')

@section('content')
<form method="POST" action="{{ route('admin.campaigns.store') }}">
    @include('admin.campaigns._form')
</form>
@endsection
