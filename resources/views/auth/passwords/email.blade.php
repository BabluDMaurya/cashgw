@extends('layouts.withoutheaderfooter')
@section('content')
	<div class="login-left send-bg">
		<div class="ll-content">
                    <a href="{{URL('/')}}"><img class="img-fluid" src="{{URL('/public/images/white-logo.svg')}}"></a>
			<p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt t labore et dolore magna aliqua. </p>
		</div>
	</div>
	<div class="login-right">
		<div class="lr-content">
			<h1>Forgot Password</h1>
			<p>We just need your registered email address to send your password</p>
                        @if (session('status'))
                            <div class="alert  alert-success alert-dismissible"> 
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('status') }}
                            </div>
                        @endif
			<form class="common-form login-form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}                            
			  	<div class="form-group">
                                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}" autofocus placeholder="Email address">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
			  	</div>
                            <button type="submit" class="btn dark-btn round-btn hvr-sweep-to-top l-btn">{{__('Reset Password')}}</button>
                            <!--<a href="sign-in.php" class="btn dark-btn round-btn hvr-sweep-to-top l-btn">Reset Password</a>-->
			</form>
			<p class="text-gray">{{__('Don’t have an account?')}} <a href="{{URL('/sign-up')}}">{{__('Register')}}</a></p>
		</div>
	</div>
<script>           
    $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });  
    $(".alert-warning").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-warning").slideUp(500);
    });
</script>    
@endsection