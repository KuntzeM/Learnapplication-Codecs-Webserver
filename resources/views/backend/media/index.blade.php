@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')



    @include('backend.media.table', ['name'=>'Video', 'media'=>$video_media])
    @include('backend.media.table', ['name'=>'Image', 'media'=>$image_media])



@stop