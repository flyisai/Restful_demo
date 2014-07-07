@extends('layouts.master')
@section('content')
<div data-role="page" id="home" data-theme="b">

    <div data-role="header">
        <h1>Edit</h1>
    </div>

    <div data-role="content">
        {{Form::model($education, array('route' => array('educationRecord.update', $doctor->id, $education->id), 'method' => 'put'))}}
            {{Form::label('graduation_year','Graduation Year:')}}
            {{ Form::text('graduation_year') }}
            Type: {{ Form::select('type', array(
            'Medical School'    => 'Medical School',
            'Internship'        => 'Internship',
            'Apprenticeship'    => 'Apprenticeship',
            )); }}
            {{Form::label('organization_name','Organization:')}}
            {{ Form::text('organization_name') }}
            @if($errors->get('organization_name'))
                <ul>
                    @foreach($errors->get('organization_name') as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            @else <br />
            @endif
            {{ Form::submit('Save') }}<br />
        {{ Form::close() }}
        {{ link_to_route('educationRecord.destroy', 'Delete', array($doctor->id, $education->id), array('data-method'=>'delete','class'=>'ui-btn ui-corner-all')) }}
    </div>
</div>
@stop
