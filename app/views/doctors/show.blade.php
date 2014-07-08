@extends('layouts.master')
@section('content')
<div data-role="page" id="home" data-theme="b">
    <div data-role="header">
        <a href="{{URL::to('doctors')}}" data-ajax="false" data-icon="home" class="ui-btn-left ui-corner-all">Home</a>
        <h1>{{  $doctor->name }}</h1>
        <a href="{{URL::to('login')}}" data-ajax="false" data-icon='user' class="ui-btn-right ui-corner-all">login</a>
    </div>
    <div data-role="content" class="doctor-content ui-corner-all">
        <ul data-role="listview" data-theme="a" class="doctor-profile">
            <li>
                <h3>Speciality:</h3>
                <p> {{ $doctor->speciality }}</p>
            </li>
            <li>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <h3>Phone:</h3>
                        <p> {{$doctor->phone}}</p>
                    </div>
                    <div class="ui-block-b">
                        <h3>Email:</h3>
                        <p> {{$doctor->email}}</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <h3>City:</h3>
                        <p> {{$doctor->city}} </p>
                    </div>
                    <div class="ui-block-b">
                        <h3>Province:</h3>
                        <p> {{$doctor->province}} </p>
                    </div>
                </div>
            </li>
            <!--  this link should only be available to owners of the doctor profile -->
            <li>
                <h3>Address:</h3>
                <p class="wrap"> {{$doctor->street_address}} - {{$doctor->postcode}} - {{$doctor->country}} </p>
            </li>
            <li>
                <h3>Education {{ link_to_route('educationRecord.create', "Add", $parameters = array($doctor->id),array('class'=>'ui-btn ui-icon-plus ui-btn-inline ui-corner-all ui-mini ui-btn-icon-notext')); }}</h3>
                @foreach($doctor->educationRecords as $educationRecord)
                    <p class="address wrap">{{ $educationRecord->type }} - {{ $educationRecord->organization_name }} - {{ $educationRecord->graduation_year }} {{ link_to_route('educationRecord.edit', "Edit", $parameters = array($doctor->id, $educationRecord->id ), array('class'=>'ui-btn ui-icon-edit ui-btn-inline ui-corner-all ui-mini ui-btn-icon-notext')); }}</p>
                @endforeach
            </li>
            <!--  this link should only be available to owners of the doctor profile -->
        </ul>
        @if(Sentry::getUser())
            {{ Form::model($userRatingOfDoc, array('route' => 'doctorRating.store')) }}
            @foreach($ratableFields as $displayName => $dbName)
                {{ $displayName }}<br>
                <ul>
                @for($i = 1; $i < 6; $i++)
                    <li>{{ $i }}{{ Form::radio($dbName, $i) }}
                @endfor
                </ul>
            @endforeach
            {{ Form::close(); }}
        @endif
        <div>
            Average Rating: {{ !empty($combinedAvgRating) ? $combinedAvgRating : "N\A" }}
        </div>
        <div>
            Number of Ratings: {{ !empty($ratingCount) ? $ratingCount : "N\A" }}
        </div>
        <div>
            @foreach($ratableFields as $displayName => $dbName)
                {{ $displayName }}{{ !empty($ratingAvgsByField[$dbName]) ? $ratingAvgsByField[$dbName] : "N\A" }}
            @endforeach
        </div>
    </div>
</div>


@stop

