@extends('layouts.withoutheaderfooter')
@section('content')
<section class="sec-login">
	<div class="login-left send-bg">
		<div class="ll-content">
                    <a href="{{URL('/')}}"><img class="img-fluid" src="{{URL('/public/images/white-logo.svg')}}"></a>
			<p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
		</div>
	</div>
	<div class="login-right">
		<div class="lr-content">
			<h1>Reset Password</h1>
                        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">                            
                            <input id="email" type="email" class="form-control" name="email" value="{{$email}}" placeholder="E-Mail Address" required autofocus autocomplete="off">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">                            
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autocomplete="off">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif                            
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif                            
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>                            
                        </div>
                    </form>
		</div>
	</div>
</section>
@endsection
