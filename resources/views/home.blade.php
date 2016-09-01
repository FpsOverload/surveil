@extends('layouts.app')

@section('content')

<div>
    @foreach($servers as $server)

        <server image="{{ $server->present()->image }}"></server>

    @endforeach
</div>

@endsection
