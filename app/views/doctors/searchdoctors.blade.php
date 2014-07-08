@extends('layouts.master')
@section('content')

<div data-role="page" id="home" data-theme="b">

    <div data-role="panel" id="doctor-panel" data-display="overlay">

    </div>

    <div data-role="header">
        <a href="#doctor-panel" data-icon='bars' class="ui-corner-all ui-btn-left">Nav Panel</a>
        <h1 class="align-center">Doctor List</h1>
    </div>

    <div data-role="content">
        @if($errors->has())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}
                @endforeach
        </ul>
        @endif
        {{ Form::open(array('data-ajax' => 'false')) }}
        {{ Form::text('name', null, array('data-type' => 'search', 'placeholder' => 'Doctor Name')) }}
        <!--<div class="ui-field-contain">-->
        <label for="select-speciality">Doctor's speciality:</label>
        <select data-inline="true" id="select-speciality" data-native-menu="false" name="speciality">
            <option value="" selected disabled>Select Speciality</option>
            @foreach ($specialities as $speciality)
            <option value="{{ $speciality }}">{{$speciality}}</option>
            @endforeach
        </select>
        <!--</div>-->
        {{ Form::submit('search', array('data-inline' => 'true','disabled'=>'disabled')) }}
        {{ Form::close() }}
        @foreach ($doctors as $doctor)

        <a data-ajax="false" href="{{ route('showDoctor', $doctor->id); }}">
            <div class="ui-btn ui-icon-carat-r ui-btn-icon-right ui-corner-all">
                <img class="doctor-img-left" src="http://placekitten.com/g/200/300" width="100ox" height="150px" />
                <div class="doctor-info">
                    <p>{{ $doctor->name }}</p>
                    <p>{{ $doctor->speciality }}</p>
                    <p>{{ $doctor->street_address }}</p>
                    <p>{{ $doctor->phone }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

</div>

<script>
    $(function(){
        $('input[name="name"]').keyup(function(){
            var submit = $('input[type="submit"]');
            if(this.value != '' || $('#select-speciality')[0].value != '') {
                submit.button().button('enable');

            } else {
                submit.button().button('disable');
            }
        });
        $('#select-speciality').change(function(){
            $('input[type="submit"]').button().button('enable');//button('enable')
        });
    });

    $('#home').on('pagecreate', function(){
        if($('input[name="name"]')[0].value != '' || $('#select-speciality')[0].value != '') {
            $('input[type="submit"]').button().button('enable');
        }
    })
</script>

@stop