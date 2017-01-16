/**
 * Created by mathias on 13.11.16.
 */

function checkMediaServerStatus(url, element){

    $.ajax({
        url: url,
        cache: false,
        crossDomain: true,
        dataType: 'json',
        error: function(data){
            console.log('timeout');
            if($('#server_status').length == 0){
                $(element).append("<div id='server_status' class='alert alert-danger'><strong>Error!</strong> No Connection to MediaServer!</div>");
            }

        },
        success: function(data){
            $('#server_status').remove();
            //console.log(data);
        },
        timeout: 100 // sets timeout to 1 second
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