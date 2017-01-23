@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')




    <h3 class="item_details">Dokumentation: {!! $codec->name !!}</h3>


    {!! Form::open(['action' => ['Backend\CodecsController@update_documentation', $codec->codec_id], 'method' => 'post'])  !!}

    <div class="form-group">
        <div>
            <textarea name="documentation_de" class="form-control {!! ((count($errors->get('documentation_de'))) ?  'alert-danger' : '')  !!}">{{((empty($codec->documentation_de)) ? Input::old('documentation_de') : $codec->documentation_de)}}</textarea>
        </div>
        @if(count($errors->get('documentation_de')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('documentation_de') as $error)
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