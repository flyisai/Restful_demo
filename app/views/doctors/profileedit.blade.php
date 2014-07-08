@extends('layouts.master')
@section('content')

<div data-role="page" id="home" data-theme="a" style="width:400px;">
    <div data-role="header">
            <h1>edit doctor profile</h1>
    </div>	
    <div data-role="content">
        @if($errors->has())
            <ul>
            @foreach($errors->all() as $error)
                <li style="color:red;">{{ $error }}
            @endforeach
            </ul>
        @endif
                
        {{Form::model($doctor, array('route' => array('doctorprofileupdate'), 'method' => 'POST'))}}
            {{Form::label('name', 'name: ')}} {{ Form::text('name')}}
            {{Form::label('speciality', 'speciality: ')}} {{ Form::text('speciality') }}
            {{Form::label('street_address', 'street address: ')}} {{ Form::text('street_address') }}
            {{Form::label('province_id', 'province: ')}}
            {{Form::select('province_id',  array("0"=>"Jakarta",'1'=>'Java'), null, array('id' => 'province_id'))}}
            {{Form::label('city_id', 'city: ')}}
            {{Form::select('city_id',  array("0"=>"Bali",'1'=>'Denpasar'), null, array('id' => 'city_id'))}}
            {{Form::label('postcode', 'postcode: ')}} {{ Form::text('postcode') }}
            {{Form::label('country', 'country: ')}} {{ Form::text('country') }}
            {{Form::label('phone', 'phone: ')}} {{ Form::text('phone') }}                   
            {{Form::label('email', 'email: ')}} {{ Form::text('email') }}
            {{Form::label('license_number', 'license number: ')}} {{ Form::text('license_number') }}
            {{ Form::hidden('id', null,array("id"=>'id'))}}
            {{Form::submit('post',array("id"=>'post1',"name"=>'post1'))}}
        {{ Form::close() }}		 			 
    </div>
</div>
@stop