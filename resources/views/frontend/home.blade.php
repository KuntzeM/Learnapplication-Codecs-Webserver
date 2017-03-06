@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    {!! $html !!}


@stop