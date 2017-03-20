@extends('backend.master')


@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')

    <h3 class="item_details">Transcoding Queue</h3>
    <div class="panel panel-default">


        <div class="panel-heading">
                    <button type="button" id="start_transcoding" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>Start Transcoding
                    </button>

            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="name">Media File</th>
                        <th class="name">Media Type</th>
                        <th class="date">Codec</th>
                        <th>Configuration</th>
                        <!--     <th class="date">Attempts</th> -->
                        <th class="options">Process</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

    </div>
    <script>
        var flag = false;
        $('#start_transcoding').click(function () {
            flag = true;
            $.ajax({
                type: 'POST',
                url: 'admin/ajax/start_transcoding',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                },
                error: function (data) {
                    if (flag) {
                        var code = '<div class="ajax_alert alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                            '<strong>Error!</strong> cannot reach the media server</div> ';
                        $('.alert_box').append(code);
                    }
                },
                success: function (data) {
                    var code = '<div class="ajax_alert alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                            '<strong>Success!</strong> transcoding process is started</div> ';
                    $('.alert_box').append(code);
                }
            });
        });

        $(function () {
            setInterval("getTranscodingProcesses(\'<?php echo csrf_token() ?>\')", 500);
        });

    </script>
@stop