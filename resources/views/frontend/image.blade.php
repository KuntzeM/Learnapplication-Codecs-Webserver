@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    @include('frontend.file_grid', ['files'=>$files])

    <div id="codec_selection">
        {!! Form::select('media_file_1_select') !!}
        {!! Form::select('media_file_2_select') !!}
    </div>

    <div id="media_files">
        <div id="media_file_1">

        </div>
        <div id="media_file_2">

        </div>
    </div>

    <script>
        $(function () {
            $('.open_grid').click(function(){
                $('#grid').toggle();
            });

            $('.select_media').click(function(){
                selectMediaFile(this, '{!! csrf_token() !!}');
            })
        });

    </script>
@stop