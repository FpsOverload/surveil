@extends('layouts.app')

@section('content')

<div>
    @foreach($servers as $server)

        <server :data="{{ $server->present()->json }}"></server>

    @endforeach
</div>

@endsection
