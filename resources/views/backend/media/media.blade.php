@extends('backend.master')
{!!Html::style('css/jquery.fileupload.css')  !!}
{!!Html::style('css/jquery.fileupload-ui.css')  !!}
@section('nav')
    @parent
    @include('backend.header')

@stop

@section('content')


    {!!Html::script('js/jquery.fileupload.js')  !!}

    {!!Html::script('js/jquery.iframe-transport.js')  !!}

    <!-- {!!Html::script('js/cors/jquery.postmessage-transport.js')  !!}
    {!!Html::script('js/cors/jquery.xdr-transport.js')  !!}-->


    <h3 class="item_details">{!! $title !!}</h3>

    @if($new)
        {!! Form::open(['url' => $url . '/auth/image', 'method' => 'post', 'enctype'=>"multipart/form-data"])  !!}
    @else
        {!! Form::open(['url' => $url . '/auth/image/' . $media->media_id, 'method' => 'post'])  !!}
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

    <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Add files...</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="files">
            <input type="hidden" name="token" value="{!! $token !!}"/>
            <input type="hidden" name="media_type" value="image"/>
        </span>
    </div>

    <a class="item_details" title="back without save" href="/admin/media">
        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> Back without Save
        </button>
    </a>
    <button id="send" type="button" data-toggle="modal" class="btn btn-default">
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

        $('#fileupload').fileupload({
         forceIframeTransport: true,
            type: 'POST',
         multipart: true,
            dataType: 'json',
            processData: false,
            contentType: false,
            done: function (e, data) {
             console.log(e.message);
             console.log(data);

         },
            add: function (e, data) {
                $('#send').click(function () {
                    data.submit();
                });
         },
            progressall: function (e, data) {
         var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.progress-bar').attr("aria-valuenow", progress)
                        .text(progress + '%')
                        .css('width', progress + '%');
         }
        }).bind('fileuploadsubmit', function (e, data) {
            var request = new FormData($('form')[0]);
            data = request;

        });

    </script>
@stop