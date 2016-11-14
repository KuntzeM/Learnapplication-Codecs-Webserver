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