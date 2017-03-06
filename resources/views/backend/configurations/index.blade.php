@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')



    <h3 class="item_details">{!! $title !!}</h3>

    <div class="form-group">
        <a href="configurations/welcome">
            <button class="btn btn-info">Startseite ändern</button>
        </a>
        <a href="configurations/impressum">
            <button class="btn btn-info">Impressum ändern</button>
        </a>
    </div>

    {!! Form::open(['action' => ['Backend\ConfigurationsController@update'], 'method' => 'post'])  !!}


    <div class="form-group">
        <label for="username">Username:</label>
        <div>
            {!! Form::text('username', $config->username, array('class' => 'form-control ' . ((count($errors->get('username'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('username')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('username') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
        <label for="email">Email:</label>
        <div>
            {!! Form::email('email', $config->email, array('class' => 'form-control ' . ((count($errors->get('email'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('email')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('email') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
        <label for="password">Password:</label>
        <div>
            {!! Form::password('password', array('class' => 'form-control ' . ((count($errors->get('password'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('password')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('password') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
        <label for="password_confirmation">Repeat Password:</label>
        <div>
            {!! Form::password('password_confirmation', array('class' => 'form-control ' . ((count($errors->get('password_confirmation'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('password_confirmation')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('password_confirmation') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="media_server">Media Server IP:</label>
        <p class="help-block">for example: 127.0.0.1:3000</p>
        <div>
            {!! Form::text('media_server', $config->media_server, array('class' => 'form-control ' . ((count($errors->get('media_server'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('media_server')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('media_server') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
        <label for="api_key">API Secret Key:</label>
        <div>
            {!! Form::text('api_key', $config->api_key, array('class' => 'form-control ' . ((count($errors->get('api_key'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('api_key')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('api_key') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
        <label for="api_expire">API Expire Time (in minutes):</label>
        <div>
            {!! Form::text('api_expire', $config->api_expire, array('class' => 'form-control ' . ((count($errors->get('api_expire'))) ?  'alert-danger' : ''))) !!}
        </div>
        @if(count($errors->get('api_expire')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('api_expire') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
    </div>
    <button type="submit" data-toggle="modal" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Save
    </button>

    {!! Form::close() !!}
@stop