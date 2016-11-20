@extends('backend.master')
{!!Html::style('css/jquery.fileupload.css')  !!}
{!!Html::style('css/jquery.fileupload-ui.css')  !!}

@section('nav')
    @parent
    @include('backend.header')

@stop

@section('content')
    {!!Html::script('js/jquery.ui.widget.js')  !!}
    {!!Html::script('js/jquery.iframe-transport.js')  !!}
    {!!Html::script('js/jquery.fileupload.js')  !!}
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>

    {!!Html::script('js/jquery.fileupload-process.js')  !!}
    {!!Html::script('js/jquery.fileupload-validate.js')  !!}
    {!!Html::script('js/jquery.fileupload-image.js')  !!}
    {!!Html::script('js/jquery.fileupload-video.js')  !!}


    {!!Html::script('js/cors/jquery.postmessage-transport.js')  !!}
    {!!Html::script('js/cors/jquery.xdr-transport.js')  !!}




    <h3 class="item_details">{!! $title !!}</h3>

    @if($new)
        {!! Form::open(['url' => $url . '/auth/media', 'method' => 'post', 'enctype'=>"multipart/form-data"])  !!}
    @else
        {!! Form::open(['url' => $url . '/auth/image/' . $media->media_id, 'method' => 'post'])  !!}
    @endif
    {!! Form::text('token', $token, array('class' => 'form-control hidden')) !!}
    <div class="form-group">

        <label for="name">Name:</label>
        <div>
            {!! Form::text('name', ((empty($media->name)) ? Input::old('name') : $media->name), array('class' => 'form-control ' . ((count($errors->get('name'))) ?  'alert-danger' : ''))) !!}
        </div>

        @if(count($errors->get('name')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('name') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif

        <label for="media_type">Media Type:</label>
        <div id="media_type">

        </div>
        {!! Form::text('media_type', '', array('id' => 'media_type_input', 'class' => 'form-control hidden')) !!}
        @if(count($errors->get('media_type')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('media_type') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif

    </div>

    <div class="form-group">
        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Add files...</span>
            {!! Form::file('file', array('id' => 'file', 'accept' => 'video/*, image/*')) !!}
        </span>
        <span id="file_name">

        </span>
        <div id="thumbnail">

        </div>

    </div>
    <a class="item_details" title="back without save" href="/admin/media">
        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> Back without Save
        </button>
    </a>
    <button id="send" disabled="disabled" type="button" data-toggle="modal" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Save
    </button>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
             style="width: 0%;">
            0
        </div>
    </div>
    <div id="thumbnail">

    </div>

    {!! Form::close() !!}
    <script type="text/javascript">
        $(function () {
            'use strict';
            $('#file').fileupload({
                forceIframeTransport: true,
                type: 'POST',
                multipart: true,
                dataType: 'json',
                processData: false,
                contentType: false,
                singleFileUploads: true,
                autoUpload: false,
                add: function (e, data) {
                    $('#file_name').text(data.files[0].name);
                    //console.log(data);
                    loadImage(
                            data.files[0],
                            function (img) {
                                $('#thumbnail').append(img);
                            },
                            {maxWidth: 300} // Options
                    );

                    if (data.files[0].type.match('video')) {
                        $('#media_type').text('Video');
                        $('#media_type_input').attr('value', 'video');
                        $('#send').removeAttr('disabled');
                    } else if (data.files[0].type.match('image')) {
                        $('#media_type').text('Image');
                        $('#media_type_input').attr('value', 'image');
                        $('#send').removeAttr('disabled');
                    } else {
                        $('#media_type').text('FIle is not supported!');
                        $('#media_type_input').attr('value', '');
                        $('#send').attr('disabled', 'disabled');
                    }

                    $("#send").unbind('click');
                    $('#send').click(function () {
                        data.submit();
                    });

                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.progress-bar').attr("aria-valuenow", progress)
                            .text(progress + '%')
                            .css('width', progress + '%');
                },
                progressServerRate: 0.5,
                progressServerDecayExp: 3.5
            }).bind('fileuploadsubmit', function (e, data) {
                data = new FormData($('form')[0]);

            }).bind('fileuploaddone', function (e, data) {
                window.location.href = '/admin/media';

            })

                    .bind('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                });
            });
        });

    </script>
@stop
