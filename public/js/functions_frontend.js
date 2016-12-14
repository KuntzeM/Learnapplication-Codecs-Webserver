/**
 * Created by mathias on 13.11.16.
 */

function selectMediaFile(element, token) {
    console.log('test');
    $('input[type=text].open_grid').val($(element).attr('data-name'));

    $('#grid').toggle();

    $.ajax({
        url: '/ajax/get_media_config',
        type: 'post',
        data: {
            media_id:  $(element).attr('data-id'),
            '_token': token,
        },
        cache: false,
        dataType: 'json',
        error: function(data){
            console.log('error');
        },
        success: function(data){
            console.log(data);
        }
    });


}

