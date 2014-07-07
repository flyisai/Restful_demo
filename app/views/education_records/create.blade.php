@extends('layouts.master')
@section('content')
<div data-role="page" id="home" data-theme="b">

    <div data-role="header">
        <h1>Add Education</h1>
    </div>

    @if($errors->has())
    <ul>
        @foreach($errors->all() as $error)
            <li class="error">{{ $error }}</li>
        @endforeach
    </ul>
    @endif




    <div data-role="content">
        {{ Form::open(array('route' => array('educationRecord.store', $doctor->id))) }}

            Graduation Year: {{ Form::text('graduation_year') }}<br>
            Type: {{ Form::select('type', array(
                'Medical School'    => 'Medical School',
                'Internship'        => 'Internship',
                'Apprenticeship'    => 'Apprenticeship',
            )); }}<br>
            Organization: {{ Form::text('organization_name') }}<br>
            {{ Form::submit('Add') }}<br>
        {{ Form::close() }}
        {{ link_to_route('resetPassword' , 'Forgot your password?') }}
    </div>


</div>
@stop
