@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')



    @include('backend.codecs.table', ['name'=>'Video', 'codecs'=>$video_codecs])
    @include('backend.codecs.table', ['name'=>'Image', 'codecs'=>$image_codecs])

    <script language="JavaScript">
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

        $('.activate_config').click(function () {

            $.ajax({
                type: 'POST',
                url: '/admin/ajax/activate_codec_config',
                data: {
                    'codec_config_id': $(this).attr('data-id'),
                    '_token': '<?php echo csrf_token() ?>',
                },
                error: $.proxy(function (data) {
                    var code = '<div class="ajax_alert alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                            '<strong>Error!</strong> codec configuration couldn\'t change! </div> ';
                    $(code).insertAfter('.navbar');

                    $(".ajax_alert ").fadeTo(2000, 500).slideUp(500, function () {
                        $(this).remove();
                    });
                }),
                success: $.proxy(function (data) {

                    var code = '<div class="ajax_alert alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                            '<strong>Success!</strong> codec configuration ' + data.name + ' is ' + data.active_msg + ' </div> ';
                    $(code).insertAfter('.navbar');

                    $(".ajax_alert ").fadeTo(2000, 500).slideUp(500, function () {
                        $(this).remove();
                    });

                    if ($(this).hasClass('btn-success')) {
                        $(this).children('span').removeClass('glyphicon-ok-circle');
                        $(this).removeClass('btn-success');
                        $(this).children('span').addClass('glyphicon-remove-circle');
                        $(this).addClass('btn-danger');
                    } else {
                        $(this).children('.glyphicon').removeClass('glyphicon-remove-circle');
                        $(this).removeClass('btn-danger');
                        $(this).children('span').addClass('glyphicon-ok-circle');
                        $(this).addClass('btn-success');
                    }
                }, this)


            });
        });



    </script>

@stop