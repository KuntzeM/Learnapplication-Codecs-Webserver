@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop



@section('content')
    <h3 class="item_details">Log</h3>
    <div class="form-group">
        <input class="btn btn-default" type="button" id="removeLog" value="Log löschen"/>
    </div>
    <table id="log" data-paging="true" data-sorting="true"></table>
    <script>

        function reloadLogTable(ft) {


        }

        $(function () {

            var ft = FooTable.init('#log', {
                "columns": [
                    {
                        "name": "created_at",
                        "title": "Zeit",
                        "style": {"width": 200, "height": 50},
                        "sorted": true,
                        "direction": "DESC"
                    },
                    {"name": "level", "title": "Level", "style": {"width": 150}},
                    {"name": "message", "title": "Meldung", "sortable": false}
                ],
                "rows": $.ajax({
                    type: 'GET',
                    url: '/admin/log/reload',
                    dataType: 'json'
                }),
                "filtering": {
                    "enabled": true
                },
                "components": {
                    "filtering": FooTable.MyFiltering
                },
                "paging": {
                    "limit": 10,
                    "size": 20
                }
            });

            setInterval(function (ft) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/log/reload',
                    dataType: 'json',
                    success: function (data) {
                        ft.rows.load(data);
                    }
                });
            }, 10000, ft);

            $('#removeLog').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '/admin/log/delete'
                });
            });
        });
    </script>
@stop