@extends('layouts.app')

@section('content')

<div class="text-center">
    @foreach($servers as $server)

        <server image="{{ $server->present()->image }}"></server>

    @endforeach
</div>

@endsection
