@extends('layouts.master')
<h1>myprofile</h1>    

@if($errors->has())
    <ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}
    @endforeach
    </ul>
@endif

{{ Form::model($user) }}
    Full name: {{ Form::text('full_name',$user->email)}}<br>
    Gender: male {{ Form::radio('gender', 'male') }} female {{ Form::radio('gender', 'female') }}<br>
    Date of Birth: {{ Form::text('date_of_birth') }}<br>
    Street Address: {{ Form::text('street_address') }}<br>
    City: {{ Form::text('city') }}<br>
    Postcode: {{ Form::text('postcode') }}<br>
    Province: {{ Form::text('province') }}<br>
    Country: {{ Form::text('country') }}<br>
    Blood Type: {{ Form::text('blood_type') }}<br>
    Mobile Number: {{ Form::text('mobile_number') }}<br>
    {{ Form::submit('Update Profile') }}`
{{ Form::close() }}
</html>


