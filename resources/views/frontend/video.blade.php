@extends('frontend.master')

{!!Html::script('http://cdn.dashjs.org/latest/dash.all.min.js')!!}

@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')
    <div class="jumbotron">
        @include('frontend.file_grid', ['files'=>$files])
        <a href="#" class="tooltip_icon second" data-toggle="tooltip" data-placement="top"
           title="2. Wählen ein Kodierungsverfahren für die linke Seite aus!"><img width="32" alt="2" src="img/2.gif"/></a>
        <a href="#" class="tooltip_icon fourth" data-toggle="tooltip" data-placement="top"
           title="4. Wähle eine Vergleichsmethode aus! Über den Slider (alternativ + und -) kann gezoomt werden. Mit den Tasten W, A, S, D kann das Bild/Video verschoben werden."><img
                    width="32" alt="4" src="img/4.gif"/></a>
        <div id="codec_selection">
            {!! Form::select('media_file_1_select', array(), null, array('class' => 'form-control codec_select', 'disabled')) !!}
            <div id="mode_group">
                <button disabled title="Dualview" alt="Dualview" id="button_dualview" data-mode="dualview"
                        class="btn btn-success">
                    <img src="img/dualview.gif"/></button>
                <!--<button title="Splitview" alt="Splitview" id="button_splitview" data-mode="splitview"
                        class="btn btn-default"><img src="img/splitview.gif"/></button> -->
                <button disabled title="Overview" alt="Overview" id="button_overview" data-mode="overview"
                        class="btn  btn-default">
                    <img src="img/overview.gif"/></button>
                <div id="zoom">
                    <a class="tooltip_icon glyphicon glyphicon-zoom-out" data-toggle="tooltip" data-placement="top"
                       title="Drücke -"></a><input disabled type="range" id="zoom-bar" value="1" min="1" max="4"
                                                   step="0.1"/><a class="tooltip_icon glyphicon glyphicon-zoom-in"
                                                                  data-toggle="tooltip" data-placement="top"
                                                                  title="Drücke +"></a>
                    <span class="zoom-factor">1.0x</span>
                </div>
            </div>

            {!! Form::select('media_file_2_select', array(), null, array('class' => 'form-control codec_select', 'disabled')) !!}
        </div>
        <a href="#" class="tooltip_icon third" data-toggle="tooltip" data-placement="top"
           title="3. Wähle das zweite Kodierungsverfahren zum vergleichen aus!"><img width="32" alt="3"
                                                                                     src="img/3.gif"/></a>
    </div>
    <!-- Video Controls -->
    <div id="video-controls">

        <input type="range" disabled id="seek-bar" value="0"/>
        <span id="current_time">-- / --</span>
        <button type="button" disabled class="btn btn-success glyphicon glyphicon-play" id="play-pause"></button>

    </div>
    <div id="informations" style="display: none">
        <div class="information_1">
            <p>
                <label>codec:</label><span class="codec"></span>
            </p>
            <p>
                <label>bitrate:</label><span class="bitrate"></span>
            </p>
            <p>
                <label>file size:</label><span class="filesize"></span>
            </p>
        </div>
        <div class="information information_2">
            <p>
                <label>codec:</label><span class="codec"></span>
            </p>
            <p>
                <label>bitrate:</label><span class="bitrate"></span>
            </p>
            <p>
                <label>file size:</label><span class="filesize"></span>
            </p>
        </div>
    </div>
    <div id="media_files" class="dualview">
        <div class="media_file_1 stage">
            <video id="media_file_1" loop>

                <p>
                    Your browser doesn't support HTML5 video.
                </p>
            </video>
        </div>
        <div class="media_file_2 stage">
            <video id="media_file_2" loop>

                <p>
                    Your browser doesn't support HTML5 video.
                </p>
            </video>
        </div>
    </div>

    <article id="documentations">
        <div id="media_file_1_documentation"></div>
        <div id="media_file_2_documentation"></div>
    </article>


    <script>
        $(function () {
            $('.open_grid').click(function () {
                $('#grid').toggle();
            });

            $('.select_media').click(function () {
                selectMediaFile($(this).children('button')[0], '{!! csrf_token() !!}', "{!! $url !!}");
            });

            $('#play-pause').click(function () {
                if ($('#media_file_1').get(0).paused == true) {
                    $('#media_file_1').get(0).play();
                    $('#media_file_2').get(0).play();
                    $(this).removeClass('glyphicon-play');
                    $(this).removeClass('btn-success');
                    $(this).addClass('glyphicon-pause');
                    $(this).addClass('btn-warning');
                } else {
                    $('#media_file_1').get(0).pause();
                    $('#media_file_2').get(0).pause();
                    $(this).removeClass('glyphicon-pause');
                    $(this).removeClass('btn-warning');
                    $(this).addClass('glyphicon-play');
                    $(this).addClass('btn-success');
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

                $('#current_time').text(Math.round($('#media_file_1').get(0).currentTime * 100) / 100 + ' s / ' + Math.round($('#media_file_1').get(0).duration * 100) / 100 + ' s');
                // Update the slider value
                $('#seek-bar').val(value);
            });
            $('#media_file_1').get(0).addEventListener("ended", function () {
                //$('#play-pause').text('play');
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