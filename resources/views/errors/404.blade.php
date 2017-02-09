@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    <div class="jumbotron">
        <h1>Fehler 404</h1>
        <p>Diese Seite existiert nicht!</p>
    </div>


@stop