@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="block-item shadow-block">
                    <ul class="sidebar-nav">
                        <li ><a href="{{URL('withdraw')}}">Withdraw money</a></li>
                        <li><a href="{{URL('send-request-money')}}">Send or request money</a></li>
<!--                        <li class="active"><a href="{{URL('payment-preferences')}}">Payment Preferences</a></li>
                        <li><a href="#!">Merchant fees</a></li>-->
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="block-item shadow-block">
                    <h5 class="balance-title">Choose your preferred way to pay online</h5>
                    <div class="detail-det text-center">
                        <p>We’ll use this when you shop online or send payments for goods and services. You can always choose a different way to pay at checkout.</p>
                        <p class="d-flex account-fill">
                            <a href="#!" data-toggle="modal" data-target="#more-about-payment">More about Payment preferences</a> 
                            <a href="#!" data-toggle="modal" data-target="#add-account">Add Account</a> 
                        </p>
                        <div class="col-md-6 margin-auto">
                            <ul class="account-list currency-list ">
                                <li>
                                    <div class="img-card">
                                        <img src="{{url('/public/images/cg.png')}}">
                                    </div>
                                    <div>
                                        <label class="l-radio"> 
                                            <span>CashGW balance </span>
                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-card">
                                        <img src="{{url('/public/images/bank.jpg')}}">
                                    </div>
                                    <div>
                                        <label class="l-radio"> 
                                            <div>
                                                <span>ICICI BANK LTD </span>
                                                <small>Checking ••••1394</small>
                                            </div>
                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-card">
                                        <img src="{{url('/public/images/master-card.png')}}">
                                    </div>
                                    <div>
                                        <label class="l-radio"> 
                                            <span>MasterCard</span>
                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                            </ul>   
                            <a href="#!" class="btn dark-btn round-btn btn-block w-100 hvr-sweep-to-top l-btn" data-dismiss="modal">Confirm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="more-about-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Preferred when paying online</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>      
            <div class="modal-body">
                <p>Setting a preferred way to pay online can help you check out even faster. Of course, you’ll always be able choose a different way to pay at checkout.</p>
                <p>We’ll use it when you:</p>
                <p><strong>Your preferred way to pay online is your choice</strong></p>
                <p>It’s quick and easy to set your payment preference. If you don’t set a preference, we’ll show all of your eligible payment methods when it’s time to pay.</p>
                <p><strong>More about payment preferences</strong></p>
                <p>You can set your linked debit card or credit card as your preferred way to pay online. You won’t be able to set your PayPal balance or bank account as preferred. You can change your preferred way to pay online anytime. Simply go to your Profile to set a different preference.
                </p>
                <div class="col-lg-10 margin-auto">
                    <button type="button" class="btn btn-dark btn-block round-btn mt-20 mb-20" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade " id="add-account">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Add Account</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#bank-account" class="active ">Add Bank Account</a></li>
                    <li><a data-toggle="tab" href="#credit-card">Credit Card</a></li>
                    <li><a data-toggle="tab" href="#debit-card">Debit Card</a></li>
                </ul>
                <div class="tab-content">
                    <div id="bank-account" class="tab-pane in active">
                        <form class="common-form ">
                            <div class="row">
                                <div class="col-md-12 form-group required">
                                    <label>Account Holder Name</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Branch Name</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="" value="rushabh123@yopmail.com">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>S.W.I.F.T</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>IFSC</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col-lg-10 margin-auto">
                                <button type="button" class="btn btn-dark btn-block round-btn mt-20 mb-20" data-dismiss="modal">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div id="credit-card" class="tab-pane fade">
                        <form class="common-form ">
                            <div class="row">
                                <div class="col-md-12 form-group required">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>CVV</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Billing Address1</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Billing Address2</label>
                                    <input type="text" class="form-control" placeholder="" value="rushabh123@yopmail.com">
                                </div>
                            </div>
                            <div class="col-lg-10 margin-auto">
                                <button type="button" class="btn btn-dark btn-block round-btn mt-20 mb-20" data-dismiss="modal">Submit</button>
                            </div>        
                        </form>
                    </div>
                    <div id="debit-card" class="tab-pane fade">
                        <form class="common-form ">
                            <div class="row">
                                <div class="col-md-12 form-group required">
                                    <label>Card Number</label>                              
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>CVV</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Billing Address1</label>
                                    <input type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Billing Address2</label>
                                    <input type="text" class="form-control" placeholder="" value="rushabh123@yopmail.com">
                                </div>
                            </div>
                            <div class="col-lg-10 margin-auto">
                                <button type="button" class="btn btn-dark btn-block round-btn mt-20 mb-20" data-dismiss="modal">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>       
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#get-more").click(function () {
            $(".get-more-sec").slideToggle();
        });
    });
</script>
@endsection