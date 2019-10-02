@extends('layouts.admin')
@section('content')
<div class="slim-mainpanel">
      	<div class="container">
	        <div class="row row-sm mt-5">
	          	<div class="col-sm-6 col-lg-3">
		            <div class="card card-status">
		              	<div class="media">
		                	<i class="icon ion-ios-copy-outline tx-purple"></i>
	                		<div class="media-body">
			                  	<h1>{{$tkyc}}</h1>
			                  	<p>Total KYC Approvals</p>
		                	</div>
		              	</div>
		            </div>
	          	</div>
	          	<div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
	            	<div class="card card-status">
	              		<div class="media">
	                		<i class="icon ion-ios-briefcase-outline tx-teal"></i>
			                <div class="media-body">
			                  	<h1>{{$totalrequestmoney}}</h1>
			                  	<p>Total Request Money</p>
			                </div>
	              		</div>
	            	</div>
	          	</div>
	          	<div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
	            	<div class="card card-status">
		              	<div class="media">
			                <i class="icon ion-ios-person-outline tx-primary"></i>
			                <div class="media-body">
			                  	<h1>{{$tiaccount}}</h1>
			                  	<p>Individual Accounts</p>
			                </div>
		              	</div>
	            	</div>
	          	</div>
	          	<div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
	            	<div class="card card-status">
	              		<div class="media">
	                		<i class="icon ion-ios-people-outline tx-pink"></i>
			                <div class="media-body">
			                  	<h1>{{$tbaccount}}</h1>
			                  	<p>Business Accounts</p>
			                </div>
	              		</div>
	            	</div>
	          	</div>
                    
                        <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
	            	<div class="card card-status">
	              		<div class="media">
	                		<i class="icon ion-ios-people-outline tx-pink"></i>
			                <div class="media-body">
			                  	<h1>{{$adminbalance}}</h1>
			                  	<p>Admin Balance</p>
			                </div>
	              		</div>
	            	</div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                        <div class="card card-status">
	              		<div class="media">
                                <a href="{{URL('/bank')}}">
	                		<i class="icon ion-ios-people-outline tx-pink"></i>
			                <div class="media-body">
			                  	<h1>{{__('3')}}</h1>
			                  	<p>Bank Account</p>
			                </div>
                                </a>
	              		</div>
	            	</div>    
	          	</div>
                    <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                        <div class="card card-status">
	              		<div class="media">
                                <a href="{{URL('/defaultfees')}}">
	                		<i class="icon ion-ios-people-outline tx-pink"></i>
			                <div class="media-body">
			                  	<p>Transaction Default Fees</p>
			                </div>
                                </a>
	              		</div>
	            	</div>    
	          	</div>
       	 	</div>


      	</div>
    </div>   
@endsection