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

    {!!Html::script('js/jquery.fileupload-process.js')  !!}
    {!!Html::script('js/jquery.fileupload-validate.js')  !!}
    {!!Html::script('js/jquery.fileupload-image.js')  !!}
    {!!Html::script('js/jquery.fileupload-video.js')  !!}


    <!-- {!!Html::script('js/cors/jquery.postmessage-transport.js')  !!}
    {!!Html::script('js/cors/jquery.xdr-transport.js')  !!}-->




    <h3 class="item_details">{!! $title !!}</h3>

    @if($new)
        {!! Form::open(['url' => $url . '/auth/image', 'method' => 'post', 'enctype'=>"multipart/form-data"])  !!}
    @else
        {!! Form::open(['url' => $url . '/public/image/' . $media->media_id, 'method' => 'post'])  !!}
    @endif

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

    </div>
    <div class="form-group">
        <label for="file">Media File:</label>
        {!! Form::file('file', array('id'=>'file', 'class' => 'form-control')) !!}
    </div>
    <a class="item_details" title="back without save" href="/admin/media">
        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> Back without Save
        </button>
    </a>
    <button id="send" type="button" disabled="disabled" data-toggle="modal" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Save
    </button>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
             style="width: 0%;">
            0
        </div>
    </div>


    {!! Form::close() !!}
    <script type="text/javascript">
        $(function () {

            $('#file').fileupload({
                forceIframeTransport: true,
                type: 'POST',
                multipart: true,
                dataType: 'json',
                processData: false,
                contentType: false,
                singleFileUploads: true,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                maxFileSize: '100000',
                done: function (e, data) {
                    //console.log(e.message);
                    //console.log(data);
                },
                add: function (e, data) {
                    $('#send').click(function () {
                        data.submit();
                    });
                },
                progressall: function (e, data) {
                    console.log(e);
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.progress-bar').attr("aria-valuenow", progress)
                            .text(progress + '%')
                            .css('width', progress + '%');
                },
                // progressServerRate: 0.5,
                // progressServerDecayExp: 3.5
            }).bind('fileuploadsubmit', function (e, data) {
                data = new FormData($('form')[0]);

            }).bind('fileuploadfail', function (e, data) {
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