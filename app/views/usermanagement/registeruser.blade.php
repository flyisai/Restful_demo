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
{{ Form::open(array('route' => array('registerUser'))) }}
    Email: {{ Form::text('email') }}<br>
    Password: {{ Form::password('password') }}<br>
    Password Again: {{ Form::password('password_again') }}<br>
    {{ Form::submit('Register') }}
{{ Form::close() }}
    </div>
</div>
@stop

	