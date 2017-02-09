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
        type: 'GET',
        data: {
            '_token': token,
        },
        url: 'admin/jobs/get',
        dataType: 'json',
        error: function (data) {
            var code = '<div class="ajax_alert alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                '<strong>Error!</strong> cannot reach the media server</div> ';
            $('.alert_box').append(code);
        },
        success: function (data) {
            $('.job').addClass('remove');
            $.each(data.jobs, function (index, value) {
                console.log(($('#job_' + value.output).length));
                if ($('#job_' + value.output.replace('.', '_')).length < 1) {
                    $('<tr class="job" id="job_' + value.output.replace('.', '_') + '">' +
                        '<td></td>' +
                        '<td>' + value.name + '</td>' +
                        '<td>' + value.media_type + '</td>' +
                        '<td>' + value.codec + '</td>' +
                        '<td>' + value.bitrate + '</td>' +
                        '<td class="process">' +
                        '<div class="progress">' +
                        '<div class="progress-bar" role="progressbar" aria-valuenow="' + value.progress + '"  aria-valuemin="0" aria-valuemax="100" style="width: ' + value.progress + '%;">' + value.progress + '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>').appendTo($('.table tbody'));
                }
                $('#job_' + value.output.replace('.', '_') + ' .progress-bar').text(parseInt(value.progress) + '%');
                $('#job_' + value.output.replace('.', '_') + ' .progress-bar').attr('aria-valuenow', parseInt(value.progress));
                $('#job_' + value.output.replace('.', '_') + ' .progress-bar').css('width', parseInt(value.progress) + '%');
                $('#job_' + value.output.replace('.', '_')).removeClass('remove');
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
        serverSide: false,
        "paging": false,
        "ordering": false,
        "info": false,
        ajax: {
            url: 'http://medienprojekt.dev/admin/log/reload',
            dataSrc: ""
        },
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

                select.append('<option value="info">info</option>');
                select.append('<option value="warn">warning</option>');
                select.append('<option value="error">error</option>');
            });
        }

    });

    /*setInterval(function () {
        table.ajax.reload(null, false);
     }, 1000);*/
});
