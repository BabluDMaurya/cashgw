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
			<h1>Login</h1>
                        <p>Dont have an account? <a href="{{ url('/sign-up') }}">{{ __('Create an account') }}</a>,<br> It takes less than a minute</p>
                            @if (session('status'))
                            <div class="alert alert-success alert-dismissible"> 
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning alert-dismissible"> 
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('warning') }}
                            </div>
                        @endif
                        <form class="common-form login-form" action="{{ route('login') }}" method="post">
                            {{ csrf_field()}}
			  	<div class="form-group">
                                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email address" value="{{ old('email') }}">
<!--                                    @if($errors->has('email'))
                                        <span class="error email-error">{{$errors->first('email')}}</span>    
                                    @endif-->
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
			  	</div>
			  	<div class="form-group">
                                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password">
<!--                                    @if ($errors->has('password'))
                                        <span class="error password-error">{{ $errors->first('password') }}</span>    
                                    @endif-->
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
			  	</div>
                            <button type="submit" class="btn dark-btn round-btn hvr-sweep-to-top l-btn ml-0">Login</button>
                            <!--<a  class="btn dark-btn round-btn hvr-sweep-to-top l-btn">Login</a>-->
                            <a href="{{ route('password.request') }}" class="rec-btn">Recover Password</a>
			</form>
		</div>
	</div>
</section>
<script>           
    $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });  
    $(".alert-warning").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-warning").slideUp(500);
    });
    $(".form-control").keyup(function(){
                if(($(this).next('span').html()) != ''){
                    clear($(this).next('span').attr('class').split(' ')[1]);                
                };
            });            
            function clear(inputclass){
                $('.'+inputclass).html('');
            }
</script>
@endsection
