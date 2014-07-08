@extends('layouts.master')
@section('content')
    @if($errors->has())
        <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}
        @endforeach
        </ul>
    @endif


    <div data-role="page" id="login" data-theme="b">
        <div data-role="header">
            <h1>Login</h1>
        </div>

        <div data-role="content">
            {{ Form::open(array('route' => array('login'))) }}
                Username: {{ Form::text('username','') }}<br>
                Password: {{ Form::password('password') }}<br>
                {{ Form::submit('Login') }}<br>
            {{ Form::close() }}
            {{ link_to_route('resetPassword' , 'Forgot your password?') }}
        </div>
    </div>

@stop