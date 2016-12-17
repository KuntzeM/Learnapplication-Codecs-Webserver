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
            obj = JSON.parse(data['media']);
            var currentLine = '';
            $('select[name=media_file_1_select] optgroup').remove();
            $('select[name=media_file_2_select] optgroup').remove();
            for(var i=0; i<obj.length; i++){
                if(currentLine != obj[i].codec_name){
                    currentLine = obj[i].codec_name;
                    var group = '<optgroup label="' + currentLine +'" id="' + currentLine + '"></optgroup>';
                    $('select[name=media_file_1_select]').append(group);
                    $('select[name=media_file_2_select]').append(group);
                }
                var element = '<option value="' + obj[i].media_codec_config_id + '">'+obj[i].codec_config_name+'</option>';
                $('select[name=media_file_1_select] optgroup#'+currentLine).append(element);
                $('select[name=media_file_2_select] optgroup#'+currentLine).append(element);

            }
        }
    });


}

$(function(){
    $('select[name=media_file_1_select]').onchange(function(){
        $('#media_file_1 img').remove();
        var img = '<img src="" />'
    });
});