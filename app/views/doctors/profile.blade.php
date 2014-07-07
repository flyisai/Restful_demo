@extends('layouts.master')
@section('content')

<div data-role="page" id="home" data-theme="a" style="width:400px;">
    <div data-role="header">
            <h1>create or edit doctor profile</h1>
    </div>	
    <div data-role="content">
        @if($errors->has())
            <ul>
            @foreach($errors->all() as $error)
                <li style="color:red;">{{ $error }}
            @endforeach
            </ul>
        @endif
        
        {{ Form::open(array('route' => array($route))) }} 

            {{Form::label('name', 'name: ')}} {{ Form::text('name',$name)}}
            {{Form::label('speciality', 'speciality: ')}} {{ Form::text('speciality',$speciality) }}
            {{Form::label('street_address', 'street address: ')}} {{ Form::text('street_address',$street_address) }}
            
            {{Form::select('cityid',  array("0"=>"Bali",'1'=>'Denpasar'), $cityid, array('id' => 'cityid'))}}
                        
            {{Form::label('postcode', 'postcode: ')}} {{ Form::text('postcode',$postcode) }}
            {{Form::label('provinceid', 'province: ')}} 
            {{Form::select('provinceid',  array("0"=>"Jakarta",'1'=>'Java'), $provinceid, array('id' => 'provinceid'))}}
            {{Form::label('country', 'country: ')}} {{ Form::text('country',$country) }}
            {{Form::label('phone', 'phone: ')}} {{ Form::text('phone',$phone) }}                   
            {{Form::label('email', 'email: ')}} {{ Form::text('email',$email) }}
            {{Form::label('license_number', 'license number: ')}} {{ Form::text('license_number',$license_number) }}

            {{ Form::hidden('user_id', $user_id,array("id"=>'user_id'))}}
            {{ Form::hidden('id', $id,array("id"=>'id'))}}
            
            {{Form::submit('post',array("id"=>'post1',"name"=>'post1'))}}
        {{ Form::close() }}		 			 
    </div>
</div>
@stop