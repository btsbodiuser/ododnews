@extends('admin.layout')
@section('title', 'Кампанит засах')
@section('heading', $campaign->subject)

@section('content')
<form method="POST" action="{{ route('admin.campaigns.update', $campaign) }}">
    @method('PATCH')
    @include('admin.campaigns._form')
</form>
@endsection
