@extends('backend.master')
@section('title') Login @stop

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>
        @if(count($errors))
            @foreach ($errors->all() as $error)
                <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
        @endif
        @if ( session()->has('message') )
            <div class="bg-danger alert">{{ session()->get('message') }}</div>
        @endif

        <h1><i class='fa fa-lock'></i> Login</h1>

        {{ Form::open(['url' => 'login']) }}

        <div class='form-group'>
            {{ Form::label('username', 'Username') }}
            {{ Form::text('username', null, ['placeholder' => 'Username', 'class' => 'form-control']) }}
        </div>

        <div class='form-group'>
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) }}
        </div>

        <div class='form-group'>
            {{ Form::submit('Login', ['class' => 'btn btn-primary']) }}
        </div>

        {{ Form::close() }}

    </div>

@stop