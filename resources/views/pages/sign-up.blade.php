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
		<div class="lr-content">
			<h1>Sign up for free</h1>
			<p>Choose from two types of accounts:</p>
                        <form class="common-form" id="signup" action="{{URL('/signupsubmit')}}" method="post">
			<div>                          
                            {{ csrf_field() }}
				<label class="l-radio"> 
					<h6>Individual account </h6>
					<p>Shop, send and receive overseas payments. All without sharing your financial information.</p>
                                        <input type="radio" checked="checked" name="radio" value="indi">
				  	<span class="checkmark"></span>
				</label>
				<label class="l-radio">
					<h6>Business account</h6>
					<p>Accept credit and debit cards, and send invoices to your overseas customers.</p>
                                        <input type="radio" name="radio" value="busi">
				  	<span class="checkmark"></span>
				</label>                               
			</div>
                            <input name="submit" type="submit" value="Continue" class="btn dark-btn round-btn hvr-sweep-to-top l-btn">
                        {{--<a class="btn dark-btn round-btn hvr-sweep-to-top l-btn" >Continue</a>--}}
                      </form>   
		</div>
	</div>
</section>
@endsection
<!--<script>
    $('.l-btn').click(function() {
   if($('#indi').is(':checked')) {
     event.preventDefault();
            window.location.href="sign-up-individual";   
        }
        else{
            window.location.href="sign-up-business";   
        }
});
</script>-->
