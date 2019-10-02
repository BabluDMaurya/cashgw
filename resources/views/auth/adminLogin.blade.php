@extends('layouts.admin-auth')
@section('content')
<div class="signin-wrapper">
      <div class="signin-box">
        <form method="POST" action='{{ url("login/$url") }}'>
                        {{ csrf_field()}}  
        <h2 class="signin-title-primary">Login</h2>
        <div class="form-group">
                <input id="email" type="email" placeholder="Enter email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
        </div>
        <div class="form-group position-relative">
                <input id="password" type="password" placeholder="Enter password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
          <i class="fa fa-eye password-icon" aria-hidden="true"></i>
        </div>
<!--        <div class="form-group mg-b-50 d-flex">
            <input type="text" class="form-control captcha-control" id="captcha" value="2 + 2" readonly="">
            <input type="number" class="form-control"  id="captcha_number">
        </div>-->
        
        <button type="submit" class="btn btn-primary btn-block btn-signin btn-oblong">{{ __('Sign In') }}</button>
<!--        <div class="text-right mb-3 mt-1">
            <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Password ?') }}
                                </a>
        </div>-->
        </form>
      </div>
    </div>
@endsection