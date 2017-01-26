@extends('frontend.master')

{!!Html::script('http://cdn.dashjs.org/latest/dash.all.min.js')!!}

@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    @include('frontend.file_grid', ['files'=>$files])

    <div id="codec_selection">
        {!! Form::select('media_file_1_select', array(), null, array('class' => 'form-control codec_select')) !!}
        <div id="mode_group">
            <button disabled title="Dualview" alt="Dualview" id="button_dualview" data-mode="dualview"
                    class="btn btn-success">
                <img src="img/dualview.gif"/></button>
            <!--<button title="Splitview" alt="Splitview" id="button_splitview" data-mode="splitview"
                    class="btn btn-default"><img src="img/splitview.gif"/></button> -->
            <button title="Overview" alt="Overview" id="button_overview" data-mode="overview" class="btn  btn-default">
                <img src="img/overview.gif"/></button>
        </div>

        {!! Form::select('media_file_2_select', array(), null, array('class' => 'form-control codec_select')) !!}
    </div>
    <!-- Video Controls -->
    <div id="video-controls">
        <button type="button" class="btn btn-default" id="play-pause">Play</button>
        <input type="range" id="seek-bar" value="0"/>
    </div>
    <div id="media_files" class="dualview">
        <div>
            <video id="media_file_1" loop>

                <p>
                    Your browser doesn't support HTML5 video.
                </p>
            </video>
        </div>
        <div>
            <video id="media_file_2" loop>

                <p>
                    Your browser doesn't support HTML5 video.
                </p>
            </video>
        </div>
    </div>


    <div id="media_file_1_documentation"></div>
    <div id="media_file_2_documentation"></div>

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
                skipVideoFromSlider('#media_file_1');
                skipVideoFromSlider('#media_file_2');
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
            $('#media_file_1').get(0).addEventListener("loadeddata", function () {
                skipVideoFromSlider('#media_file_1');
            });
            $('#media_file_2').get(0).addEventListener("loadeddata", function () {
                skipVideoFromSlider('#media_file_2');
            });

        });

    </script>

@stop