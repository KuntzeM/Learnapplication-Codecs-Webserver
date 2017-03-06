/**
 * Created by mathias on 13.11.16.
 */

function skipVideoFromSlider(videoTag) {

    var time = $(videoTag).get(0).duration * ($('#seek-bar').val() / 100.0);
    // Update the video time
    $(videoTag).get(0).currentTime = time;
}

function getFilesize(name, num) {
    $.ajax({
        url: '/ajax/get_file_size',
        type: 'get',
        data: {
            name: name
        },
        success: function (data) {
            $('.information_' + num + ' .filesize').html(Math.round(1000 * parseFloat(data['size']) / 1024 / 1024) / 1000 + ' MB');
        }
    });
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

                var element = '<option value="' + obj[i].media_type + '/' + obj[i].file + '">' + currentLine + ' ' + obj[i].codec_config_name + '</option>';
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
            $('#zoom-bar').attr('disabled', false);
            $('#zoom-bar').val(1);
            $('#media_files div *').css('transform', 'scale(1)');

        }
    });

}

$(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('select[name=media_file_1_select]').change(function(){
        if ($('#media_file_1').is('video')) {

            $('#media_file_1 source').remove();
            $('<source />').appendTo('#media_file_1');
            $('#media_file_1 source').attr('src', url + '/getMedia/' + $(this).val());
            $('#media_file_1')[0].load();

            if ($('#media_file_2').get(0).paused == false) {
                $('#media_file_1').get(0).play();
            }


            $('#media_file_1').onloadeddata = function () {
                skipVideoFromSlider('#media_file_1');
            };

            $('#video-controls *').attr('disabled', false);

        } else {
            $('#media_file_1').attr('src', url + '/getMedia/' + $(this).val() + '?size=1920');
        }
        $('#informations').show();
        var s = this;
        $.ajax({
            url: '/ajax/get_codec_documentation',
            type: 'get',
            data: {
                name: $(s).val(),
                type: 'compare'
            },
            cache: false,
            error: function(data){
                console.log(data.message);
            },
            success: function(data){

                $('#media_file_1_documentation').html(data['documentation']);
                $('.information_1 .codec').html(data['codec']);
                $('.information_1 .bitrate').html(data['config']);
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                if (data['size'] > 0) {
                    $('.information_1 .filesize').html(Math.round(1000 * parseFloat(data['size']) / 1024) / 1000 + ' KB');
                } else {
                    setTimeout(getFilesize($(s).val(), 1), 3000);
                }


            }
        });


    });
    $('select[name=media_file_2_select]').change(function(){
        if ($('#media_file_2').is('video')) {
            $('#media_file_2 source').remove();
            $('<source />').appendTo('#media_file_2');
            $('#media_file_2 source').attr('src', url + '/getMedia/' + $(this).val());
            $('#media_file_2')[0].load();

            if ($('#media_file_1').get(0).paused == false) {
                $('#media_file_2').get(0).play();
            }

            $('#media_file_2').onloadeddata = function () {
                skipVideoFromSlider('#media_file_2');
            };

        } else {
            $('#media_file_2').attr('src', url + '/getMedia/' + $(this).val() + '?size=1920');
        }
        var s = this;
        $.ajax({
            url: '/ajax/get_codec_documentation',
            type: 'get',
            data: {
                name: $(s).val(),
                type: 'compare'
            },
            cache: false,
            error: function (data) {
                console.log(data.message);
            },
            success: function (data) {
                console.log(data);
                $('#media_file_2_documentation').html(data['documentation']);
                $('.information_2 .codec').html(data['codec']);
                $('.information_2 .bitrate').html(data['config']);
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                if (data['size'] > 0) {
                    $('.information_2 .filesize').html(Math.round(1000 * parseFloat(data['size']) / 1024) / 1000 + ' KB');
                } else {
                    setTimeout(getFilesize($(s).val(), 2), 3000);
                }

            }
        });
    });
    $('#mode_group button:not(.zoom)').click(function () {
        $(this).removeClass('btn-default');
        $(this).siblings(':not(.zoom)').removeClass('btn-success');
        $(this).addClass('btn-success');
        $('#media_files').removeClass();
        $(this).attr('disabled', true);
        $(this).siblings(':not(.zoom)').attr('disabled', false);


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
            $('#media_files div').removeClass('images-compare-before');
            $('#media_files div').removeClass('images-compare-after');
            $('#media_files div').removeAttr('style');
            $('#media_files div').removeAttr('ratio');

        }

    });

    $('#zoom-bar').on('input change', function () {
        $('#media_files div *').css('transform', 'scale(' + $(this).val() + ')');
        $('#media_files div *').css('left', '0');
        $('#media_files div *').css('top', '0');
        $('#zoom .zoom-factor').text(parseFloat($(this).val()).toFixed(1) + 'x');
    });

    /**
     * Key-Handler for zoom and movement functions
     */
    $(document).keypress(function (e) {

        if (e.keyCode != 0) {
            var key = e.keyCode;
        } else {
            var key = e.which;
        }
        switch (key) {
            case 37: // left
                if (parseFloat($('#media_files div #media_file_1').css('left')) >= -((parseFloat($('#media_files div #media_file_1').css('width')) / 2) - 365)) {
                    $('#media_files div *').css('left', '-=5%');
                }
                break;

            case 38: // up
                if (parseFloat($('#media_files div #media_file_1').css('top')) >= -((parseFloat($('#media_files div #media_file_1').css('height')) / 2) - parseFloat($('.media_file_1').css('height')) / 2)) {
                    $('#media_files div *').css('top', '-=5%');
                }
                break;

            case 39: // right
                if (parseFloat($('#media_files div #media_file_1').css('left')) <= ((parseFloat($('#media_files div #media_file_1').css('width')) / 2) - 365)) {
                    $('#media_files div *').css('left', '+=5%');
                }
                break;

            case 40: // down
                if (parseFloat($('#media_files div #media_file_1').css('top')) <= ((parseFloat($('#media_files div #media_file_1').css('height')) / 2) - parseFloat($('.media_file_1').css('height')) / 2)) {
                    $('#media_files div *').css('top', '+=5%');
                }
                break;
            case 43: // zoom in
                $('#zoom-bar').val(parseFloat($('#zoom-bar').val()) + 0.1);
                $('#zoom-bar').trigger('change');
                break;

            case 45: // zoom out
                $('#zoom-bar').val(parseFloat($('#zoom-bar').val()) - 0.1);
                $('#zoom-bar').trigger('change');
                break;
            default:
                return;
        }
        e.preventDefault(); // prevent the default action (scroll / move caret)
    });

});


