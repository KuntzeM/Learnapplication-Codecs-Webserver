@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')

    <h3 class="item_details">{!! $title !!}</h3>

    @if($new)
        {!! Form::open(['action' => ['Backend\CodecsController@new_codec_config'], 'method' => 'post'])  !!}
    @else
        {!! Form::open(['action' => ['Backend\CodecsController@update_codec_config', $codec_config->codec_config_id], 'method' => 'post'])  !!}
    @endif
    {!! Form::hidden('codec_id', $codec_config->codec->codec_id) !!}
    <div class="form-group">
        <label for="name">for codec:</label>

        <div>
            {!! $codec_config->codec->name !!} / {!! $codec_config->codec->media_type !!}
        </div>

    </div>

    <div class="form-group">
        <label for="name">Name:</label>

        <div>
            {!! Form::text('name', ((empty($codec_config->name)) ? Input::old('name') : $codec_config->name), array('class' => 'form-control ' . ((count($errors->get('name'))) ?  'alert-danger' : ''))) !!}
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
        <label for="ffmpeg_bitrate">ffmpeg bitrate:</label>
        <div>
            {!! Form::text('ffmpeg_bitrate', ((empty($codec_config->ffmpeg_bitrate)) ? Input::old('ffmpeg_bitrate') : $codec_config->ffmpeg_bitrate), array('class' => 'form-control ' . ((count($errors->get('ffmpeg_bitrate'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('ffmpeg_bitrate')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('ffmpeg_bitrate') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
        <label for="ffmpeg_parameters">ffmpeg parameter:</label>
        <div>
            {!! Form::text('ffmpeg_parameters', ((empty($codec_config->ffmpeg_parameters)) ? Input::old('ffmpeg_parameters') : $codec_config->ffmpeg_parameters), array('class' => 'form-control ' . ((count($errors->get('ffmpeg_parameters'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('ffmpeg_parameters')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('ffmpeg_parameters') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
    </div>
    <a class="item_details" title="back without save" href="/admin/codecs">
        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> Back without Save
        </button>
    </a>
    <button type="submit" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Save
    </button>




    {!! Form::close() !!}

@stop