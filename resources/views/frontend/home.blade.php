@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    <a id="top_arrow" href="#top"><i class="glyphicon glyphicon-menu-up"></i></a>
    <div class="mce-content-body ">

        {!! $html !!}
    </div>


@stop