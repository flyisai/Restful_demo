<html>
@if($errors->has())
    <ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}
    @endforeach
    </ul>
@endif

{{ Form::open(array('route' => array('registerUser'))) }}
    Email: {{ Form::text('email') }}<br>
    Password: {{ Form::password('password') }}<br>
    Password Again: {{ Form::password('password_again') }}<br>
    {{ Form::submit('Register') }}
{{ Form::close() }}
</html>

	