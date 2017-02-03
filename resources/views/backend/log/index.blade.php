@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')



    <h3 class="item_details">Log</h3>

    <textarea style="width: 100%; height: 400px;">
        @foreach($log as $l)
            {{ $l->level }}: {{ $l->message }}
        @endforeach
    </textarea>
@stop