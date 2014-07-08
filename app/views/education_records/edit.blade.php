@extends('layouts.master')
@section('content')
<div data-role="page" id="home" data-theme="b">

    <div data-role="header">
        <h1>Edit</h1>
    </div>

    @if($errors->has())
    <ul>
        @foreach($errors->all() as $error)
        <li class="error">{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <div data-role="content">
        {{Form::model($education, array('route' => array('educationRecord.update', $doctor->id, $education->id), 'method' => 'put'))}}
            Graduation Year: {{ Form::text('graduation_year') }}<br>
            Type: {{ Form::select('type', array(
            'Medical School'    => 'Medical School',
            'Internship'        => 'Internship',
            'Apprenticeship'    => 'Apprenticeship',
            )); }}<br>
            Organization: {{ Form::text('organization_name') }}<br>
            {{ Form::submit('Update') }}<br>
        {{ Form::close() }}
    </div>
    @if (!Sentry::check()) {
        {{ link_to_route('educationRecord.destroy', 'delete', array($doctor->id, $education->id), ['data-method'=>'delete']) }}
    }
</div>
@stop
