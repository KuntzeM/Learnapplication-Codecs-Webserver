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

    {!!Html::script('js/cors/jquery.postmessage-transport.js')  !!}
    {!!Html::script('js/cors/jquery.xdr-transport.js')  !!}


    <h3 class="item_details">{!! $title !!}</h3>

    @if($new)
        {!! Form::open(['url' => $url . '/public/image', 'method' => 'post', 'enctype'=>"multipart/form-data"])  !!}
    @else
        {!! Form::open(['url' => $url . '/public/image/'+ $media->media_id, 'method' => 'post'])  !!}
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
        $('#send').click(function (event) {
            var request = new FormData();
            request.append('token', '{!! $token !!}');
            $.ajax({
                url: '{!! $url . '/auth/image' !!}',
                type: "POST",
                data: request,
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    //upload Progress
                    var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function (event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            //update progressbar
                            $(".progress .progress-bar").css("width", +percent + "%");
                            //$(progress_bar_id + " .status").text(percent +"%");
                        }, true);
                    }
                    return xhr;
                },
                mimeType: "multipart/form-data",
                crossDomain: true
            }).done(function (res) { //
                //$(my_form_id)[0].reset(); //reset form
                //$(result_output).html(res); //output response from server
                //submit_btn.val("Upload").prop( "disabled", false); //enable submit button once ajax is done
            });
        });


        /*var request = new FormData();
         request.append('a', 'upload');
         request.append('token', '{!! $token !!}');
        $('#fileupload').fileupload({
         forceIframeTransport: true,
            type: 'POST',
         multipart: true,
         forceIframeTransport: true,
         data: request,
            /*done: function (e, data) {
             console.log(e.message);
             console.log(data);

         },
         beforeSend: function (request)
         {
         request.setRequestHeader("Authority", '{!! $token !!}');
         },
            add: function (e, data) {
                $('#send').click(function () {
                    data.submit();
                });
         },
             progressall: function (e, data) {
         var progress = parseInt(data.loaded / data.total * 100, 10);
             $('.progress-bar').attr("aria-valuenow",progress);
             $('.progress-bar').text(progress + '%');
             $('.progress-bar').css('width',progress + '%');
         }
        });
        $('#fileupload').bind('fileuploadsubmit', function (e, data) {
            // The example input, doesn't have to be part of the upload form:
         data.formData = '{!! $token !!}';
            /*if (!data.formData.example) {
             data.context.find('button').prop('disabled', false);
             input.focus();
             return false;
         }
         });*/

    </script>
@stop