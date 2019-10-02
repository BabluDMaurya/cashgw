@extends('layouts.withoutheaderfooter')
@section('content')
<section class="sec-login">
	<div class="login-left sign-bg">
		<div class="ll-content">
                    <a href="{{URL('/')}}"><img class="img-fluid" src="{{URL('/public/images/white-logo.svg')}}"></a>
			<p class="text-white">See for yourself why millions of people love Money Transfer</p>
		</div>
	</div>
	<div class="login-right">
		<div class="lr-content indi-content">
			<h1>Sign up for free</h1>
                        @if(Session::has('cgwregisteruseraccounttype'))
                            @if( 1 == Session::get('cgwregisteruseraccounttype'))
                                <h6>Individual account</h6>
                            @else
                                <h6>Business account</h6>
                            @endif
			@endif
			<p class="text-gray">Shop, send and receive overseas payments. <br>All without sharing your financial information.</p>
                            <form class="common-form login-form" id="signupindi" action="{{ route('register') }}" method="post">
                                {{ csrf_field() }}
			  	<div class="form-group">
                                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" placeholder="Email address" value="{{ old('email') }}" autocomplete="OFF">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
<!--                                    <span class="error email-error"></span>    -->
			  	</div>
			  	<div class="form-group">
			    	<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="pwd" placeholder="Password" autocomplete="OFF">
                                @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                <!--<span class="error password-error"></span>-->    
			  	</div>
			  	<div class="form-group">
                                <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="pwd1" placeholder="Re-enter Password" autocomplete="OFF">
                                @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                <!--<span class="error reenterpassword-error"></span>-->    
			  	</div>
			  	<p>By clicking the button below, I agree to be bound by CashGW <a href="{{URL('terms')}}">terms and conditions</a> and the <a href="{{URL('privacy')}}">Privacy Policy</a>.</p>
			  	<div class="position-relative">
				  	<label class="l-checkbox">
				  		<p>I agree to be bound by CashGW terms,conditions and the Privacy Policy.</p>
                                                <input type="checkbox" name="agree" class="form-control {{ $errors->has('agree') ? ' is-invalid' : '' }}">
                                                @if ($errors->has('agree'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('agree') }}</strong>
                                                        </span>
                                                    @endif
                                                <!--<span class="error agree-error"></span>-->    
					  	<span class="checkmark"></span>
					</label>
				</div>
                                <button type="submit" class="btn dark-btn round-btn hvr-sweep-to-top l-btn">
                                    {{ __('Continue') }}
                                </button>
                                <!--<a class="btn dark-btn round-btn hvr-sweep-to-top l-btn" id="ajaxSubmit">Continue</a>-->
			</form>
		</div>
	</div>
</section>
<script>
//         $(document).ready(function(){
//            $('#ajaxSubmit').click(function(e){
//               e.preventDefault();
//               $.ajaxSetup({
//                  headers: {
//                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                  }
//              });
//              var form = $("#signupindi");
//              var formData = form.serialize();
//               $.ajax({
//                  url: form.attr('action'),
//                  type: form.attr('method'),
//                  data: formData,
//                  dataType:'json',
//                  success: function(result){
//                    if(result.status === 200){
//                            window.location.replace("/sign-in");
//                        }
//                  },
//                  error: function(result){
//                      if(result.status === 422) {
//                        var errors = result.responseJSON;
//                        $('.alert').html('').hide();                        
//                        $.each(result.responseJSON, function (key, value) {
//                            $('.'+key+'-error').html(value);
//                        });
//                      }
//                    }
//                });
//             });               
//            });
//            
//            $(".form-control").keyup(function(){
//                if(($(this).next('span').html()) != ''){
//                    clear($(this).next('span').attr('class').split(' ')[1]);                
//                };
//            });            
//            function clear(inputclass){
//                $('.'+inputclass).html('');
//            }
      </script>
@endsection
