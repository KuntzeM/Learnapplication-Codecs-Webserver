/**
 * Created by mathias on 13.11.16.
 */

function selectMediaFile(element, token, url) {
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
                var element = '<option value="' + obj[i].media_codec_config_id + '">'+currentLine + ' ' + obj[i].codec_config_name+'</option>';
                $('select[name=media_file_1_select] optgroup#'+currentLine).append(element);
                $('select[name=media_file_2_select] optgroup#'+currentLine).append(element);

            }
            $('select[name=media_file_1_select] option').first().attr('select', 'select')
            $('select[name=media_file_1_select] option').trigger('change');
            $('select[name=media_file_2_select] option').first().next().next().attr('select', 'select')
            $('select[name=media_file_2_select] option').trigger('change');
            //$('.cocoen').cocoen();
        }
    });


}

$(function(){
    $('select[name=media_file_1_select]').change(function(){
        //$('#media_file_1').children('img').remove();
        //var img = '<img src="' + url + '/public/media_codec/' + $(this).val() + '" />';
        $('#media_file_1').attr('src', url + '/public/media_codec/' + $(this).val());
    });
    $('select[name=media_file_2_select]').change(function(){
        $('#media_file_2').attr('src', url + '/public/media_codec/' + $(this).val());
    });
});