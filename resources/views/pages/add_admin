@extends('master')
@section('addAdmin')

{!! FORM::open(['url' => 'app/user/add']) !!}
<div class="modal-content">

    <!--
	    @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
		        @endforeach
            </div>
        @endif
            -->

    <div class="input-field col 12">
        {!! FORM::text('name',null) !!}
        {!! FORM::label('name', 'Ime:') !!}
    </div>

    <div class="input-field col 12">
        {!! FORM::email('email',null) !!}
        {!! FORM::label('email', 'Email:') !!}
    </div>

    <div class="input-field col 12">
        {!! FORM::password('password') !!}
        {!! FORM::label('password', 'Geslo:') !!}
    </div>

    <div class="input-field col 12">
        {!! FORM::password('password_confirmation') !!}
        {!! FORM::label('password', 'Geslo:') !!}
    </div>

    <div class="input-field col 12">
        {!! FORM::select('role', array('user' => 'User', 'admin' => 'Admin')) !!}
    </div>

</div>
<div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect btn purple darken-4" style="margin-left: 10px;">Preklic</a>
    {!! FORM::submit('Shrani', ['class' => 'btn btn-primary green darken-1']) !!}
</div>
{!! FORM::close() !!}