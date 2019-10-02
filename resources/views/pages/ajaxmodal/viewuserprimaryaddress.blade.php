<div class="row">
    <div class="col-md-6 form-group required">            
        <input type="text" class="form-control" name="AddressLineOne" value="{{ decrypt($ViewUserAddressDetails[0]->add_line_one) }}">            
    </div>
    <div class="col-md-6 form-group">                                
        <input type="text" class="form-control" name="AddressLineTwo" value="{{ decrypt($ViewUserAddressDetails[0]->add_line_two) }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group required">                              
        <input type="text" class="form-control" name="TownOrCity" value="{{ decrypt($ViewUserAddressDetails[0]->town_or_city) }}">
    </div>
    <div class="col-md-6 form-group">                                 
        <input type="text" class="form-control" name="Zipcode" value="{{ decrypt($ViewUserAddressDetails[0]->zip) }}">
    </div>
</div>
<div class="row"> 
    <div class="col-md-6 form-group">                                 
        <input type="text" class="form-control" name="State" value="{{ decrypt($ViewUserAddressDetails[0]->state) }}">
    </div>
    <div class="col-md-6 form-group">                              
        <input type="text" class="form-control" name="country" value="{{ decrypt($ViewUserAddressDetails[0]->country) }}">
    </div>
</div>  
<div class="row"> 
    <div class="col-md-6 form-group">
        <a href="{{url('/public/images/')}}/{{ $ViewUserAddressDetails[0]->user_id }}/{{decrypt($ViewUserAddressDetails[0]->address_proof)}}" target="_blank"><img src="{{url('/public/images/')}}/{{ $ViewUserAddressDetails[0]->user_id }}/{{decrypt($ViewUserAddressDetails[0]->address_proof)}}" width="450px" height="320px"></a>
    </div>
</div>  