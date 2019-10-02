@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="block-item shadow-block">
                    @include('includes.userdashboardsidebarmenu')
                </div>
            </div>
            <div class="col-md-8">
                <div class="block-item shadow-block">
                    <h5 class="balance-title">Send Request Money </h5>
                    <div class="detail-det">
                        <div class="send-request-items">
                            <a href="{{URL('/individual-request-payment/'.$user_id)}}" class="send-item" >
                                <div class="ico-img">
                                    <img src="{{URL('public/images/send1.png')}}">
                                </div>
                                <h4>Request from customers</h4>
                                <p>You will pay a fee when you<br>
                                    receive the payment.
                                </p>
                                <div class="highlighted-sec">
                                    Covered by CashGW Seller Protection, where eligible.
                                </div>
                            </a>
                            <a href="{{URL('/individual-send-money/'.$user_id)}}" class="send-item" >
                                <div class="ico-img">
                                    <img src="{{URL('public/images/send2.png')}}">
                                </div>
                                <h4>Send to customers</h4>
                                <p>You will pay a fee when you<br>
                                    send payment.
                                </p>
                                <div class="highlighted-sec">
                                    Covered by CashGW Seller Protection, where eligible.
                                </div>
                            </a>
                        </div>                                                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection