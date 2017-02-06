@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop



@section('content')
    <h3 class="item_details">Log</h3>
    <table class="table table-bordered" id="log-table">
        <thead>
        <tr>
            <th>Zeit</th>
            <th>Level</th>
            <th>Meldung</th>
        </tr>
        </thead>
    </table>
    <script>
        $(function () {
            $('<input type="button" class="btn btn-default" value="Log löschen" />').appendTo($('.toolbar')).click(function () {
                var b = $(this);
                b.attr('disabled', true);
                $.ajax({
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    url: '/admin/log/deleteLog', //'/admin/log/debugLevel',
                    error: function (data) {
                        alert('log konnte nicht gelöscht werden');
                        $(b).attr('disabled', false);
                    },
                    success: function (data) {
                        $(b).attr('disabled', false);
                    }
                });
            });
        });
    </script>
@stop