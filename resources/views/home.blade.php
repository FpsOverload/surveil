@extends('layouts.app')

@section('content')

<div class="text-center">
    @foreach($servers as $server)

        <img src="{{ $server->present()->image }}" width="640" height="110" style="margin-top: 30px;">

    @endforeach
</div>

@endsection
