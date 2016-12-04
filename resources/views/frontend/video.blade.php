@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    @include('frontend.file_grid', ['files'=>$files])


@stop