@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')
    <h3 class="item_details">{!! $title !!}</h3>

    @if($new)
        {!! Form::open(['action' => ['Backend\MediaController@upload_media'], 'method' => 'post'])  !!}
    @else
        {!! Form::open(['action' => ['Backend\MediaController@update_media', $media->media_id], 'method' => 'post'])  !!}
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

    <a class="item_details" title="back without save" href="/admin/media">
        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> Back without Save
        </button>
    </a>
    <button type="submit" data-toggle="modal" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Save
    </button>



    {!! Form::close() !!}

@stop