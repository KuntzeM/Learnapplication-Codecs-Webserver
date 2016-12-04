@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')



    @include('backend.media.table', ['name'=>'Video', 'media'=>$video_media])
    @include('backend.media.table', ['name'=>'Image', 'media'=>$image_media])

    <script>
        $(function(){


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


            $('.process_transcoding').click(function () {
                $('#transcode_' + $(this).attr('data-config-id') + '_' + $(this).attr('data-media-id')).modal('hide');
                console.log($(this).attr('data-config-id'));
                $.ajax({
                    type: 'POST',
                    url: '/admin/ajax/process_transcoding',
                    data: {
                        'media_id': $(this).attr('data-media-id'),
                        'codec_config_id': $(this).attr('data-config-id'),
                        '_token': '<?php echo csrf_token() ?>',
                    },
                    error: $.proxy(function (data) {
                        var code = '<div class="ajax_alert alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                '<strong>Error!</strong> process not success </div> ';
                        $('.alert_box').append(code);

                        $(".ajax_alert ").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).remove();
                        });
                    }),
                    success: $.proxy(function (data) {

                        var code = '<div class="ajax_alert alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                '<strong>Success!</strong> Transcoding Process is in queue! </div> ';
                        $('.alert_box').append(code);

                        $(".ajax_alert ").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).remove();
                        });
                        var b = $('.transcode_status_'+$(this).attr('data-config-id')+'_'+$(this).attr('data-media-id'));
                        if ($(b).hasClass('btn-danger')) {
                            $(b).children('.glyphicon').removeClass('glyphicon-remove-sign');
                            $(b).removeClass('btn-danger');
                            $(b).children('span').addClass('glyphicon-info-sign');
                            $(b).addClass('btn-warning');
                        }
                    }, this)


                });
            });
        });
    </script>

@stop