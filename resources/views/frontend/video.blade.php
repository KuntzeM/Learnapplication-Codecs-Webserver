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
            <button title="Dualview" alt="Dualview" id="button_dualview" data-mode="dualview" class="btn btn-success">
                <img src="img/dualview.gif"/></button>
            <button title="Splitview" alt="Splitview" id="button_splitview" data-mode="splitview"
                    class="btn btn-default"><img src="img/splitview.gif"/></button>
            <button title="Overview" alt="Overview" id="button_overview" data-mode="overview" class="btn  btn-default">
                <img src="img/overview.gif"/></button>
        </div>

        {!! Form::select('media_file_2_select', array(), null, array('class' => 'form-control codec_select')) !!}
    </div>

    <div id="media_files" class="dualview">
        <div>
            <video id="media_file_1" id="media_file_1">
                <source src="http://127.0.0.1:3000/public/media_codec/24" type="video/mp4">
                <p>
                    Your browser doesn't support HTML5 video.
                </p>
            </video>
        </div>
        <div>
            <video id="media_file_2">
                <source src="http://127.0.0.1:3000/public/media_codec/23" type="video/mp4">
                <p>
                    Your browser doesn't support HTML5 video.
                </p>
            </video>
        </div>
    </div>
    <!-- Video Controls -->
    <div id="video-controls">
        <button type="button" class="btn btn-default" id="play-pause">Play</button>
        <input type="range" id="seek-bar" value="0"/>
    </div>
    <script>
        $(function () {
            $('.open_grid').click(function () {
                $('#grid').toggle();
            });

            $('.select_media').click(function () {
                selectMediaFile(this, '{!! csrf_token() !!}', "{!! $url !!}");
            })

            $('#play-pause').click(function () {
                if ($('#media_file_1').get(0).paused == true) {
                    $('#media_file_1').get(0).play();
                    $('#media_file_2').get(0).play();
                    $(this).text('pause');
                } else {
                    $('#media_file_1').get(0).pause();
                    $('#media_file_2').get(0).pause();
                    $(this).text('play');
                }

            });
            $('#seek-bar').change(function () {
                // Calculate the new time

                var time = $('#media_file_1').get(0).duration * ($(this).val() / 100);
                // Update the video time
                $('#media_file_1').get(0).currentTime = time;
                $('#media_file_2').get(0).currentTime = time;
            });

            $('#media_file_1').get(0).addEventListener("timeupdate", function () {
                // Calculate the slider value
                var value = (100 / $('#media_file_1').get(0).duration) * ($('#media_file_1').get(0).currentTime);

                // Update the slider value
                $('#seek-bar').val(value);
            });
            $('#media_file_1').get(0).addEventListener("ended", function () {
                $('#play-pause').text('play');
            });

        });

    </script>
@stop