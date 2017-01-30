@extends('master')
@section('login')

<div class="container bg-login" style="min-height: 620px">
  <div class="section" style="margin-top: 10%;">
  <div class="card-panel z-depth-3">
    <div class="row">
      <div class="col s12">
        <form method="POST" action="/auth/login">

          {!! csrf_field() !!}
          <div class="row">
            <div class="col s12">
              <img src="../../img/logo.png" class="responsive-img">
              <br/>
              <br/>
            </div>
            <div class="input-field col s6">
              <i class="material-icons prefix">email</i>
              <input type="email" name="email" value="{{ old('email') }}" id="icon_prefix" class="validate">
              <label for="icon_prefix">Email</label>
            </div>
            <div class="input-field col s6">
              <i class="material-icons prefix">vpn_key</i>
              <input name="password"  id="icon_telephone" type="password" class="validate">
              <label for="icon_telephone">Password</label>
            </div>
            <div class="input-field col s6">
              <button class="btn waves-effect waves-light purple darken-4"
                      type="submit"
                      name="action">Login
                <i class="material-icons right">send</i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>


          </div>
            @if (count($errors) > 0)
              <div class="card-panel red z-depth-2">
                <ul class="white-text">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
    </div>
          </div>
  </div>
</div>

@stop