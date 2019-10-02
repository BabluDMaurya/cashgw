@extends('layouts.businessdashboard')
@section('content')
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                @include('includes.business-invoice-menu')
                <div class="tab-content py-3 px-3 px-sm-0 container " id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space">
                                            <div class="col-md-12">
                                                <h5 class="block-title">Business information settings</h5> 
                                                @if(session('status'))                                                
                                                <div class="alert alert-success alert-dismissible" id="msg" style="margin-left: 540px;width: 50%;position: absolute;top: -13px;"> 
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{ session('status') }}
                                                </div>
                                                @endif
                                                
<!--                                                @if(!empty($selected_id_value->id)){
                                                <p class="red-text text-right deleteBusiInfo" id="{{encrypt($selected_id_value->id)}}">Delete</p>
                                                @endif-->
                                            </div>                                              
                                        </div>
                                        <div class="col-md-12 extra-info">
                                            <p>This business information will be displayed at the top of your invoices. You can choose to display a different set of business information on each invoice template.</p>
                                        </div>
                                    </div>                          
                                    <form class="common-form" id="addEditBusinessInfo" action="" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}                                        
                                        <input type="hidden" id="editid" name="id" value=""> 
                                        <input type="hidden" id="type" name="_method" value="">
                                        @if(!empty($selected_id_value->user_id))
                                        <input type="hidden" id="user_id" value="{{encrypt($selected_id_value->user_id)}}">
                                        @endif
                                        <div class="row data-section">
                                            <div class="col-md-6 no-flex">
                                                <div class="fileinput fileinput-exists" data-provides="fileinput">                                                    
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">                                                       
                                                        <!--<img src="" style="max-height: 90px;" id="business_logo">-->                                                        
                                                        <img src="" id="business_logo">                                                        
                                                    </div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new">
                                                                Select image </span>
                                                            <span class="fileinput-exists">
                                                                Change </span>
                                                            <input type="hidden">
                                                            <input type="file" name="business_logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                            Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group required no-flex">
                                                <label>Category</label>                                                
                                                <select class="form-control {{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id" id="category_id">
                                                    @foreach($allCategory as $categories)                                                                                              
                                                    <option value="{{$categories->id}}" 
                                                        @foreach($selected_id_value as $selectedvalue)
                                                            @if($categories->id == $selectedvalue->category_id)
                                                                {{__('selected')}} 
                                                    @else                                                
                                                                {{__('')}} 
                                                            @endif 
                                                    @endforeach
                                                             >
                                                            {{$categories->category_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category_id'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                            <div class="col-md-6 form-group required no-flex">
                                                <label>Business name</label>
                                                <input type="text" id="business_name" class="form-control {{ $errors->has('business_name') ? ' is-invalid' : '' }}" value="" name="business_name">
                                                @if($errors->has('business_name'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('business_name') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group required no-flex">
                                                <label>First name</label>
                                                <input type="text" id="first_name" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="" name="first_name">
                                                @if($errors->has('first_name'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span> 
                                                @endif
                                            </div> 
                                            <div class="col-md-6 form-group no-flex">
                                                <label>Last Name</label>
                                                <input type="text" id="last_name" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="" name="last_name">
                                                @if($errors->has('last_name'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label>Address</label>
                                                <!--<input type="text" id="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="" name="address">-->
                                                 <textarea id="address" name="address" class="form-control" {{ $errors->has('address') ? ' is-invalid' : '' }}></textarea>
                                                @if($errors->has('address'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span> 
                                                @endif
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group required no-flex">
                                                <label>Phone</label>
                                                <input type="text" id="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" value="" name="phone">
                                                @if($errors->has('phone'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                            <div class="col-md-6 form-group no-flex">
                                                <label>Fax</label>
                                                <input type="text" id="fax" class="form-control" value="" name="fax">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group required no-flex">
                                                <label>Email Address</label>
                                                <input type="text" id="email_id" class="form-control {{ $errors->has('email_id') ? ' is-invalid' : '' }}" value="" name="email_id">
                                                @if($errors->has('email_id'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('email_id') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                            <div class="col-md-6 form-group no-flex">
                                                <label>Website</label>
                                                <input type="text" id="website" class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }}" value="" name="website">
                                                @if($errors->has('website'))                                                
                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                    <strong>{{ $errors->first('website') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group required no-flex no-flex">
                                                <label>Tax ID</label>
                                                <input type="text" id="tax_id" class="form-control" value="" name="tax_id">
                                            </div>
                                            <div class="col-md-6 form-group no-flex">
                                                <label>Additional Information</label>
                                                <input type="text" id="additional_info" class="form-control" value="" name="additional_info">
                                            </div>
                                        </div>                                        
                                        <div class="">
                                            <div class="">
                                                <!--<input type="submit" class="btn round-btn  hvr-sweep-to-top  blue-btn" value="Save">-->
                                                <button id="submitBtnBusiness" value="Save" class="btn round-btn  hvr-sweep-to-top  blue-btn ml-0">Save</button>
                                                <!--<a href="#!" id="savebusiinfo" class="btn round-btn  hvr-sweep-to-top  blue-btn" data-dismiss="modal">Save</a>-->
                                            </div>
                                        </div>   
                                    </form>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</section>  
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script>
    window.FontAwesomeConfig = {
        searchPseudoElements: true
    }

    $(document).ready(function () {
        $.validator.addMethod("alpha", function (value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
        });
        $.validator.addMethod("businessname", function (value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z-_ \s]+$/);
        });
        $.validator.addMethod("customEmail", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
        }, "Please enter valid email address!");

        $.validator.addMethod("phoneUS", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
        }, "Please specify a valid phone number");

        $(document).on('click', '#submitBtnBusiness', function (e) {
            e.preventDefault();
            var edit_id = $('#editid').val();
            var user_id = $('#user_id').val();
            if (edit_id == "") {
                $("#addEditBusinessInfo").attr('action', BASE_URL + "/" + 'business-information-details');
            } else {
                $("#addEditBusinessInfo").attr('action', BASE_URL + "/" + 'business-information-details' + "/" + user_id);
                $("#type").val('PUT');
            }
            if ($('#addEditBusinessInfo').valid()){
                $('.loader').show();
            } else {           
                e.preventDefault();
                $('.loader').hide();
            }
            $("#addEditBusinessInfo").submit();

        });

        $("#addEditBusinessInfo").validate({
            errorElement: 'span',
            errorClass: 'invalid-feedback',

            rules: {
                category_id: {
                    required: true
                },
                business_logo: {
//                    required: true
                      extension: true,
                },
                business_name: {
                    required: true,
                    businessname: true
                },
                first_name: {
                    required: true,
                    alpha: true
                },
                last_name: {
                    required: true,
                    alpha: true
                },
                address: {
                    required: true,
                    maxlength:150,
                },
                phone: {
                    required: true,
                    phoneUS: true
                },
                email_id: {
                    required: true,
                    customEmail: true
                },
                website: {
                    required: true,
                },
                tax_id: {
                    required: true,
                    number: true
                },
                additional_info:{
                    maxlength:150,
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
                category_id: {
                    required: "Category Required",
                },
                business_logo: {
//                    required: "Logo Required",
                      extension:"jpg,png,jpeg Allowed",
                },
                business_name: {
                    required: "Business Name Required",
                    businessname: "Only charector, number, space and dash allowed.",
                },
                first_name: {
                    required: "First Name Required",
                    alpha: "Only Alphabets allow",
                },
                last_name: {
                    required: "Last Name Required",
                    alpha: "Only Alphabets allow",
                },
                address: {
                    required: "Address Required",
                    maxlength:"Maximum 150 character allowed",
                },
                email_id: {
                    required: "Email Address Required",
                    customEmail: "Please enter Valid Email",
                },
                phone: {
                    required: "Phone Number Required",
                    phoneUS: "Only 10 Digit Numbers",
                },
                website: {
                    required: "Website Address Required",
                },
                tax_id: {
                    required: "Tax Id Required",
                    number: "Please enter numbers Only",
                },
                additional_info:{
                    maxlength:"Maximum 150 character allowed",
                }
            },
        });


        getajaxcatdata();

        $(document).on('change', '#category_id', function () {
            getajaxcatdata();
        });

        function getajaxcatdata() {
            var selected_id = $('#category_id').val();   
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: '/businessGetSingleBusinessInfo',
                type: "POST",
                data: {"selected_id": selected_id},
                success: function (result)
                {
                    //console.log(result);
                    obj = JSON.parse(result);
                    if(obj.business_logo == ''){                        
                        var src = IMAGE_URL + 'logo.png';
                    }else if (obj.business_logo != undefined) {
                        var src = IMAGE_URL + obj.user_id + "/" + obj.business_logo;
                    } else{
                        var src = IMAGE_URL + 'logo.png';
                    }
                    $('#business_logo').attr('src', src);
                    $('#editid').val(obj.id);
                    $('#business_name').val(obj.business_name);
                    $('#first_name').val(obj.first_name);
                    $('#last_name').val(obj.last_name);
                    $('#address').val(obj.address);
                    $('#phone').val(obj.phone);
                    $('#fax').val(obj.fax);
                    $('#email_id').val(obj.email_id);
                    $('#website').val(obj.website);
                    $('#tax_id').val(obj.tax_id);
                    $('#additional_info').val(obj.additional_info);
                }
            });
        }

    });
    
    $(document).ready(function () {
        $("#website").change(function() {
            if (!/^https*:\/\//.test(this.value)) {
                this.value = "http://" + this.value;
            }
        });
    });
</script>

@endsection
