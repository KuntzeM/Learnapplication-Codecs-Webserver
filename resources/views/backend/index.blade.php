@extends('backend.master')


@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')

    <h3 class="item_details">Transcoding Queue</h3>
    <div class="panel panel-default">

        @if (count($jobs) == 0)
            <div class="panel-body">
                No transcoding processes in queue!
            </div>
        @else
            <div class="panel-heading">
                    <button type="button" id="start_transcoding" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span>Start Transcoding
                    </button>

            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="number">#</th>
                        <th class="name">Media File</th>
                        <th class="name">Media Type</th>
                        <th class="date">Codec</th>
                        <th>Configuration</th>
                        <th class="date">Attempts</th>
                        <th class="options">Process</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            <tr id="">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $job->getMedia()->name }}</td>
                                <td>{{ $job->getMedia()->media_type }}</td>
                                <td>{{ $job->getCodecConfiguration()->codec->name  }}</td>
                                <td>{{ $job->getCodecConfiguration()->name }}</td>
                                <td>{{ $job->attempts }}</td>
                                <td>{{ $job->process }} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <script>

        $('#start_transcoding').click(function () {
            $.ajax({
                type: 'POST',
                url: 'admin/ajax/start_transcoding',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                },
                error: function (data) {
                    var code = '<div class="ajax_alert alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                            '<strong>Error!</strong> cannot reach the media server</div> ';
                    $('.alert_box').append(code);
                },
                success: function (data) {
                    var code = '<div class="ajax_alert alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                            '<strong>Success!</strong> transcoding process is started</div> ';
                    $('.alert_box').append(code);
                }
            });
        });



    </script>
@stop