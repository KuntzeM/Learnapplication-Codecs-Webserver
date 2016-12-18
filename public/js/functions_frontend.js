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
    $('#mode_group button').click(function(){
        $(this).removeClass('btn-default');
        $(this).siblings().removeClass('btn-success');
        $(this).addClass('btn-success');
        $('#media_files').removeClass();
        

        $('#media_files').addClass($(this).attr('data-mode'));
        if($(this).attr('data-mode') == 'splitview'){
            $('#media_files.splitview').imagesCompare({
                initVisibleRatio: 0.2,
                interactionMode: "drag",
                addSeparator: true,
                addDragHandle: true,
                animationDuration: 450,
                animationEasing: "linear",
                precision: 2
            });
        }else{
            $('#media_files').unbind().removeData();
            $('#media_files').removeAttr('style');
            $('.images-compare-separator').remove();
            $('.images-compare-handle').remove();
            $('#media_files div').removeAttr('class');
            $('#media_files div').removeAttr('class');
            $('#media_files div').removeAttr('style');
            $('#media_files div').removeAttr('ratio');

        }

    })
});