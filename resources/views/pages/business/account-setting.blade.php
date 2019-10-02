@extends('layouts.businessdashboard')
@section('content')

<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                <nav>
                    <div class="container pd0">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" href="{{URL('/business-account/'.$user_id)}}">Account</a>
                            <a class="nav-item nav-link" href="{{URL('/business-security/'.$user_id)}}">Security</a>
                        </div>
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    @if (session('status'))
                                <div class=" main_alert alert alert-success alert-dismissible"> 
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('status') }}
                                </div>
                            @endif
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class="block-item shadow-block">
                                    <h5 class="block-title">Profile</h5>
                                    <div class="name-det"> 
                                        @if(!empty($user_id))
                                        <div class="img-side">  
                                            {{ csrf_field() }}                                            
                                            <img src="{{url('/public/images/')}}/{{decrypt($user_id)}}/{{$businesskyc->photo}}" id="myImg">                                             
                                            <input type="file" accept="image/png, image/jpeg" class="custom-file-input upload_pro_image {{ $errors->has('myphoto') ? ' is-invalid' : '' }}" id="upload_image" img_id="myImg" img_height="224" img_width="325" imagefolder="images" required="" aria-required="true">  
                                            <input type="hidden" id="myphoto" name="myphoto">                                                                                                                                
                                            @if($errors->has('myphoto'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('myphoto') }}</strong>
                                                </span> 
                                            @endif
                                        </div>                                        
                                        @else
                                        <div class="img-side">                                           
                                            <img src="{{url('/public/images/about.png')}}" id="myImg">
                                            <input type="file" class="custom-file-input upload_img">
                                        </div>                                         
                                        @endif
                                        <div>
                                            <p class="block-name">{{$businesskyc->fname}}</p> 
                                            
                                            <p>Joined in {{date('F jS, Y', strtotime($user_join))}}</p>
                                            <p class="price-b">                                                 
                                                $ @if($balance['USD'] > 0){{$balance['USD']}} @else 0.00 @endif<br/>
                                                &euro; @if($balance['EUR'] > 0){{$balance['EUR']}} @else 0.00 @endif
                                            </p>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="block-item shadow-block">  
                                    @if(empty($businesskyc->add_line_one) || empty($business->billing_address_line_one))
                                    <a href="#!" class="float-right" data-toggle="modal" data-target="#add-address"><i class="fas fa-plus"></i> Add Address</a>
                                    @endif
                                    <h5 class="block-title">Addresses</h5>
                                    <div class="detail-det">                                                                                 
                                        <div class="d-flex">
                                            <div class="twodivide">
                                                <p class="larger-text">Primary address</p>  
                                                <p class="pr15">{{ $businesskyc->add_line_one }},{{ $businesskyc->add_line_two }},{{ $businesskyc->town_or_city }},<br>{{ $businesskyc->country }},{{ $businesskyc->zip }}<br>
                                                    <a href="#!" id="primary" data-toggle="modal" data-target="#edit-address-primary" class="editUserAddress">Edit</a></p>
                                            </div>
                                            @if(!empty($business->billing_address_line_one))
                                            <div class="secondary_address twodivide">
                                                <p class="larger-text">Secondary Address</p>
                                                <p class="pr15">{{ $business->billing_address_line_one }},{{ $business->billing_address_line_two }},{{ $business->billing_address_townOrcity }},<br>{{ $business->billing_address_country }},{{ $business->billing_address_zipcode }}<br>
                                                    <a href="#!" id="secondary" data-toggle="modal" data-target="#edit-address-billing" class="editUserAddress">Edit</a></p>
                                            </div>
                                            @endif
                                        </div>                                            
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="block-item shadow-block">
                                    <h5 class="block-title">Account Options</h5> 
                                    <form action="{{URL('/business-account/'.$user_id)}}" class="common-form myform" id="PersonalDetails" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <input type="hidden" name="_method" value="PUT" />
                                            <label for="FirstName" class="col-lg-4 col-form-label ">First Name</label>
                                            <div class="col-lg-8">
                                                <input id="test1" type="text" class="form-control {{ $errors->has('FirstName') ? ' is-invalid' : '' }}" name="FirstName" value="{{ $businesskyc->fname}}">
                                                @if($errors->has('FirstName'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('FirstName') }}</strong>
                                                    </span> 
                                                @endif
                                            </div>                                            
                                        </div>
                                        <div class="form-group row">
                                            <label for="MiddleName" class="col-lg-4 col-form-label ">Middle Name</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control {{ $errors->has('MiddleName') ? ' is-invalid' : '' }}" name="MiddleName" value="{{ $businesskyc->mname}}">
                                                @if($errors->has('MiddleName'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('MiddleName') }}</strong>
                                                    </span> 
                                                @endif
                                            </div>                                            
                                        </div>
                                        <div class="form-group row">
                                            <label for="LastName" class="col-lg-4 col-form-label ">Last Name</label>
                                            <div class="col-lg-8">
                                                <input type="text"  id="test2" class="form-control {{ $errors->has('LastName') ? ' is-invalid' : '' }}" name="LastName" value="{{ $businesskyc->lname}}">
                                                @if($errors->has('LastName'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('LastName') }}</strong>
                                                    </span> 
                                                @endif
                                            </div>                                            
                                        </div>
                                        <div class="form-group row">
                                            <label for="Language" class="col-lg-4 col-form-label ">Language</label>
                                            <div class="col-lg-8">
                                                <select class="form-control {{ $errors->has('LangId') ? ' is-invalid' : '' }}" name="LangId">
                                                    <option value="" {{$business->lang == '' ? 'selected' : ''}}>Please Select Language</option>
                                                    <option value="1" {{$business->lang == 1 ? 'selected' : ''}}>English</option>
                                                    <option value="2" {{$business->lang == 2 ? 'selected' : ''}}>Hindi</option>
                                                    <option value="3" {{$business->lang == 3 ? 'selected' : ''}}>German</option>
                                                </select>
                                                @if($errors->has('LangId'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('LangId') }}</strong>
                                                    </span> 
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Country" class="col-lg-4 col-form-label ">Nationality</label>
                                            <div class="col-lg-8">
                                                <select class="form-control {{ $errors->has('Country') ? ' is-invalid' : '' }}" name="Country">
                                                    <option value="" {{ $businesskyc->country == '' ? 'selected' : ''}}>Please Select Country</option>
                                                    <option value="India" {{ $businesskyc->country == 'India' ? 'selected' : ''}}>India</option>
                                                    <option value="UK" {{ $businesskyc->country == 'UK' ? 'selected' : '' }}>UK</option>
                                                    <option value="USA" {{ $businesskyc->country == 'USA' ? 'selected' : '' }}>USA</option>                                                                                
                                                </select>
                                                @if($errors->has('Country'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('Country') }}</strong>
                                                    </span> 
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class=" col-lg-9 margin-auto mt-30">
                                                <input type="submit" class="btn btn-primary btn-block btn-dark round-btn hvr-sweep-to-top" value="Save the changes">
                                            </div>
                                        </div>
                                        <p class="text-center"><a data-toggle="modal" data-target="#close-your-account">Close Your Account</a></p>

                                    </form>                                    
                                    <div class="alert alert-success" style="display:none;">Profile Updated Successfully.</div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex flex-column">
                                <div class="block-item shadow-block">
                                    @if(empty($business->primary_email) || empty($business->secondary_email))

                                            <a href="#!" class="float-right" data-toggle="modal" data-target="#add-email-address"><i class="fas fa-plus"></i> Add Email Address</a>
                                    @endif        
                                    <h5 class="block-title">Email Addresses</h5>
                                    <div class="detail-det">
                                        <div class="d-flex">
                                            @if(!empty($business->primary_email))
                                                <div class="twodivide">
                                                    <p class="larger-text">Primary Email</p> 
                                                    <p id="3" class="pr15">
                                                        {{$business->primary_email}}<br>
                                                        <!--<a href="#!" class="editEmail" id="primary" data-no="{{$business->primary_email}}" data-id="1" data-toggle="modal" data-target="#edit-email-address">Edit</a>-->
                                                    </p>
                                                </div>       
                                            @endif     
                                            @if(!empty($business->secondary_email))
                                                <div class="secondary_emailaddress twodivide">
                                                    <p class="larger-text">Secondary Email</p>
                                                    <p id="4" class="pr15">
                                                        {{$business->secondary_email}}<br>
                                                        <a href="#!" class="editEmail anchortag" id="secondary" data-no="{{$business->secondary_email}}" data-id="2" data-toggle="modal" data-target="#edit-email-address">Edit</a>
                                                        
                                                    </p>
                                                </div>  
                                            @endif                                              
                                        </div>
                                        @if($errors->has('emailaddress'))
                                            <div class="form-control {{ $errors->has('emailaddress') ? ' is-invalid' : '' }}">
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('emailaddress') }}</strong>
                                                </span>                                                
                                             </div>   
                                            @endif
                                        <div>
                                            <p>To update an email address, you must have at least two
                                                email addresses on file</p>                                              
                                        </div> 
                                    </div>
                                </div>
                                <div class="block-item shadow-block"> 
                                    @if(empty($business->primary_phone) || empty($business->secondary_phone))
                                        <a href="#!" class="float-right" data-toggle="modal" data-target="#add-phone"><i class="fas fa-plus"></i> Add Phone</a>
                                    @endif   
                                        <h5 class="block-title">Phone </h5>
                                            <div class="detail-det">
                                                <div class="d-flex">
                                                @if(!empty($business->primary_phone))
                                                    <div class="twodivide">
                                                        <p class="larger-text">Primary, </p>
                                                        <p class="pr15">{{$business->primary_phone}}<br>
                                                           <a href="#!" id="primary" class="editPhone anchortag" data-no="{{$business->primary_phone}}" data-id="1" data-toggle="modal" data-target="#edit-phone">Edit</a>                                                           
                                                        </p>
                                                    </div>
                                                @endif   
                                                @if(!empty($business->secondary_phone))
                                                    <div class="secondary_phone twodivide">
                                                        <p class="larger-text">Mobile,
        
                                                        </p>
                                                        <p class="pr15">{{$business->secondary_phone}}<br>
                                                            <a href="#!" id="secondary" class="editPhone anchortag" data-no="{{$business->secondary_phone}}" data-id="2" data-toggle="modal" data-target="#edit-phone">Edit</a>                                                           
                                                        </p>    
                                                    </div>
                                                @endif    
                                                </div>  
                                                @if($errors->has('emailaddress'))
                                                <div class="form-control {{ $errors->has('phonenumber') ? ' is-invalid' : '' }}">
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                                    </span>                                                
                                                 </div>   
                                                @endif
                                            </div>                                     
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>	
</section>
<div class="modal fade " id="add-address">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Secondary Address</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{URL('/business-account/')}}" class="common-form myform" id="AddAddress" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 form-group required">
                            <input type="text" class="form-control {{ $errors->has('addlone') ? ' is-invalid' : '' }}" placeholder="Address Line 1" name="addlone" value="{{old('addlone')}}">
                            @if ($errors->has('addlone'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addlone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                                
                            <input type="text" class="form-control" placeholder="Address Line 2"  name="addltwo" value="{{old('addltwo')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required">                              
                            <input type="text" class="form-control {{ $errors->has('towncity') ? ' is-invalid' : '' }}" placeholder="Town/ City"  name="towncity" value="{{old('towncity')}}">
                            @if ($errors->has('towncity'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('towncity') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                                 
                            <input type="text" class="form-control {{ $errors->has('zip') ? ' is-invalid' : '' }}" placeholder="Zipcode" name="zip" value="{{old('zip')}}">
                            @if ($errors->has('zip'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('zip') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                    
                    <div class="row">  
                        <div class="col-md-6 form-group">                                 
                            <input type="text" class="form-control {{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="State" name="state" value="{{old('state')}}">
                            @if ($errors->has('state'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                              
                            <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{old('country')}}">
                                <option value="" selected="">Please Select Country</option>
                                <option value="India">India</option>
                                <option value="UK">UK</option>
                                <option value="USA">USA</option>                          
                            </select>
                            @if ($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    @if(empty($businesskyc->add_line_one))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative">
                                <label class="l-checkbox">
                                    <p>Make this your primary address</p>
                                    <input type="checkbox" name="addressvalue" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div> 
                    @endif
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="notclear btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Address">               
                    </div>            
                </form>
                <div class="alert alert-success addressmsg" style="display:none;">Address Updated Successfully.</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="edit-address-billing">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Address</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{URL('/business-account/'.$user_id)}}" class="common-form myform" id="EditBillingAddress" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 form-group required">
                            <input type="hidden" name="_method" value="PUT" />
                            <input type="hidden" name="addressvalue" value="2" />                            
                            <input type="text" class="form-control {{ $errors->has('addlone') ? ' is-invalid' : '' }}" placeholder="Address Line 1" name="addlone" value="{{ $business->billing_address_line_one }}">
                            @if ($errors->has('addlone'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addlone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                                
                            <input type="text" class="form-control" placeholder="Address Line 2"  name="addltwo" value="{{ $business->billing_address_line_two }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required">                              
                            <input type="text" class="form-control {{ $errors->has('towncity') ? ' is-invalid' : '' }}" placeholder="Town/ City"  name="towncity" value="{{ $business->billing_address_townOrcity }}">
                            @if ($errors->has('towncity'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('towncity') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                                 
                            <input type="text" class="form-control {{ $errors->has('zip') ? ' is-invalid' : '' }}" placeholder="Zipcode" name="zip" value="{{ $business->billing_address_zipcode }}">
                            @if ($errors->has('zip'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('zip') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                    
                    <div class="row">  
                        <div class="col-md-6 form-group">                                 
                            <input type="text" class="form-control {{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="State" name="state" value="{{ $business->billing_address_state }}">
                            @if ($errors->has('state'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                              
                            <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" name="country">
                                <option value="" {{ $business->billing_address_country == '' ? 'selected' : ''}}>Please Select Country</option>
                                <option value="India" {{ $business->billing_address_country == 'India' ? 'selected' : ''}}>India</option>
                                <option value="UK" {{$business->billing_address_country == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="USA" {{$business->billing_address_country == 'USA' ? 'selected' : '' }}>USA</option>                            
                            </select>
                            @if ($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                     
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Address">               
                    </div>             
                </form>
                <div class="alert alert-success addressmsg" style="display:none;">Address Updated Successfully.</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="edit-address-primary">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Address</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="edit-address-primary-form" action="{{URL('/business-account/')}}" class="common-form myform" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}                    
                    <div class="row">
                        <div class="col-md-6 form-group required">
                            <input type="hidden" name="primaryaddressvalue" value="3">
                            <input type="hidden" name="role" value="2">
                            <input type="text" class="form-control {{ $errors->has('AddressLineOne') ? ' is-invalid' : '' }}" placeholdprimaer="Address Line 1" name="AddressLineOne" value="{{ $businesskyc->add_line_one }}">
                            @if ($errors->has('AddressLineOne'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('AddressLineOne') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                                
                            <input type="text" class="form-control" placeholder="Address Line 2"  name="AddressLineTwo" value="{{ $businesskyc->add_line_two }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required">                              
                            <input type="text" class="form-control {{ $errors->has('TownOrCity') ? ' is-invalid' : '' }}" placeholder="Town/ City"  name="TownOrCity" value="{{ $businesskyc->town_or_city }}">
                            @if ($errors->has('TownOrCity'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('TownOrCity') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                                 
                            <input type="text" class="form-control {{ $errors->has('Zipcode') ? ' is-invalid' : '' }}" placeholder="Zipcode" name="Zipcode" value="{{ $businesskyc->zip }}">
                            @if ($errors->has('Zipcode'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('Zipcode') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                    
                    <div class="row">  
                        <div class="col-md-6 form-group">                                 
                            <input type="text" class="form-control {{ $errors->has('State') ? ' is-invalid' : '' }}" placeholder="State" name="State" value="{{ $businesskyc->state }}">
                            @if ($errors->has('State'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('State') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">                              
                            <select class="form-control {{ $errors->has('Country') ? ' is-invalid' : '' }}" name="Country">
                                <option value="" {{ $businesskyc->country == '' ? 'selected' : ''}}>Please Select Country</option>
                                <option value="India" {{ $businesskyc->country == 'India' ? 'selected' : ''}}>India</option>
                                <option value="UK" {{ $businesskyc->country == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="USA" {{ $businesskyc->country == 'USA' ? 'selected' : '' }}>USA</option>                          
                            </select>
                            @if ($errors->has('Country'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('Country') }}</strong>
                            </span>                            
                            @endif                                                            
                        </div>
                        <div class="col-md-12 form-group pb-120">
                        <label>Proof of address <span class="asterik">*</span></label>
                        <div class="fileinput fileinput-new" id="input_file_pos_rel" data-provides="fileinput">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input" data-trigger="fileinput">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
                                        </span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new">
                                            Select file </span>
                                        <span class="fileinput-exists">
                                            Change </span>
                                        <input type="file" name="approvalproofaddress" id="file-preview-show" multiple="multiple" type="file"/>
                                        
                                    </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                        Remove </a>
                                    <div id="image-holder">
                                        <input type="hidden" name="approvalproofaddressold" value="{{$businesskyc->address_proof}}"/>
                                           <img src="{{url('/public/images/')}}/{{decrypt($user_id)}}/{{$businesskyc->address_proof}}" />
                                </div>
                            </div>
                        </div>
<!--                        <div class="fileinput-show">
                            <img src="https://cashgw.website/public/images/2/2_PhotoFile.png" />
                            </div>-->
                    </div>                     
                    </div>                     
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="showloader btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Address">               
                    </div>                                   
                </form>                 
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="add-email-address">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Email Address</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{URL('/business-account')}}" class="common-form myform" method="POST" id="AddEmailAddress">                
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <input type="text" class="form-control {{ $errors->has('emailaddress') ? ' is-invalid' : '' }}" placeholder="Email Address" name="emailaddress" value="{{ old('emailaddress') }}">
                            
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('emailaddress') }}</strong>
                                </span>
                            
                        </div>                            
                    </div>    
                    @if(empty($business->primary_email))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative">
                                <label class="l-checkbox">
                                    <p>Make this your primary Email address</p>
                                    <input type="checkbox" value="1" name="emailaddressvalue">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>    
                    @endif
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="notclear btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Email">                 
                    </div>             
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="edit-email-address">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Edit Email Address</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{URL('/business-account/'.$user_id)}}" class="common-form myform" method="POST" id="EditEmailAddress">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <input type="hidden" name="_method" value="PUT" />
                            <input type="hidden" name="emailid" value="" />
                            <input type="text" class="form-control {{ $errors->has('emailaddress') ? ' is-invalid' : '' }}" placeholder="Edit Email Address" name="emailaddress" value="{{ old('emailaddress') }}">
                            
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('emailaddress') }}</strong>
                                </span>
                            
                        </div>                            
                    </div>    
                    @if(empty($business->primary_email))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative">
                                <label class="l-checkbox">
                                    <p>Make this your primary Email address</p>
                                    <input type="checkbox" value="1" name="emailaddressvalue">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>    
                    @endif
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Email">                 
                    </div>             
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="add-phone">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Phone Number</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{URL('/business-account/')}}" class="common-form myform" method="post" id="AddPhoneNumber">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <input type="text" class="form-control {{ $errors->has('phonenumber') ? ' is-invalid' : '' }}" placeholder="Add phone number" name="phonenumber" value="{{ old('phonenumber') }}">
                            
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phonenumber') }}</strong>
                                </span>
                            
                        </div>                            
                    </div>  
                    @if(empty($business->primary_phone))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="position-relative">
                                        <label class="l-checkbox">
                                            <p>Make this your primary Phone Number</p>
                                            <input type="checkbox" name="phonenumbervalue" value="1">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>  
                    @endif
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="notclear btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Number">
                    </div>             
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="edit-phone">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Edit Phone Number</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{URL('/business-account/'.$user_id)}}" class="common-form myform" method="POST" id="EditPhoneNumber">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <input type="hidden" name="_method" value="PUT" />
                            <input type="hidden" name="phoneid" value="" />
                            <input type="text" class="form-control {{ $errors->has('phonenumber') ? ' is-invalid' : '' }}" placeholder="Edit phone number" name="phonenumber" value="{{ old('phonenumber') }}">
                            
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phonenumber') }}</strong>
                                </span>
                            
                        </div>                            
                    </div>  
                        @if(empty($business->primary_phone))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="position-relative">
                                    <label class="l-checkbox">
                                        <p>Make this your primary Phone Number</p>
                                        <input type="checkbox" name="phonenumbervalue" value="1">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>  
                        @endif
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Number">
                    </div>             
                </form>
            </div>
        </div>
    </div>
</div>         
<div class="modal fade " id="close-your-account">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Close Your Account??</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div> 
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="position-relative">
                            <label class="l-checkbox">
                                <p>Are You Sure??</p>   
                                <p>You Want To Delete This Account.</p>    
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{URL('/business-account/'.$user_id)}}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="delete" />
                    <button type="submit" class="btn btn-success">Yes</button> 
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="uploadimageModal2" class="modal" role="dialog">
    <div class="modal-dialog ad_modal modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload & Crop Image</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 myacont-popup text-center">
                        <div class="image_demo" style="width:100%;overflow: hidden"></div>
                    </div>
                    <div class="col-md-12 myacont-popup text-center">
                        <button class="btn btn-custom waves-effect btn-rounded btn-success crop_image2" user_id="{{$user_id}}">Crop & Upload Image</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script src="{{url('/public/js/croppie.js')}}"></script>
<script>  
    $('.modal').on('hidden.bs.modal', function(e){
        var modalId = $(this).attr('id');
           if(modalId == "add-phone" && modalId == "add-email-address" && modalId == "add-address"){
               $(this)
                  .find("input,textarea,select")
                  .not('.notclear').val('')
                     .end()
                  .find('.invalid-feedback').removeClass('error').text('')
                     .end() 
                  .find("input[type=checkbox], input[type=radio]")
                     .prop("checked", "")
                     .end()
                  .find('.invalid-feedback').removeClass('error').text('')
                     .end(); 
            }
        });    
   $(document).on("change", ".upload_pro_image", function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).attr("img_id");        
        $(".crop_image2").attr("input_id", id);        
        var width = $(this).attr("img_width");
        var height = $(this).attr("img_height");
        var b_width = +width + 70;
        var b_height = +height + 70;        
        $image_crop = $('.image_demo').croppie({
            enableExif: true,
            viewport: {
                width: width,   
                height: height,
                type: 'square' //circle
            },
            boundary: {
                width: b_width,
                height: b_height
            }
        });

        var reader = new FileReader();
        reader.onload = function (event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function () {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal2').modal('show');


    });
    $('#uploadimageModal2').on('hidden.bs.modal', function () {
        $image_crop.croppie('destroy');       
    });
    $('.crop_image2').click(function (event) {          
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            $(".loader").show();
            $('#uploadimageModal2').modal('hide');
            response = window.btoa(response);
//            console.log(response);
            $.ajax({                
                url: '{{URL("/businessaddprofilepic")}}',
                type: "POST",
                data: {"myphoto": response},
                success: function (result)
                {
                    console.log(result);
                    var imageUrl = $.trim(result);
                    var src = BASE_URL + imageUrl;
                    $('#myImg').attr('src',src);
                    $(".loader").fadeOut(1000);
                    location.reload(true);
                }
            });
        });
    });
</script>
<script>
 $(document).on('click','.editPhone',function(){
    $('#EditPhoneNumber input[name=phoneid]').val($(this).attr('data-id'));
    $('#EditPhoneNumber input[name=phonenumber]').val($(this).attr('data-no'));    
 });  
 $(document).on('click','.editEmail',function(){
    $('#EditEmailAddress input[name=emailid]').val($(this).attr('data-id'));
    $('#EditEmailAddress input[name=emailaddress]').val($(this).attr('data-no'));    
 });
 $(document).on('change','#myphoto',function(){    
    $('#myphotohtml').html('<input type="submit" class="btn round-btn" value="Save">');
 });
$(document).ready(function(){
    jQuery.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
      }, "Letters only please"); 
      
//    $.validator.addMethod('filesize', function (value, element, param) {
//        return this.optional(element) || (element.files[0].size <= param)
//    }, 'File size must be less than {0}');  
      
    $('.myform').each(function(){
        $(this).validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            phonenumber: {
                required: true,
                phoneUS: true
            },
            emailaddress: {
                required: true,
                email: true
            },
            addlone:{
                required: true,
                maxlength: 100,
            },
            addltwo:{
                maxlength: 100,
            },
            towncity:{
                required: true,
                alpha:true,
            },
            zip:{
                required: true,
            },
            state:{
                required: true,
                alpha:true,
            },
            country:{
                required: true,
            },
            FirstName:{
                required: true,
                alpha:true,
            },
            MiddleName:{
//                required: true,
                alpha:true,
            },
            LastName:{
                required: true,
                alpha:true,
            },
            LangId:{
                required: true,                
            },
            Country:{
                required: true,                
            },
            myphoto:{
                required: true,
                extension:"jpg,png,jpeg,gif",
//                filesize: 50000,
            },
            approvalproofaddress:{
//                 required: true,
                 extension:"jpg,png,jpeg",
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        messages: {
            phonenumber: {
                required: "Phone Number Required",
                phoneUS: "Only 11 Digit Numbers",
            },
            emailaddress: {
                required: "Email Address Required",
                email: "Enter Valid Email Address",
            },
           addlone:{
                required: "Address Line One Required",
                maxlength: "Only 100 Character allowed",
            },
            addltwo:{
                maxlength: "Only 100 Character allowed",
            },
            towncity:{
                required: "Town/City Required",
                alpha:"Only Alphabet Allow",
            },
            zip:{
                required: "ZipCode Required",
            },
            state:{
                required: "State Required",
                alpha:"Only Alphabet Allow",
            },
            country:{
                required: "Country Required",
            },
            FirstName:{
                required: "First Name Required",
                alpha:"Only Alphabet Allow",
            },
            MiddleName:{
//                required: "Middle Name Required",
                alpha:"Only Alphabet Allow",
            },
            LastName:{
                required: "Last Name Required",
                alpha:"Only Alphabet Allow",
            },
            LangId:{
                required: "Language Required",        
            },
            Country:{
                required: "Country Required",   
            },
            myphoto:{
                required: "Image Required", 
                extension: "Only image type jpg/png/jpeg/gif is allowed",
//                filesize:"File size must be less than {0}",
            },
            approvalproofaddress:{
//                 required: 'Proof of address Required',
                 extension: "Only image type jpg/png/jpeg is allowed",
            }
        }
    });
    });
});
$(document).on('click','.showloader',function(){
        if ($('#edit-address-primary-form').valid()){
                $('.loader').show();
            }
    });
</script>
<script>
$(document).ready(function() {
        $("#file-preview-show").on('change', function() {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#image-holder");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "preview-thumb-image"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
//            alert("Pls select only images");
          }
        });
      });
</script>
<script>
$('#edit-address-primary , #edit-address-billing , #edit-email-address , #edit-phone , #close-your-account , #add-email-address , #add-phone, #add-address').on({'mousewheel': function(e) 
    {
    if (e.target.id == 'el') return;
    e.preventDefault();
    e.stopPropagation();
   }
});

</script>
@endsection