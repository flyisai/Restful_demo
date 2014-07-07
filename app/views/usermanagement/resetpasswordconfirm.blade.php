<html>
@if($errors->has())
    <ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}
    @endforeach
    </ul>
@endif
{{ Form::open() }}
    Password: {{ Form::password('password') }}<br>
    Password Again: {{ Form::password('password_again') }}<br>
    {{ Form::submit('Save new password') }}
{{ Form::close() }}
</html>