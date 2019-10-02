@extends('layouts.admin')
@section('content')
<style>
    .btn-signin{text-transform: capitalize;letter-spacing: 0px;}
    #add-cate{position: static !important;}
</style>
<div class="slim-mainpanel">
    <div class="container-fluid">
        <div class="slim-pageheader">            
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL('/admin')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{URL('/manage-accounts')}}">Manage Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Details</li>
            </ol>
            <h6 class="slim-pagetitle">User Details</h6>
        </div>
        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-lg-12 view-user-detail">
                        @if($data->role == 2)
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Business Name: </label>
                            <strong>{{decrypt($data->business_name)}}</strong>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Type: </label>
                            <strong>{{decrypt($data->business_type)}}</strong>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Certificate: </label>
                            <a href="#certificate" class="modal-effect" data-toggle="modal" data-effect="effect-scale">{{__('Certificate')}}</a>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Memorandum: </label>
                            <a  href="#memorandum" class="modal-effect" data-toggle="modal" data-effect="effect-scale">{{__('Memorandum')}}</a>
	                </div>
                        @endif
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">First Name: </label>
                            <strong>{{decrypt($data->fname)}}</strong>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Middal Name: </label>
                            <strong>{{decrypt($data->mname)}}</strong>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Last Name: </label>
                            <strong>{{decrypt($data->lname)}}</strong>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Date of Birth: </label>
                            <strong>{{decrypt($data->dob)}}</strong>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Passport Number: </label>
                            <strong>{{decrypt($data->passport_no)}}</strong>
	                </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Passport Expiry Date: </label>
                            <strong>{{decrypt($data->passport_expdate)}}</strong>
	                </div>                        
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bank" class="col-form-label">Passport: </label>
                            <a href="#passport-img" class="modal-effect" data-toggle="modal" data-effect="effect-scale">{{__('Passport')}}</a>
	                </div>
                    
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="branch" class="col-form-label">Address Line 1: </label>
                            <strong>{{decrypt($data->add_line_one)}}</strong>
                        </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bankcode" class="col-form-label">Address Line 2: </label>                            
                            <strong>{{decrypt($data->add_line_two)}}</strong>
                        </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="ifsccode" class="col-form-label">Town/ City: </label>                            
                            <strong>{{decrypt($data->town_or_city)}}</strong>
                        </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="currency" class="col-form-label">Zipcode: </label>                               
                            <strong>{{decrypt($data->zip)}}</strong>
                        </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="acno" class="col-form-label">State.: </label>         
                            <strong>{{decrypt($data->state)}}</strong>
                        </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="name" class="col-form-label">Country: </label>       
                            <strong>{{decrypt($data->country)}}</strong>
                        </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="name" class="col-form-label">Currency: </label>       
                            <strong>{{decrypt($data->currency)}}</strong>
                        </div>
                        <div class="form-group col-sm-4 col-lg-4">
                            <label for="bankaddress" class="col-form-label">Proof of address: </label>	                    
                            <a href="#address-img" class="modal-effect" data-toggle="modal" data-effect="effect-scale">{{__('Address Proof')}}</a>
	                </div>
                         <div class="form-group col-sm-4 col-lg-4">
                            <label for="bankaddress" class="col-form-label">Photo: </label>	                    
                            <a href="#profile-img" class="modal-effect" data-toggle="modal" data-effect="effect-scale">{{__('Profile Image')}}</a>
	                </div>
                </div>
            </div>
        </div>
    </div>
</div>


 <!-- MODAL Certificate -->
 @if(isset($data->business_certificate))
    <div id="certificate" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Certificate</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-25">
          <img src="{{URL('public/images/'.$data->id.'/'.decrypt($data->business_certificate))}}"/>
          </div>
<!--          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>-->
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif
    @if(isset($data->business_memorandum))
 <!-- MODAL memorandum -->
    <div id="memorandum" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Memorandum</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-25">
          <img src="{{URL('public/images/'.$data->id.'/'.decrypt($data->business_memorandum))}}"/>
          </div>
<!--          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>-->
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif
 <!-- MODAL passport-img -->
 @if(isset($data->passport))
    <div id="passport-img" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Passport</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-25">
            <img src="{{URL('public/images/'.$data->id.'/'.decrypt($data->passport))}}"/>
          </div>
<!--          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>-->
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif
 <!-- MODAL address-img -->
 @if(isset($data->address_proof))
    <div id="address-img" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">address proof</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-25">
          <img src="{{URL('public/images/'.$data->id.'/'.$data->address_proof)}}"/>
          </div>
<!--          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>-->
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif
    @if(decrypt($data->photo) !== '')
 <!-- MODAL profile-img -->
    <div id="profile-img" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Photo</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-25">
              <img src="{{URL('public/images/'.$data->id.'/'.decrypt($data->photo))}}"/>
          </div>
<!--          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>-->
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif
@endsection
