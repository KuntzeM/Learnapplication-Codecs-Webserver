@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    <div class="mce-content-body ">
        {!! $html !!}
    </div>


@stop