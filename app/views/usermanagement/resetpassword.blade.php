@extends('layouts.master')
@if($errors->has())
    <ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}
    @endforeach
    </ul>
@endif

	<div data-role="page" id="reset_pwd" data-theme="b">
		<div data-role="header">
			<h1>Reset Password</h1>
		</div>
	
		<div data-role="content">
			{{ Form::open(array('route' => array('resetPassword'))) }}
			    Email: {{ Form::text('email') }}<br>
			    {{ Form::submit('Send reset email') }}
			{{ Form::close() }}
		</div>
	</div>