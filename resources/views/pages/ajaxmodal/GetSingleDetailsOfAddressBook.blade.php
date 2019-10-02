@if(!empty($singleDetails))
<div class="d-flex top-text ">
    <p>{{$singleDetails->email}}</p>
    <p class="red-text" id="{{$singleDetails->id}}">Delete Contact</p>
</div>
<div class="accordion" id="accordion{{$singleDetails->id}}">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a id="{{$singleDetails->id}}" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$singleDetails->id}}" href="#collapse{{$singleDetails->id}}">
                Edit
            </a>
        </div>
        <div id="collapse{{$singleDetails->id}}" class="accordion-body collapse">
            <div class="accordion-inner">
                <form class="common-form" action="{{ url('address-book/'.encrypt($singleDetails->user_id)) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="id" value="{{encrypt($singleDetails->id)}}">
                    <div class="row">
                        <div class="col-md-6 form-group required no-flex">
                            <label>Recipients email address</label>
                            <input type="text" class="form-control" name="email" value="{{$singleDetails->email}}">
                        </div>
                        <div class="col-md-6 form-group no-flex">
                            <label>Business Name</label>
                            <input type="text" class="form-control" id="business_name" name="business_name" value="{{$singleDetails->business_name}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required no-flex">
                            <label>First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" value="{{$singleDetails->fname}}">
                        </div> 
                        <div class="col-md-6 form-group no-flex">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" value="{{$singleDetails->lname}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required no-flex">
                            <label>Country</label>
                            <select class="form-control" name="country">
                                <option value="" selected="">Please Select Country</option>
                                <option value="India" {{ $singleDetails->country == 'India' ? 'selected' : ''}}>India</option>
                                <option value="UK" {{ $singleDetails->country == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="USA" {{ $singleDetails->country == 'USA' ? 'selected' : '' }}>USA</option>                                                                              
                            </select>
                        </div>
                        <div class="col-md-6 form-group no-flex">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{$singleDetails->phone}}">
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12 form-group no-flex">
                            <label>Additional information</label>
                            <input type="text" class="form-control" name="additional_information" value="{{$singleDetails->additional_information}}">
                        </div>
                    </div>                    
                    <div class="accordion" id="accordion{{$singleDetails->id}}">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$singleDetails->id}}" href="#billing{{$singleDetails->id}}">
                                    Billing address
                                </a>
                            </div>
                            <div id="billing{{$singleDetails->id}}" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <div class="row">
                                        <div class="col-md-6 form-group required no-flex">
                                            <label>Country</label>
                                            <select class="form-control" name="billing_add_country" id="billing_add_country">
                                                <option value="" selected="">Please Select Country</option>
                                                <option value="India" {{ $singleDetails->billing_add_country == 'India' ? 'selected' : ''}}>India</option>
                                                <option value="UK" {{ $singleDetails->billing_add_country == 'UK' ? 'selected' : '' }}>UK</option>
                                                <option value="USA" {{ $singleDetails->billing_add_country == 'USA' ? 'selected' : '' }}>USA</option>                                                                              
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group no-flex">
                                            <label>Address line 1</label>
                                            <input type="text" class="form-control" id="billing_address_line_one" name="billing_address_line_one" value="{{$singleDetails->billing_address_line_one}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group required no-flex">
                                            <label>Address line 2</label>
                                            <input type="text" class="form-control" id="billing_address_line_two" name="billing_address_line_two" value="{{$singleDetails->billing_address_line_two}}">
                                        </div> 
                                        <div class="col-md-6 form-group no-flex">
                                            <label>Town / City</label>
                                            <input type="text" class="form-control" id="billing_address_town_city" name="billing_address_town_city" value="{{$singleDetails->billing_address_town_city}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group required no-flex">
                                            <label>State</label>                                            
                                            <select class="form-control" id="billing_address_state" name="billing_address_state">
                                                <option value="" selected="">Please Select State</option>                                                
                                                <option value="Maharashtra" {{ $singleDetails->billing_address_state == 'India' ? 'selected' : ''}}>Maharashtra</option>
                                                <option value="Goa" {{ $singleDetails->billing_address_state == 'UK' ? 'selected' : '' }}>Goa</option>
                                                <option value="Rajasthan" {{ $singleDetails->billing_address_state == 'USA' ? 'selected' : '' }}>Rajasthan</option> 
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group no-flex">
                                            <label>Pincode</label>
                                            <input type="text" class="form-control" id="billing_address_zipcode" name="billing_address_zipcode" value="{{$singleDetails->billing_address_zipcode}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$singleDetails->id}}" href="#shipping{{$singleDetails->id}}">
                                    Shipping address
                                </a>
                            </div>
                            <div id="shipping{{$singleDetails->id}}" class="accordion-body collapse">
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
                                            <input type="text" class="form-control" name="shipping_address_fname" id="shipping_address_fname" value="{{$singleDetails->shipping_address_fname}}">
                                        </div> 
                                        <div class="col-md-6 form-group no-flex">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" name="shipping_address_lname" id="shipping_address_lname" value="{{$singleDetails->shipping_address_lname}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group required no-flex">
                                            <label>Business Name</label>
                                            <input type="text" class="form-control" name="shipping_address_business_name" id="shipping_address_business_name" value="{{$singleDetails->shipping_address_business_name}}">
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group required no-flex">
                                            <label>Country</label>
                                            <select class="form-control" id="shipping_address_country" name="shipping_address_country">
                                                <option value="" selected="">Please Select Country</option>
                                                <option value="India" {{ $singleDetails->billing_add_country == 'India' ? 'selected' : ''}}>India</option>
                                                <option value="UK" {{ $singleDetails->billing_add_country == 'UK' ? 'selected' : '' }}>UK</option>
                                                <option value="USA" {{ $singleDetails->billing_add_country == 'USA' ? 'selected' : '' }}>USA</option>      
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group no-flex">
                                            <label>Address line 1</label>
                                            <input type="text" class="form-control" name="shipping_address_line_one" id="shipping_address_line_one" value="{{$singleDetails->shipping_address_line_one}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group required no-flex">
                                            <label>Address line 2</label>
                                            <input type="text" class="form-control" name="shipping_address_line_two" id="shipping_address_line_two" value="{{$singleDetails->shipping_address_line_two}}">
                                        </div> 
                                        <div class="col-md-6 form-group no-flex">
                                            <label>Town / City</label>
                                            <input type="text" class="form-control" name="shipping_address_town_city" id="shipping_address_town_city" value="{{$singleDetails->shipping_address_town_city}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group required no-flex">
                                            <label>State</label>
                                            <select class="form-control" id="shipping_address_state" name="shipping_address_state">
                                                <option value="" selected="">Please Select State</option>
                                                <option value="Maharashtra" {{ $singleDetails->shipping_address_state == 'India' ? 'selected' : ''}}>Maharashtra</option>
                                                <option value="Goa" {{ $singleDetails->shipping_address_state == 'UK' ? 'selected' : '' }}>Goa</option>
                                                <option value="Rajasthan" {{ $singleDetails->shipping_address_state == 'USA' ? 'selected' : '' }}>Rajasthan</option>  
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group no-flex">
                                            <label>Pincode</label>
                                            <input type="text" class="form-control" name="shipping_address_zipcode" id="shipping_address_zipcode" value="{{$singleDetails->shipping_address_zipcode}}">
                                        </div>
                                    </div>                                                                                        
                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$singleDetails->id}}" href="#customer-memo{{$singleDetails->id}}">
                                    Customer Memo
                                </a>
                            </div>
                            <div id="customer-memo{{$singleDetails->id}}" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <div class="row">
                                        <div class="col-md-12 form-group required no-flex">
                                            <!--  <label>Country</label> -->
                                            <textarea class="form-control" placeholder="Add memo to self (your recipient won't see this)" rows="5" name="customer_memo">{{$singleDetails->customer_memo}}</textarea>
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
                                <a href="#!" class="btn light-grey-btn round-btn hvr-sweep-to-top " data-dismiss="modal">Cancel</a>                                
                                <input type="submit" class="btn round-btn  hvr-sweep-to-top  blue-btn" value="Save">
                            </div>
                        </div>
                    </div>   
                </form>
            </div>
        </div>
    </div>                                                        
</div>
@endif
<script>
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
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
                
            }
            else if($(this).prop("checked") == false){
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
