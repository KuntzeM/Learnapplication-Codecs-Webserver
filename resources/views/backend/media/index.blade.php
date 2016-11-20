@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')



    @include('backend.media.table', ['name'=>'Video', 'media'=>$video_media])
    @include('backend.media.table', ['name'=>'Image', 'media'=>$image_media])

    <script>
        $('.clickable_icon').parent().click(function () {
            var a = $(this).children();
            var b = $(this).children('.clickable_icon');

            $(this).parent().siblings('.' + $(a).attr('data-row')).fadeToggle();
            if ($(b).hasClass('fa-chevron-right')) {
                $(b).removeClass('fa-chevron-right');
                $(b).addClass('fa-chevron-down');
            } else {
                $(b).removeClass('fa-chevron-down');
                $(b).addClass('fa-chevron-right');
            }
        });

    </script>

@stop