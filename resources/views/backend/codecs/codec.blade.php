@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')
    <h3 class="item_details">{!! $title !!}</h3>

    @if($new)
        {!! Form::open(['action' => ['Backend\CodecsController@new_codec'], 'method' => 'post'])  !!}
    @else
        {!! Form::open(['action' => ['Backend\CodecsController@update_codec', $codec->codec_id], 'method' => 'post'])  !!}
    @endif

    <div class="form-group">
        <label for="media_type">Media Type:</label>
        <div>
            {!! Form::select('media_type', array('' => '', 'video' => 'Video', 'image' => 'Image'), ((empty($codec->media_type)) ? Input::old('media_type') : $codec->media_type), [(empty($codec->media_type))?'':'disabled', 'class'=> 'form-control '  . ((count($errors->get('media_type'))) ?  'alert-danger' : '')]) !!}
        </div>

        @if(count($errors->get('media_type')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('media_type') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
    </div>


    <div class="form-group">
        <label for="name">Name:</label>
        <div>
            {!! Form::text('name', ((empty($codec->name)) ? Input::old('name') : $codec->name), array('class' => 'form-control ' . ((count($errors->get('name'))) ?  'alert-danger' : ''))) !!}
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
        <label for="ffmpeg_codec">ffmpeg parameter:</label>
        <div>
            {!! Form::text('ffmpeg_codec', ((empty($codec->ffmpeg_codec)) ? Input::old('ffmpeg_codec') : $codec->ffmpeg_codec), array('class' => 'form-control ' . ((count($errors->get('ffmpeg_codec'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('ffmpeg_codec')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('ffmpeg_codec') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
    </div>
    <div class="form-group">
        <label for="extension">extension:</label>
        <div>
            {!! Form::text('extension', ((empty($codec->extension)) ? Input::old('extension') : $codec->extension), array('class' => 'form-control ' . ((count($errors->get('extension'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('extension')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('extension') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
    </div>
    <a class="item_details" title="back without save" href="/admin/codecs">
        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> Back without Save
        </button>
    </a>
    <button type="submit" data-toggle="modal" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Save
    </button>



    {!! Form::close() !!}

@stop