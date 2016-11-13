@extends('backend.master')


@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')
    Admin Area

    <script>
       // setInterval("ajaxd()", 1000);

        function ajaxd() {
            $.ajax({
                type: 'POST',
                url: '/ffmpeg/progress',
                data: {
                    'log_file': '{!! $pid !!}.log',
                    '_token': '<?php echo csrf_token() ?>',
                },
                error: $.proxy(function (data) {
                    console.log(data);
                }),
                success: $.proxy(function (data) {

                    alert(data.log_file);
                }, this)
            });

        }


    </script>

@stop