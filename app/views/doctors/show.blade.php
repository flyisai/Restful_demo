@extends('layouts.master')
@section('content')
<div data-role="page" id="home" data-theme="b">
    <div data-role="header">
        <a href="{{URL::to('doctors')}}" data-ajax="false" data-icon="home" class="ui-btn-left ui-corner-all">Home</a>
        <h1>{{  $doctor->name }}</h1>
        @if(!$pUser)
            <a href="{{ URL::to('login') }}" class="ui-btn ui-btn-right ui-icon-user ui-btn-icon-left ui-corner-all">Login</a>
        @else
            <a href="{{ URL::to('myprofile') }}" class="ui-btn ui-btn-right ui-icon-user ui-btn-icon-left ui-corner-all">{{$pUser->email}}</a>
        @endif
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
            <li>
            @if(Sentry::getUser())
                {{ Form::model($userRatingOfDoc,
                array('route' => (isset($userRatingOfDoc->id) ? array('doctorRating.update', $doctor->id, $userRatingOfDoc->id) : array('doctorRating.store', $doctor->id)),
                'method' => (isset($userRatingOfDoc->id) ? 'PUT' : 'POST'),
                'class' => 'dummy_class',
                'id' => 'doctor_rating_form'
                )) }}
            @foreach($ratableFields as $displayName => $dbName)
                <label for="{{ $dbName }}">{{ $displayName }}</label>
                <input type="range" name="{{ $dbName }}" id="{{ $dbName }}" min="0" max="5" step="1" value='{{ !empty($ratingAvgsByField[$dbName]) ? $ratingAvgsByField[$dbName] : "0" }}' data-track-theme="b" data-highlight="true" data-show-value="true" data-popup-enabled="true" />
            @endforeach
                    {{ Form::submit('Save rating', array('id' => 'doctor_rating_submit')) }}
                {{ Form::close(); }}
            @else
                <form class="full-width-slider">
                    <label for="average">Average Rating</label>
                    <input type="range" id="average" disabled min="0" max="5" step="1" value='{{ !empty($combinedAvgRating) ? $combinedAvgRating : "0" }}' data-track-theme="b" data-highlight="true" data-show-value="true" data-popup-enabled="true" />
                    <label for="Number">Number of Ratings</label>
                    <input type="range" id="Number" disabled min="0" max="5" step="1" value='{{ !empty($ratingCount) ? $ratingCount : "0" }}' data-track-theme="b" data-highlight="true" data-show-value="true" data-popup-enabled="true" />
                    @foreach($ratableFields as $displayName => $dbName)
                        <label for="{{ $displayName }}">{{ $displayName }}</label>
                        <input type="range" id="{{ $displayName }}" disabled min="0" max="5" step="1" value='{{ !empty($ratingAvgsByField[$dbName]) ? $ratingAvgsByField[$dbName] : "0" }}' data-track-theme="b" data-highlight="true" data-show-value="true" data-popup-enabled="true" />
                    @endforeach
                </form>
            @endif
            </li>
        </ul>
    </div>
</div>
<script>
    $('#home').on('pagecreate',function(){
        $('input[type="number"]').attr({type:'text'});
    });
    $(document).on('keyup','input[type="text"]',function(){
        this.value = this.value.replace(/^[0-5]/g,'');
    });
</script>
@stop