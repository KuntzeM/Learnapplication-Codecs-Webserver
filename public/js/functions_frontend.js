/**
 * @description ruft die verfügbaren Kodierungsverfahren der ausgewählten Media-Datei und erzeugt die beiden Select-Felder
 * @param element: ausgewählte Media-Datei
 * @param token: string für Authetifikation; von Laravel erzeugt
 */
function selectMediaFile(element, token) {

    $('input[type=text].open_grid').val($(element).attr('data-name'));

    $('#grid').toggle();
    initPopcorn();

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
            function sortfunction(a, b) {
                return (a.codec_name < b.codec_name ? -1 : (a.codec_name > b.codec_name ? 1 : 0));
            }

            obj.sort(sortfunction);

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

/////////////////////////////////////////////////////////////////////////
////////   VIDEO CONTROL ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////

var videos = {
    a: null,
    b: null,
};
var scrub = null,
    loadCount = null,
    events = null;

var animationID = null;

function sync() {

    if (videos.b.media.readyState === 4 && videos.a.media.readyState === 4) {
        console.log('sync');
        videos.b.currentTime(
            videos.a.currentTime()
        );
        if(animationID != null){
            clearInterval(animationID);
            animationID = null;
        }
    }else{

        if(animationID == null){
            animationID = setInterval(sync, 100);
        }
    }
}
function initPopcorn() {
// iterate both media sources

    videos = {
            a: Popcorn("#media_file_1"),
            b: Popcorn("#media_file_2")
    };
    scrub = $("#seek-bar");
    loadCount = 0;
    events = "play pause timeupdate seeking".split(/\s+/g);

    Popcorn.forEach(videos, function (media, type) {

        media.on("canplayall", function () {

            // trigger a custom "sync" event
            this.emit("sync");
            //sync();
            // set the max value of the "scrubber"
            scrub.attr("max", this.duration());

            // Listen for the custom sync event...
        })
    });
    videos.a.on("timeupdate", function () {

            scrub.val(videos.a.currentTime());
            $('#current_time').text(Math.round(videos.a.currentTime()*100)/100.0 + ' s / ' + Math.round(parseFloat(scrub.attr("max"))*100.0)/100.0 + ' s');

    });


    scrub.bind("change", function () {
        var val = this.value;
        videos.a.currentTime(val);
        //videos.b.currentTime(val);
        sync()

    });
    $('#play-pause').click(function () {
        if ($('#media_file_1').get(0).paused == true) {
            $('#media_file_1').get(0).play();
            $('#media_file_2').get(0).play();
            $(this).removeClass('glyphicon-play');
            $(this).removeClass('btn-success');
            $(this).addClass('glyphicon-pause');
            $(this).addClass('btn-warning');

        } else {
            $('#media_file_1').get(0).pause();
            $('#media_file_2').get(0).pause();
            $(this).removeClass('glyphicon-pause');
            $(this).removeClass('btn-warning');
            $(this).addClass('glyphicon-play');
            $(this).addClass('btn-success');
        }

    });
}




$(function () { // wird erst ausgeführt nachdem die HTML Struktur (DOM) geladen wurde

    $('#media_file_1').get(0).addEventListener("canplaythrough", function () {

        if (this.readyState === 4) {
            $('.second').html('<img width="32" alt="2" src="img/2.gif"/>');
        } else {

        }

    });
    $('#media_file_2').get(0).addEventListener("canplaythrough", function () {

        if (this.readyState === 4) {
            $('.third').html('<img width="32" alt="3" src="img/3.gif"/>');

        } else {
            $('.third').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
        }
    });

});


/////////////////////////////////////////////////////////////////////////
////////   VIDEO CONTROL END ////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
var videoContainer = null,
    videoClipper = null,
    clippedVideo = null;
function trackLocation(e) {
    if(videoContainer != undefined){

        var rect = videoContainer.getBoundingClientRect(),
            position = ((e.pageX - rect.left) / videoContainer.offsetWidth)*100;

        if (position <= 100) {
            //videoClipper.style.cssText = "width: " + position+"% !important";
            $(videoClipper).css("cssText", "width: " + position+"% !important;");
            console.log(((100/position)*100)-parseInt($("#media_file_2").css('left')));
            $(clippedVideo).css("cssText", "width: " + ((100/position)*100)+"% !important; " +
                "z-index:100; " +
                "transform: scale("+$('#zoom-bar').val()+"); " +
                "left:" + $("#media_file_2").css('left') + ";" +
                "top:" + $("#media_file_2").css('top') + ";");
            //clippedVideo.style.cssText = "width: " + ((100/position)*100)+"% !important";
            //clippedVideo.style.zIndex = 1000;
        }
    }

}

function addSplitviewEvents(){
    videoContainer = $('#media_files.splitview').get(0);

    // deaktiviert!!
    if(false && videoContainer != undefined) {
        console.log('add');
        videoContainer.removeEventListener("mousemove", trackLocation);
        videoContainer.removeEventListener("touchstart", trackLocation);
        videoContainer.removeEventListener("touchmove", trackLocation);
        videoClipper = $(".media_file_1").get(0);
        clippedVideo = (videoClipper.getElementsByTagName("video")[0]||videoClipper.getElementsByTagName("img")[0]);
        videoContainer.addEventListener("mousemove", trackLocation, false);
        videoContainer.addEventListener("touchstart", trackLocation, false);
        videoContainer.addEventListener("touchmove", trackLocation, false);
    }
}





$(function(){


    $('[data-toggle="tooltip"]').tooltip();
    $('select[name=media_file_1_select]').change(function(){
        if ($('#media_file_1').is('video')) {
            $('.second').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
            $('#media_file_1 source').remove();
            $('<source />').appendTo('#media_file_1');
            $('#media_file_1 source').attr('src', url + '/getMedia/' + $(this).val());
            $('#media_file_1')[0].load();

            if ($('#media_file_2').get(0).paused == false) {
                $('#media_file_1').get(0).play();
            }


            $('#media_file_1').onloadeddata = function () {
                //syncVideos(true);
            };

            ajaxSizeRequest = $.ajax({
                type: 'HEAD',
                async: true,
                url:url + '/getMedia/' + $(this).val(),

                success: function(){
                    if(ajaxSizeRequest.getResponseHeader('duration') != null){
                        globalVideoDuration = ajaxSizeRequest.getResponseHeader('duration');
                    }
                }
            });

            $('#video-controls *').attr('disabled', false);
            addSplitviewEvents();
            sync();

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
                var size = (Math.round(1000 * parseFloat(data['size']) / 1024) / 1000).toFixed(2).replace('.', ',');

                $('.information_1 .filesize').html(size + ' KB');
                $('.information_1 .psnr').html(data['psnr']);
                $('.information_1 .ssim').html(data['ssim']);


            }
        });


    });
    $('select[name=media_file_2_select]').change(function(){
        if ($('#media_file_2').is('video')) {
            $('.third').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
            $('#media_file_2 source').remove();
            $('<source />').appendTo('#media_file_2');
            $('#media_file_2 source').attr('src', url + '/getMedia/' + $(this).val());
            $('#media_file_2')[0].load();

            if ($('#media_file_1').get(0).paused == false) {
                $('#media_file_2').get(0).play();
            }

            sync();

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
                $('#media_file_2_documentation').html(data['documentation']);
                $('.information_2 .codec').html(data['codec']);
                $('.information_2 .bitrate').html(data['config']);
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);

                var size = (Math.round(1000 * parseFloat(data['size']) / 1024) / 1000).toFixed(2).replace('.', ',');

                $('.information_2 .filesize').html(size + ' KB');
                $('.information_2 .psnr').html(data['psnr']);
                $('.information_2 .ssim').html(data['ssim']);


            }
        });
    });
    $('#mode_group button:not(.no_mode_group)').click(function () {
        $(this).removeClass('btn-default');
        $(this).siblings(':not(.no_mode_group)').removeClass('btn-success');
        $(this).addClass('btn-success');
        $('#media_files').removeClass();
        $(this).attr('disabled', true);
        $(this).siblings(':not(.no_mode_group)').attr('disabled', false);


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
            //addSplitviewEvents();
        }else{
            $('#media_files').unbind().removeData();
            $('#media_files').removeAttr('style');
            $('.images-compare-separator').remove();
            $('.images-compare-handle').remove();
            $('#media_files div').removeClass('images-compare-before');
            $('#media_files div').removeClass('images-compare-after');
            $('#media_files div').removeAttr('style');
            $('#media_files div').removeAttr('ratio');
            $('#media_files.overview').css('height', $('.media_file_1').css('height'));
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
        console.log(key);
        switch (key) {
            case 39: // left
                if (parseFloat($('#media_files div #media_file_1').css('left')) >= -((parseFloat($('#media_files div #media_file_1').css('width')) / 2) - parseFloat($('.media_file_1').css('width')) / 2)) {
                    $('#media_files div *').css('left', '-=5%', 'important');
                }
                break;

            case 40: // up
                if (parseFloat($('#media_files div #media_file_1').css('top')) >= -((parseFloat($('#media_files div #media_file_1').css('height')) / 2) - parseFloat($('.media_file_1').css('height')) / 2)) {
                    $('#media_files div *').css('top', '-=5%', 'important');
                }
                break;

            case 37: // right
                if (parseFloat($('#media_files div #media_file_1').css('left')) <= ((parseFloat($('#media_files div #media_file_1').css('width')) / 2) - parseFloat($('.media_file_1').css('width')) / 2)) {
                    $('#media_files div *').css('left', '+=5%', 'important');
                }
                break;

            case 38: // down
                if (parseFloat($('#media_files div #media_file_1').css('top')) <= ((parseFloat($('#media_files div #media_file_1').css('height')) / 2) - parseFloat($('.media_file_1').css('height')) / 2)) {
                    $('#media_files div *').css('top', '+=5%', 'important');
                }
                break;
            case 43: // zoom in with +
                $('#zoom-bar').val(parseFloat($('#zoom-bar').val()) + 0.1);
                $('#zoom-bar').trigger('change');
                break;

            case 45: // zoom out with -
                $('#zoom-bar').val(parseFloat($('#zoom-bar').val()) - 0.1);
                $('#zoom-bar').trigger('change');
                break;
            case 102: // toogle full screen with f
                $('#button_fullscreen').trigger('click');
                break;
            case 32: // toogle play and pause in videos
                $('#play-pause').trigger('click');
                break;
            default:
                return;
        }
        e.preventDefault(); // prevent the default action (scroll / move caret)
    });

    $(".overview > .media_file_1").hover(function () {
        console.log('1');
        $(".information_2").addClass('select');
        $(".information_1").removeClass('select');
    }, function () {
        console.log('2');
        $(".information_1").addClass('select');
        $(".information_2").removeClass('select');
    });

    $('#button_fullscreen').click(function () {
        if ($('.row').hasClass('fullscreen')) {
            $(this).removeClass('btn-success');
            $('.row').removeClass('fullscreen');
            $(this).addClass('btn-default');
        } else {
            $(this).removeClass('btn-default');
            $('.row').addClass('fullscreen');
            $(this).addClass('btn-success');

        }
    });
});


