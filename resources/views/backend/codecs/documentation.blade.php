@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')




    <h3 class="item_details">Dokumentation {{ ($type == 'compare')? 'Vergleich' : 'Übersicht' }}
        : {!! $codec->name !!} </h3>


    {!! Form::open(['action' => ['Backend\CodecsController@update_documentation', $codec->codec_id], 'method' => 'post'])  !!}
    <input type="hidden" value="{{$type}}" name="type"/>
    <div class="form-group">
        <div>
            <textarea name="documentation"
                      class="form-control {!! ((count($errors->get('documentation'))) ?  'alert-danger' : '')  !!}">{{((empty($documentation)) ? Input::old('documentation') : $documentation)}}</textarea>
        </div>
        @if(count($errors->get('documentation')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('documentation') as $error)
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