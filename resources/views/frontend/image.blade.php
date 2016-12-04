@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    @include('frontend.file_grid', ['files'=>$files])

    <div id="media_file_1">

    </div>
    <div id="media_file_2">

    </div>

@stop