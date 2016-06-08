@extends('master')
@section('app')
<div class="container" style="min-height: 900px">
  <div class="section">
    <div class="row">
        <div class="col s12">
          <div class="card-panel white-text purple darken-2" style="text-align: center">
              <h1>Hello, {{ Auth::user()->name }}</h1>
          </div>
        </div>
    </div>
  </div>
</div>
@stop