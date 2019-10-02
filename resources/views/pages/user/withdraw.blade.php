@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">                
            <div class="col-md-4">
                <div class="block-item shadow-block">
                    <ul class="sidebar-nav">
                        <li class="active"><a href="{{URL('withdraw')}}">Withdraw money</a></li>
                        <li><a href="{{URL('send-request-money')}}">Send or request money</a></li>
<!--                        <li><a href="{{URL('payment-preferences')}}">Payment Preferences</a></li>
                        <li><a href="#!">Merchant fees</a></li>-->
                    </ul>
                </div>  
            </div>
            <div class="col-md-8">
                <div class="block-item shadow-block">
                    <h5 class="balance-title">Withdraw </h5>
                    <div class="detail-det">
                        <div class="withdraw-options">                                
                            <a href="#!" class="as-btn" data-toggle="modal" data-target="#withdraw-from">From </a>
                            <a href="#!" class="as-btn" data-toggle="modal" data-target="#withdraw-to">To </a>
                            <a href="#!" class="btn btn-dark round-btn hvr-sweep-to-top">Continue </a>                               
                        </div>                                                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade " id="withdraw-from">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">From</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="account-list currency-list">
                    <li>
                        <div class="img-card">
                            <img src="{{url('/public/images/flag.jpg')}}">
                        </div>
                        <div>
                            <label class="l-radio"> 
                                <span>CashGw balance $ 0.00 USD </span>
                                <input type="radio" checked="checked" name="radio">
                                <span class="checkmark"></span>
                            </label>                      
                        </div>
                    </li>
                </ul>
                <a href="#!" class="btn blue-btn round-btn btn-block hvr-sweep-to-top margin-auto" data-dismiss="modal">Submit</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="withdraw-to">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">To</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="account-list currency-list">
                    <li>
                        <div class="img-card">
                            <img src="{{url('/public/images/bank.jpg')}}">
                        </div>
                        <div>
                            <div>
                                <label class="l-radio"> 
                                    <span>ICICI BANK LTD Checking ••••1394 </span>
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>                     
                            </div>                     
                        </div>
                    </li>
                </ul>
                <a href="#!" class="btn blue-btn round-btn btn-block hvr-sweep-to-top margin-auto" data-dismiss="modal">Submit</a>
            </div>
        </div>
    </div>
</div>
@endsection()