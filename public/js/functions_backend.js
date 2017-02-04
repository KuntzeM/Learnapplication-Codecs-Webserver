/**
 * Created by mathias on 13.11.16.
 */

function checkMediaServerStatus(url, element){

    $.ajax({
        url: url,
        cache: false,
        crossDomain: true,
        type: 'GET',
        dataType: "json",
        error: function(data){
            console.log('timeout');

            if($('#server_status').length == 0){
                $(element).append("<div id='server_status' class='alert alert-danger'><strong>Error!</strong> No Connection to MediaServer!</div>");
            }

        },
        success: function(data){
            console.log(data);
            $('#server_status').remove();
            //console.log(data);
        },
        timeout: 1000 // sets timeout to 1 second
    });
}

function getTranscodingProcesses(token, element) {
    $.ajax({
        type: 'POST',
        data: {
            '_token': token,
        },
        url: 'admin/ajax/getTranscodingProcesses',
        error: function (data) {
            var code = '<div class="ajax_alert alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                '<strong>Error!</strong> cannot reach the media server</div> ';
            $('.alert_box').append(code);
        },
        success: function (data) {
            $('.job').addClass('remove');
            $.each(data.jobs, function (index, value) {
                if ($('#job_' + value.id).length) {
                    $('#job_' + value.id + ' .progress-bar').text(parseInt(value.process) + '%');
                    $('#job_' + value.id + ' .progress-bar').attr('aria-valuenow', parseInt(value.process));
                    $('#job_' + value.id + ' .progress-bar').css('width', parseInt(value.process) + '%');
                }

                $('#job_' + value.id).removeClass('remove');
            });
            $('.job.remove .progress-bar').text('100%');
            $('.job.remove .progress-bar').attr('aria-valuenow', 100);
            $('.job.remove .progress-bar').css('width', 100 + '%');
            $('.job.remove').fadeOut();
        }
    });
}


$(function () {
    var table = $('#log-table').DataTable({
        processing: false,
        serverSide: true,
        ajax: 'http://medienprojekt.dev/admin/log/reload',
        columns: [
            {data: 'created_at', name: 'created_at'},
            {data: 'level', name: 'level'},
            {data: 'message', name: 'message'}
        ],
        order: [0, 'desc'],
        "dom": 'l<"toolbar">frtip',
        initComplete: function () {


            this.api().columns([1]).every(function () {
                var column = this;
                var label = $('<label id="level-filter">Level Filter: </label>').appendTo($('#log-table_filter'));
                var select = $('<select><option value=""></option></select>')
                    .appendTo(label)
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                select.append('<option value="info">info</option>')
                select.append('<option value="warn">warning</option>')
                select.append('<option value="error">error</option>')
            });
        }

    });

    setInterval(function () {
        table.ajax.reload(null, false);
    }, 1000);
});
