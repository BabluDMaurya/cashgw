@extends('layouts.businessdashboard')
@section('content')
<!-- Tabs -->
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                @include('includes.business-invoice-menu')
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space">
                                            <div class="col-md-6">
                                                <h5 class="block-title">Address Book</h5>                                                                                      
                                                @if(session('status'))                                                
                                                <div class="alert alert-success alert-dismissible" id="msg" style="margin-left: 33px;"> 
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{ session('status') }}
                                                </div>
                                                @endif
                                                <div class="alert alert-success deletemsg" id="msg" style="display:none;margin-left: 33px;">Address Contact Deleted Successfully.</div>
                                            </div>   
                                            <div class="">
                                                <a href="#!" data-toggle="modal" data-target="#add-address" class="btn  round-btn  hvr-sweep-to-top  blue-btn">Add New Contact</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                                                <div class="search-with-icon">
                                                    <input id="myInput" class="form-control" type="text" placeholder="Search..">                       
                                                </div>
                                                <div class="list-group">
                                                    @if(count($addressbookDetails)>0)
                                                        @php $index = 0 @endphp
                                                        @foreach($addressbookDetails as $addBook)
                                                        <a href="#" class="list-group-item getSingleContactDetails @php echo $index == 0?'active':''; $index++; @endphp" id="{{$addBook->id}}">
                                                            <img src="{{url('/public/images/user.png')}}">{{$addBook->email}}
                                                        </a>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                             @if(count($addressbookDetails)>0)
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">                                                 
                                                <div id="getAjaxDetailsDiv" class="bhoechie-tab-content active">  
                                                    <div class="d-flex top-text ">
                                                        <p>{{$addressbookDetails[0]->email}}</p>
                                                        <p class="red-text deleteAddContact cursor_pointer" id="{{encrypt($addressbookDetails[0]->id)}}">Delete Contact</p>
                                                    </div>
                                                    <div class="accordion" id="accordion{{$addressbookDetails[0]->id}}">
                                                        <div class="accordion-group">
                                                            <div class="accordion-heading">
                                                                <a id="{{$addressbookDetails[0]->id}}" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$addressbookDetails[0]->id}}" href="#collapse{{$addressbookDetails[0]->id}}">
                                                                    Edit
                                                                </a>
                                                            </div>
                                                            <div id="collapse{{$addressbookDetails[0]->id}}" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <form class="common-form" id="AddressBookEdit" action="{{ url('business-address-book/'.encrypt($addressbookDetails[0]->user_id)) }}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="_method" value="PUT" />
                                                                        <input type="hidden" name="id" value="{{encrypt($addressbookDetails[0]->id)}}">
                                                                        <div class="row">
                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                <label>Recipients email address</label>
                                                                                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$addressbookDetails[0]->email}}">
                                                                                 @if($errors->has('email'))                                                
                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                        <strong>{{ $errors->first('email') }}</strong>
                                                                                    </span> 
                                                                                @endif 
                                                                            </div>
                                                                            <div class="col-md-6 form-group no-flex">
                                                                                <label>Business Name</label>
                                                                                <input type="text" class="form-control {{ $errors->has('business_name') ? ' is-invalid' : '' }}" id="business_name" name="business_name" value="{{$addressbookDetails[0]->business_name}}">
                                                                                @if($errors->has('business_name'))                                                
                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                        <strong>{{ $errors->first('business_name') }}</strong>
                                                                                    </span> 
                                                                                @endif 
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                <label>First Name</label>
                                                                                <input type="text" class="form-control {{ $errors->has('fname') ? ' is-invalid' : '' }}" id="fname" name="fname" value="{{$addressbookDetails[0]->fname}}">
                                                                                @if($errors->has('fname'))                                                
                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                        <strong>{{ $errors->first('fname') }}</strong>
                                                                                    </span> 
                                                                                @endif 
                                                                            </div> 
                                                                            <div class="col-md-6 form-group no-flex">
                                                                                <label>Last Name</label>
                                                                                <input type="text" class="form-control {{ $errors->has('lname') ? ' is-invalid' : '' }}" id="lname" name="lname" value="{{$addressbookDetails[0]->lname}}">
                                                                                @if($errors->has('lname'))                                                
                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                        <strong>{{ $errors->first('lname') }}</strong>
                                                                                    </span> 
                                                                                @endif 
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                <label>Country</label>
                                                                                <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" name="country">
                                                                                    <option value="" selected="">Please Select Country</option>
                                                                                    <option value="India" {{ $addressbookDetails[0]->country == 'India' ? 'selected' : ''}}>India</option>
                                                                                    <option value="UK" {{ $addressbookDetails[0]->country == 'UK' ? 'selected' : '' }}>UK</option>
                                                                                    <option value="USA" {{ $addressbookDetails[0]->country == 'USA' ? 'selected' : '' }}>USA</option>     
                                                                                </select>
                                                                                 @if($errors->has('country'))                                                
                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                        <strong>{{ $errors->first('country') }}</strong>
                                                                                    </span> 
                                                                                @endif 
                                                                            </div>
                                                                            <div class="col-md-6 form-group no-flex">
                                                                                <label>Phone</label>
                                                                                <input type="text" class="form-control" name="phone" value="{{$addressbookDetails[0]->phone}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">

                                                                            <div class="col-md-12 form-group no-flex">
                                                                                <label>Additional information</label>
                                                                                <input type="text" class="form-control" name="additional_information" value="{{$addressbookDetails[0]->additional_information}}">
                                                                            </div>
                                                                        </div>                    
                                                                        <div class="accordion" id="accordion{{$addressbookDetails[0]->id}}">
                                                                            <div class="accordion-group">
                                                                                <div class="accordion-heading">
                                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$addressbookDetails[0]->id}}" href="#billing{{$addressbookDetails[0]->id}}">
                                                                                        Billing address
                                                                                    </a>
                                                                                </div>
                                                                                <div id="billing{{$addressbookDetails[0]->id}}" class="accordion-body collapse">
                                                                                    <div class="accordion-inner">
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>Country</label>
                                                                                                <select class="form-control {{ $errors->has('billing_add_country') ? ' is-invalid' : '' }}" name="billing_add_country" id="billing_add_country">
                                                                                                    <option value="" selected="">Please Select Country</option>
                                                                                                    <option value="India" {{ $addressbookDetails[0]->billing_add_country == 'India' ? 'selected' : ''}}>India</option>
                                                                                                    <option value="UK" {{ $addressbookDetails[0]->billing_add_country == 'UK' ? 'selected' : '' }}>UK</option>
                                                                                                    <option value="USA" {{ $addressbookDetails[0]->billing_add_country == 'USA' ? 'selected' : '' }}>USA</option>                                                                              
                                                                                                </select>
                                                                                                @if($errors->has('billing_add_country'))                                                
                                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                                        <strong>{{ $errors->first('billing_add_country') }}</strong>
                                                                                                    </span> 
                                                                                                @endif 
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group no-flex">
                                                                                                <label>Address line 1</label>
                                                                                                <input type="text" class="form-control {{ $errors->has('billing_address_line_one') ? ' is-invalid' : '' }}" id="billing_address_line_one" name="billing_address_line_one" value="{{$addressbookDetails[0]->billing_address_line_one}}">
                                                                                                @if($errors->has('billing_address_line_one'))                                                
                                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                                        <strong>{{ $errors->first('billing_address_line_one') }}</strong>
                                                                                                    </span> 
                                                                                                @endif 
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>Address line 2</label>
                                                                                                <input type="text" class="form-control" id="billing_address_line_two" name="billing_address_line_two" value="{{$addressbookDetails[0]->billing_address_line_two}}">
                                                                                            </div> 
                                                                                            <div class="col-md-6 form-group no-flex">
                                                                                                <label>Town / City</label>
                                                                                                <input type="text" class="form-control {{ $errors->has('billing_address_town_city') ? ' is-invalid' : '' }}" id="billing_address_town_city" name="billing_address_town_city" value="{{$addressbookDetails[0]->billing_address_town_city}}">
                                                                                                @if($errors->has('billing_address_town_city'))                                                
                                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                                        <strong>{{ $errors->first('billing_address_town_city') }}</strong>
                                                                                                    </span> 
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>State</label>                                            
                                                                                                <select class="form-control {{ $errors->has('billing_address_state') ? ' is-invalid' : '' }}" id="billing_address_state" name="billing_address_state">
                                                                                                    <option value="" selected="">Please Select State</option>                                                                                                    
                                                                                                    <option value="Maharashtra" {{ $addressbookDetails[0]->billing_address_state == 'Maharashtra' ? 'selected' : ''}}>Maharashtra</option>
                                                                                                    <option value="Goa" {{ $addressbookDetails[0]->billing_address_state == 'Goa' ? 'selected' : '' }}>Goa</option>
                                                                                                    <option value="Rajasthan" {{ $addressbookDetails[0]->billing_address_state == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>  
                                                                                                </select>
                                                                                                 @if($errors->has('billing_address_state'))                                                
                                                                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                                                                        <strong>{{ $errors->first('billing_address_state') }}</strong>
                                                                                                    </span> 
                                                                                                @endif
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group no-flex">
                                                                                                <label>Pincode</label>
                                                                                                <input type="text" class="form-control" id="billing_address_zipcode" name="billing_address_zipcode" value="{{$addressbookDetails[0]->billing_address_zipcode}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="accordion-group">
                                                                                <div class="accordion-heading">
                                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$addressbookDetails[0]->id}}" href="#shipping{{$addressbookDetails[0]->id}}">
                                                                                        Shipping address
                                                                                    </a>
                                                                                </div>
                                                                                <div id="shipping{{$addressbookDetails[0]->id}}" class="accordion-body collapse">
                                                                                    <div class="accordion-inner">
                                                                                        <div class="position-relative"> 
                                                                                            <label class="l-checkbox">
                                                                                                <p>Same as billing</p>
                                                                                                <input type="checkbox">
                                                                                                <span class="checkmark"></span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>First Name</label>
                                                                                                <input type="text" class="form-control" name="shipping_address_fname" id="shipping_address_fname" value="{{$addressbookDetails[0]->shipping_address_fname}}">
                                                                                            </div> 
                                                                                            <div class="col-md-6 form-group no-flex">
                                                                                                <label>Last Name</label>
                                                                                                <input type="text" class="form-control" name="shipping_address_lname" id="shipping_address_lname" value="{{$addressbookDetails[0]->shipping_address_lname}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>Business Name</label>
                                                                                                <input type="text" class="form-control" name="shipping_address_business_name" id="shipping_address_business_name" value="{{$addressbookDetails[0]->shipping_address_business_name}}">
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>Country</label>
                                                                                                <select class="form-control" id="shipping_address_country" name="shipping_address_country">
                                                                                                    <option value="" selected="">Please Select Country</option>
                                                                                                    <option value="India" {{ $addressbookDetails[0]->shipping_address_country == 'India' ? 'selected' : ''}}>India</option>
                                                                                                    <option value="UK" {{ $addressbookDetails[0]->shipping_address_country == 'UK' ? 'selected' : '' }}>UK</option>
                                                                                                    <option value="USA" {{ $addressbookDetails[0]->shipping_address_country == 'USA' ? 'selected' : '' }}>USA</option>     
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group no-flex">
                                                                                                <label>Address line 1</label>
                                                                                                <input type="text" class="form-control" name="shipping_address_line_one" id="shipping_address_line_one" value="{{$addressbookDetails[0]->shipping_address_line_one}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>Address line 2</label>
                                                                                                <input type="text" class="form-control" name="shipping_address_line_two" id="shipping_address_line_two" value="{{$addressbookDetails[0]->shipping_address_line_two}}">
                                                                                            </div> 
                                                                                            <div class="col-md-6 form-group no-flex">
                                                                                                <label>Town / City</label>
                                                                                                <input type="text" class="form-control" name="shipping_address_town_city" id="shipping_address_town_city" value="{{$addressbookDetails[0]->shipping_address_town_city}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 form-group required no-flex">
                                                                                                <label>State</label>
                                                                                                <select class="form-control" id="shipping_address_state" name="shipping_address_state">
                                                                                                    <option value="" selected="">Please Select State</option>
                                                                                                    <option value="Maharashtra" {{ $addressbookDetails[0]->shipping_address_state == 'Maharashtra' ? 'selected' : ''}}>Maharashtra</option>
                                                                                                    <option value="Goa" {{ $addressbookDetails[0]->shipping_address_state == 'Goa' ? 'selected' : '' }}>Goa</option>
                                                                                                    <option value="Rajasthan" {{ $addressbookDetails[0]->shipping_address_state == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option> 
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group no-flex">
                                                                                                <label>Pincode</label>
                                                                                                <input type="text" class="form-control" name="shipping_address_zipcode" id="shipping_address_zipcode" value="{{$addressbookDetails[0]->shipping_address_zipcode}}">
                                                                                            </div>
                                                                                        </div>                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="accordion-group">
                                                                                <div class="accordion-heading">
                                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$addressbookDetails[0]->id}}" href="#customer-memo{{$addressbookDetails[0]->id}}">
                                                                                        Customer Memo
                                                                                    </a>
                                                                                </div>
                                                                                <div id="customer-memo{{$addressbookDetails[0]->id}}" class="accordion-body collapse">
                                                                                    <div class="accordion-inner">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12 form-group required no-flex">
                                                                                                <label>Customer Memo</label> 
                                                                                                <textarea class="form-control" placeholder="Add memo to self (your recipient won't see this)" rows="5" name="customer_memo">{{$addressbookDetails[0]->customer_memo}}</textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="">
                                                                            <div class="title-equal-space">
                                                                                <div class="col-md-6">
                                                                                </div>
                                                                                <div class="">
                                                                                    <a class="btn light-grey-btn round-btn hvr-sweep-to-top" data-toggle="collapse" data-parent="#accordion{{$addressbookDetails[0]->id}}" href="#collapse{{$addressbookDetails[0]->id}}">Close</a>                                
                                                                                    <input type="submit" class="btn round-btn  hvr-sweep-to-top  blue-btn" value="Save">
                                                                                </div>
                                                                            </div>
                                                                        </div>   
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>                                                
                                                </div>                                                
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- ./Tabs -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-address">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-center">Add Address</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form id="AddressBookAdd" action="{{URL('/business-address-book')}}" method="post">
                    {{ csrf_field() }}      
                    <!-- Modal body -->            
                    <div class="modal-body">                
                        <div class="row">
                            <div class="col-md-6 form-group required no-flex">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname">
                            </div> 
                            <div class="col-md-6 form-group no-flex">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required no-flex">
                                <label>Recipients email address</label>
                                <input type="text" class="form-control" name="email">
                            </div>
                            <div class="col-md-6 form-group no-flex">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                        </div>                
                        <div class="margin-auto">
                            <input type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20" value="Submit"> 
                        </div>            
                    </div>
                </form>                               
            </div>
        </div>
    </div>    
    <script>
       var token  = '{{csrf_token()}}';
        window.FontAwesomeConfig = {
            searchPseudoElements: true
        }
        $(document).ready(function () {
            $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
//                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
//                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
        });
        /**
         * EFECTO PARA FLECHAS EN ACORDEON
         */

        $(document).on('show', '.accordion', function (e) {
            //$('.accordion-heading i').toggleClass(' ');
            $(e.target).prev('.accordion-heading').addClass('accordion-opened');
        });

        $(document).on('hide', '.accordion', function (e) {
            $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
            //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
        });
    </script>
    <script>
        $('.collapse').on('show.bs.collapse', function () {
            $otherPanels = $(this).parents('.panel-group').siblings('.panel-group');
            $('.collapse', $otherPanels).removeClass('in');
        });
    </script>
    <script>
        $(document).ready(function () {
            $.validator.addMethod("alpha", function (value, element) {
                return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
            });
            $.validator.addMethod("alphaWithSpace", function (value, element) {
                return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
            });
            $.validator.addMethod("customEmail", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
            }, "Please enter valid email address!");

            $.validator.addMethod("phoneUS", function (phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
            }, "Please specify a valid phone number");

            jQuery.validator.addMethod("zipcode", function (value, element) {
                return this.optional(element) || /^\d{6}$/.test(value);
            }, "Please provide a valid zipcode.");

            $("#AddressBookAdd").validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback',

                rules: {
                    fname: {
                        required: true,
                        alpha: true
                    },
                    lname: {
                        required: true,
                        alpha: true
                    },
                    email: {
                        required: true,
                        customEmail: true,
                        remote: {
                                url: BASE_URL+'/business_check_addressbook_email',
                                type: 'POST',
                                data: {
                                    email: function ()
                                    {
                                        return $('#AddressBookAdd :input[name="email"]').val();
                                    }, 
                                     _token: token,
                                },                               
                        }
                    },
                    phone: {
                        required: true,
                        phoneUS: true
                    },
                },

                highlight: function (element) {
                    // add a class "has_error" to the element 
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    // remove the class "has_error" from the element 
                    $(element).removeClass('is-invalid');
                },
                messages: {
                    fname: {
                        required: "First Name Required",
                        alpha: "Only Alphabets allow",
                    },
                    lname: {
                        required: "Last Name Required",
                        alpha: "Only Alphabets allow",
                    },
                    email: {
                        required: "Email Address Required",
                        customEmail: "Please enter Valid Email",
                        remote:"Already in use."
                    },
                    phone: {
                        required: "Phone Number Required",
                        phoneUS: "Only 10 Digit Numbers",
                    },
                },
            });
            
            $("#AddressBookEdit").validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback',

                rules: {
                    email: {
                        required: true,
                        customEmail: true
                    },
                    business_name: {
                        required: true,
                        alphaWithSpace: true
                    },
                    fname: {
                        required: true,
                        alpha: true
                    },
                    lname: {
                        required: true,
                        alpha: true
                    },
                    country:{
                        required: true,                        
                    },
                    additional_information:{
                        maxlength:150,
                    },
                    billing_add_country:{
                        required: true,        
                    },
                    billing_address_line_one:{
                        required: true,    
                         maxlength:150,
                    },
                    billing_address_line_two:{                        
                         maxlength:150,
                    },
                    billing_address_town_city:{
                        required: true,    
                    },
                    billing_address_state:{
                        required: true,    
                    },
                    billing_address_zipcode:{
                        required: true,
                        zipcode : true,
                    },
                    shipping_address_zipcode:{
                        required: true, 
                        zipcode : true,
                    },
                    shipping_address_line_one: {
                       required: true,
                         maxlength:150,
                    },
                    shipping_address_line_two:{
                          maxlength:150,
                    },
                    customer_memo:{
                        maxlength:300,
                    }
                    
                },

                highlight: function (element) {
                    // add a class "has_error" to the element 
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    // remove the class "has_error" from the element 
                    $(element).removeClass('is-invalid');
                },
                messages: {
                    email: {
                        required: "Email Address Required",
                        customEmail: "Please enter Valid Email",
                    },
                    business_name: {
                        required: "Business name Required",
                        alphaWithSpace: "Only Alphabets and space allow",
                    },
                    fname: {
                        required: "First Name Required",
                        alpha: "Only Alphabets allow",
                    },
                    lname: {
                        required: "Last Name Required",
                        alpha: "Only Alphabets allow",
                    },
                    country: {
                        required: "Country Required",                        
                    },
                    additional_information:{
                        maxlength:"Maximum 150 character allow",
                    },
                    billing_add_country: {
                        required: "Billing Country Required",                        
                    },
                    billing_address_line_one: {
                        required: "Billing Address Line 1 Required",                        
                        maxlength:"Maximum 150 character allow",
                    },
                    billing_address_line_two:{
                         maxlength:"Maximum 150 character allow",
                    },
                    billing_address_town_city:{
                        required: "Billing Address Town Required",       
                    },
                    billing_address_state:{
                        required: "Billing Address State Required",     
                },
                     billing_address_zipcode:{
                        required: "Pincode Required",
                        zipcode : "Only 6 digit's number allow",
                    },
                    shipping_address_zipcode:{
                        required: "Pincode Required", 
                        zipcode : "Only 6 digit's number allow",
                    },
                    shipping_address_line_one: {
                        required: "Billing Address Line 1 Required",
                        maxlength:"Maximum 150 character allow",
                    },
                    shipping_address_line_two:{
                         maxlength:"Maximum 150 character allow",
                    },
                    customer_memo:{
                        maxlength:"Maximum 300 character allow",
                    }
                },
            });

            $(document).on('click', '.getSingleContactDetails', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{url("BusinessGetSingleContactDetails")}}',
                    type: 'post',
                    data: {id: id},
                    success: function (data) {
                        $('#getAjaxDetailsDiv').html(data);
                    },
                    error: function () {
                        console.log("ajax call went wrong:");
                    },
                });
            });
            
            $(document).on('click', '.deleteAddContact', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                //alert(id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{url("BusinessDeleteAddressContact")}}',
                    type: 'post',
                    data: {id: id},
                    success: function () {
                        $('.deletemsg').show();
                        $(".deletemsg").fadeTo(3000, 500).slideUp(500, function () {
                            $(".deletemsg").slideUp(500);
                        });
                        location.reload();
                    },
                    error: function () {
                        console.log("ajax call went wrong:");
                    },
                });
            });
        });
            $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                  var value = $(this).val().toLowerCase();
                  $(".list-group a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                  });
                });
            });
        
    </script>
    <script>
        $('input[type="checkbox"]').click(function () {
            if ($(this).prop("checked") == true) {
                var fname = $('#fname').val();
                var lname = $('#lname').val();
                var business_name = $('#business_name').val();
                var billing_add_country = $('#billing_add_country').children("option:selected").val();
                var billing_address_line_one = $('#billing_address_line_one').val();
                var billing_address_line_two = $('#billing_address_line_two').val();
                var billing_address_town_city = $('#billing_address_town_city').val();
                var billing_address_state = $('#billing_address_state').children("option:selected").val();
                var billing_address_zipcode = $('#billing_address_zipcode').val();

                $('#shipping_address_fname').val(fname);
                $('#shipping_address_lname').val(lname);
                $('#shipping_address_business_name').val(business_name);
                $('#shipping_address_country').val(billing_add_country);
                $('#shipping_address_line_one').val(billing_address_line_one);
                $('#shipping_address_line_two').val(billing_address_line_two);
                $('#shipping_address_town_city').val(billing_address_town_city);
                $('#shipping_address_state').val(billing_address_state);
                $('#shipping_address_zipcode').val(billing_address_zipcode);

            } else if ($(this).prop("checked") == false) {
                $('#shipping_address_fname').val("");
                $('#shipping_address_lname').val("");
                $('#shipping_address_business_name').val("");
                $('#shipping_address_country').val("");
                $('#shipping_address_line_one').val("");
                $('#shipping_address_line_two').val("");
                $('#shipping_address_town_city').val("");
                $('#shipping_address_state').val("");
                $('#shipping_address_zipcode').val("");
            }
        });
    </script>
    @endsection

