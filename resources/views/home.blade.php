@extends('layouts.app')

@section('content')

<div>
    @foreach($servers as $server)

        <server :data="{{ $server->json() }}"></server>

    @endforeach
</div>

@endsection
