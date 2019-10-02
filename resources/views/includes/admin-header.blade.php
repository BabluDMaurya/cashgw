<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CASHGW</title>
        <link href="{{url('/public/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{url('/public/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
        <link href="{{url('/public/css/jquery.dataTables.css')}}" rel="stylesheet">
        <link href="{{url('/public/css/select2.min.css')}}" rel="stylesheet">
        <link href="{{url('/public/css/chartist.css')}}" rel="stylesheet">
        <link href="{{url('/public/css/rickshaw.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{url('/public/css/slim.css')}}">
        <script src="{{url('/public/js/jquery.js')}}"></script>
  </head>
  <div class="loader"></div>
  <body>
    <div class="slim-header">
      	<div class="container-fluid">
        	<div class="slim-header-left">
                    <h2 class="slim-logo">
                        <a href="{{URL('admin')}}">
                            <img class="img-fluid" src="{{URL('/public/images/logo.png')}}" />
                        </a>
                    </h2>
        	</div><!-- slim-header-left -->
	        <div class="slim-header-right">
                        <div class="dropdown dropdown-c">
		            <a href="#" class="logged-user" data-toggle="dropdown">
		              	<i class="fa fa-bell"></i>
                                @if(Auth::guard('admin')->user()->unreadNotifications->count())
                                 <span class="badge badge-light">{{Auth::guard('admin')->user()->unreadNotifications->count()}}</span>
                                @endif
		            </a> 
                             @if(Auth::guard('admin')->user()->unreadNotifications->count())
		            <div class="dropdown-menu dropdown-menu-right">
		              	<nav class="nav">
                                    @foreach(auth()->user()->unreadNotifications as $notification)  
                                    @switch($notification->type)
                                        @case('App\Notifications\ContactUs')
                                            <a href="{{URL('/contact-management')}}" class="nav-link">{{$notification->data['message']}}</a>
                                        @break
                                        @case('App\Notifications\ManagePaymentRequest')
                                            <a href="{{URL('/manage-payment-request')}}" class="nav-link activetab" data-currenttabchild="{{$notification->data['tab']}}">{{$notification->data['message']}}</a>
                                        @break
                                        @case('App\Notifications\IndividualApproval')
                                            <a href="{{URL('/individual-user-verification')}}" class="nav-link activetab" data-currenttabchild="{{$notification->data['tab']}}">{{$notification->data['message']}}</a>
                                        @break
                                        @case('App\Notifications\BusinessApproval')
                                            <a href="{{URL('/business-user-verification')}}" class="nav-link activetab" data-currenttabchild="{{$notification->data['tab']}}">{{$notification->data['message']}}</a>
                                        @break
                                        @case('App\Notifications\UpdateApproval')
                                            <a href="{{URL('/primary-address-approval')}}" class="nav-link activetab" data-currenttabchild="{{$notification->data['tab']}}">{{$notification->data['message']}}</a>
                                        @break
                                        @default
                                            <a class="nav-link">Something went wrong, please try again</a>
                                        @break    
                                    @endswitch                                
                                @endforeach   
		              	</nav>
		            </div><!--notification dropdown-menu -->
                             @endif
		      	</div><!-- notification dropdown -->
                        
		      	<div class="dropdown dropdown-c">
		            <a href="#" class="logged-user" data-toggle="dropdown">
		              	<img src="{{URL('/public/images/person.jpg')}}" alt="">
		              	<span>Admin</span>
		              	<i class="fa fa-angle-down"></i>
		            </a>                            
		            <div class="dropdown-menu dropdown-menu-right">
		              	<nav class="nav">
                                    <a href="#!" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
                                    <a href="#!" class="nav-link"><i class="icon ion-compose"></i> Edit Profile</a>
                                    <a href="{{ route('logout') }}" class="nav-link"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="icon ion-forward"></i> Sign Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>                                    
		              	</nav>
		            </div><!-- dropdown-menu -->
		      	</div><!-- dropdown -->
	        </div><!-- header-right -->
      	</div><!-- container-fluid -->
    </div><!-- slim-header -->

    <div class="slim-navbar">
      	<div class="container-fluid">
            	@include('includes.admin-menu')
      	</div><!-- container-fluid -->
    </div><!-- slim-navbar -->