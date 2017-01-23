@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    @include('frontend.file_grid', ['files'=>$files])

    <div id="codec_selection">
        {!! Form::select('media_file_1_select', array(), null, array('class' => 'form-control codec_select')) !!}
        <div id="mode_group">
            <button title="Dualview" alt="Dualview" id="button_dualview" data-mode="dualview" class="btn btn-success"><img src="img/dualview.gif" /></button>
            <button title="Splitview" alt="Splitview" id="button_splitview" data-mode="splitview" class="btn btn-default"><img src="img/splitview.gif" /></button>
            <button title="Overview" alt="Overview" id="button_overview" data-mode="overview" class="btn  btn-default"><img src="img/overview.gif" /></button>
        </div>

        {!! Form::select('media_file_2_select', array(), null, array('class' => 'form-control codec_select')) !!}
    </div>

    <div id="media_files" class="dualview">
        <div>
            <img src="" id="media_file_1" />
        </div>
        <div>
            <img src="" id="media_file_2" />
        </div>
    </div>


    <div id="media_file_1_documentation"></div>
    <div id="media_file_2_documentation"></div>



    <script>
        $(function () {
            $('.open_grid').click(function(){
                $('#grid').toggle("slow");
            });

            $('.select_media').click(function(){
                selectMediaFile($(this).children('button')[0], '{!! csrf_token() !!}', "{!! $url !!}");
            })


        });

    </script>
@stop