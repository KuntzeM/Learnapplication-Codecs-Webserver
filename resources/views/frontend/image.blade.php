@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    @include('frontend.file_grid', ['files'=>$files])

    <div id="codec_selection">
        {!! Form::select('media_file_1_select', array(), null, array('class' => 'form-control codec_select')) !!}
        {!! Form::select('media_file_2_select', array(), null, array('class' => 'form-control codec_select')) !!}
    </div>

    <div id="media_files">
        <img src="" class="dualview" id="media_file_1" />
        <img src="" class="dualview" id="media_file_2" />
    </div>

    <script>
        $(function () {
            $('.open_grid').click(function(){
                $('#grid').toggle();
            });

            $('.select_media').click(function(){
                selectMediaFile(this, '{!! csrf_token() !!}', "{!! $url !!}");
            })

        });

    </script>
@stop