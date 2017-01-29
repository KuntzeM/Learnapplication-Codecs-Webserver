/**
 * Created by mathias on 13.11.16.
 */

function skipVideoFromSlider(videoTag) {

    var time = $(videoTag).get(0).duration * ($('#seek-bar').val() / 100.0);
    // Update the video time
    $(videoTag).get(0).currentTime = time;
}

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
            console.log(data.message);
        },
        success: function(data){

            obj = data['media']; //JSON.parse(data['media']);
            console.log(obj);
            function sortfunction(a, b) {
                return (a.codec_name < b.codec_name ? -1 : (a.codec_name > b.codec_name ? 1 : 0));
            }

            obj.sort(sortfunction);
            console.log(obj);
            var currentLine = ' ';
            $('select[name=media_file_1_select] optgroup').remove();
            $('select[name=media_file_2_select] optgroup').remove();
            for(var i=0; i<obj.length; i++){
                if(obj[i].codec_name == null){
                    continue;
                }
                if(currentLine != obj[i].codec_name){
                    currentLine = obj[i].codec_name;

                    var group = '<optgroup label="' + currentLine + '" id="' + currentLine.replace('.', '') + '"></optgroup>';
                    $('select[name=media_file_1_select]').append(group);
                    $('select[name=media_file_2_select]').append(group);
                }

                var element = '<option value="' + obj[i].media_codec_config_id + '">'+currentLine + ' ' + obj[i].codec_config_name+'</option>';
                $('select[name=media_file_1_select] optgroup#' + currentLine.replace('.', '')).append(element);
                $('select[name=media_file_2_select] optgroup#' + currentLine.replace('.', '')).append(element);

            }
            $('select[name=media_file_1_select] option').first().attr('select', 'select');
            $('select[name=media_file_1_select] option').trigger('change');
            $('select[name=media_file_2_select] option').first().next().next().attr('select', 'select');
            $('select[name=media_file_2_select] option').trigger('change');


            $('.codec_select').attr('disabled', false);
            $('#button_splitview').attr('disabled', false);
            $('#button_overview').attr('disabled', false);

        }
    });

}

$(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('select[name=media_file_1_select]').change(function(){
        if ($('#media_file_1').is('video')) {

            $('#media_file_1 source').remove();
            $('<source />').appendTo('#media_file_1');
            $('#media_file_1 source').attr('src', url + '/public/media_codec/' + $(this).val());
            $('#media_file_1')[0].load();

            if ($('#media_file_2').get(0).paused == false) {
                $('#media_file_1').get(0).play();
            }


            $('#media_file_1').onloadeddata = function () {
                skipVideoFromSlider('#media_file_1');
            };

            $('#video-controls *').attr('disabled', false);

        } else {
            $('#media_file_1').attr('src', url + '/public/media_codec/' + $(this).val());
        }
        $('#informations').show();

        $.ajax({
            url: '/ajax/get_codec_documentation',
            type: 'get',
            data: {
                media_codec_config_id:  $(this).val(),
                type: 'compare'
            },
            cache: false,
            error: function(data){
                console.log(data.message);
            },
            success: function(data){

                $('#media_file_1_documentation').html(data['documentation'])
                $('.information_1 .codec').html(data['codec']);
                $('.information_1 .bitrate').html(data['config']);
                $('.information_1 .filesize').html(Math.round(1000 * parseFloat(data['size']) / 1024 / 1024) / 1000 + ' MB');

            }
        });


    });
    $('select[name=media_file_2_select]').change(function(){
        if ($('#media_file_2').is('video')) {
            $('#media_file_2 source').remove();
            $('<source />').appendTo('#media_file_2');
            $('#media_file_2 source').attr('src', url + '/public/media_codec/' + $(this).val());
            $('#media_file_2')[0].load();

            if ($('#media_file_1').get(0).paused == false) {
                $('#media_file_2').get(0).play();
            }

            $('#media_file_2').onloadeddata = function () {
                skipVideoFromSlider('#media_file_2');
            };

        } else {
            $('#media_file_2').attr('src', url + '/public/media_codec/' + $(this).val());
        }

        $.ajax({
            url: '/ajax/get_codec_documentation',
            type: 'get',
            data: {
                media_codec_config_id: $(this).val(),
                type: 'compare'
            },
            cache: false,
            error: function (data) {
                console.log(data.message);
            },
            success: function (data) {

                $('#media_file_2_documentation').html(data['documentation'])
                $('.information_2 .codec').html(data['codec']);
                $('.information_2 .bitrate').html(data['config']);
                $('.information_2 .filesize').html(Math.round(100 * parseFloat(data['size']) / 1024 / 1024) / 100 + ' MB');

            }
        });
    });
    $('#mode_group button').click(function(){
        $(this).removeClass('btn-default');
        $(this).siblings().removeClass('btn-success');
        $(this).addClass('btn-success');
        $('#media_files').removeClass();
        $(this).attr('disabled', true);
        $(this).siblings().attr('disabled', false);


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
