@extends('frontend.master')


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
            <select name='media_file_1_select' class='form-control codec_select' disabled></select>
            <div id="mode_group">
                <button disabled title="Dualview" alt="Dualview" id="button_dualview" data-mode="dualview"
                        class="btn btn-success"><img src="img/dualview.gif"/></button>
                <button disabled title="Splitview" alt="Splitview" id="button_splitview" data-mode="splitview"
                        class="btn btn-default"><img src="img/splitview.gif"/></button>
                <button disabled title="Overview" alt="Overview" id="button_overview" data-mode="overview"
                        class="btn  btn-default"><img src="img/overview.gif"/></button>

                <button title="Vollbild" alt="Vollbild" id="button_fullscreen"
                        class="btn btn-default no_mode_group">Vollbild (F)
                </button>
                <div id="zoom" class="no_mode_group">
                    <a class="tooltip_icon glyphicon glyphicon-zoom-out" data-toggle="tooltip" data-placement="top"
                       title="Drücke -"></a><input disabled type="range" id="zoom-bar" value="1" min="1" max="8"
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
    <div id="informations" style="display: none">
        <div class="information information_1">
            <p>
                <label>Codec:</label><span class="codec"></span>
            </p>
            <p>
                <label>Config:</label><span class="bitrate"></span>
            </p>
            <p>
                <label>Größe:</label><span class="filesize"></span>
            </p>
            <p>
                <label>PSNR:</label><span class="psnr"></span> dB
            </p>
            <p>
                <label>SSIM:</label><span class="ssim"></span>
            </p>
        </div>
        <div class="information information_2">
            <p>
                <label>Codec:</label><span class="codec"></span>
            </p>
            <p>
                <label>Config:</label><span class="bitrate"></span>
            </p>
            <p>
                <label>Größe:</label><span class="filesize"></span>
            </p>
            <p>
                <label>PSNR:</label><span class="psnr"></span> dB
            </p>
            <p>
                <label>SSIM:</label><span class="ssim"></span>
            </p>
        </div>
    </div>
    <div id="media_files" class="dualview">
        <div class="media_file_1 stage">
            <img src="" id="media_file_1" />
        </div>
        <div class="media_file_2 stage">
            <img src="" id="media_file_2" />
        </div>
    </div>


    <div class="mce-content-body " id="media_file_1_documentation"></div>
    <div class="mce-content-body " id="media_file_2_documentation"></div>



    <script>
        $(function () {
            $('.open_grid').click(function(){
                $('#grid').toggle("fast");
            });

            $('.select_media').click(function(){

                selectMediaFile($(this).children('button')[0], '{!! csrf_token() !!}');
            })


        });

    </script>
@stop