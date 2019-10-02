@extends('layouts.businessdashboard')
@section('content')
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                <nav>
                    <div class="container pd0">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" href="{{URL('/business-account/'.$user_id)}}">Account</a>
                            <a class="nav-item nav-link active" href="{{URL('/business-security/'.$user_id)}}">Security</a>
                        </div>
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">                   
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row-item">
                                          
                                        <h4>Change Password</h4>
                                         @if (session('status'))
                                                <div class="alert alert-success alert-dismissible"> 
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            <form class="common-form myform" id="passwordchange" method="POST" action="{{URL('/business-security/'.$user_id)}}">                
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <input type="hidden" name="_method" value="PUT" />
                                                <div class="col-md-12 form-group">                             
                                                    <input type="password" class="form-control {{ $errors->has('currentpassword') ? ' is-invalid' : '' }}" name="currentpassword" placeholder="Confirm your current password" autocomplete="OFF"> 
                                                @if($errors->has('currentpassword'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('currentpassword') }}</strong>
                                                    </span> 
                                                @endif
                                                </div>
                                                <div class="col-md-12 form-group">                             
                                                    <input type="password" id="newpassword" class="form-control {{ $errors->has('newpassword') ? ' is-invalid' : '' }}" name="newpassword" placeholder="Enter your new password" autocomplete="OFF">
                                                @if($errors->has('newpassword'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('newpassword') }}</strong>
                                                    </span> 
                                                @endif                        
                                                </div>
                                                <div class="col-md-12 form-group">                             
                                                    <input type="password" class="form-control {{ $errors->has('confirmpass') ? ' is-invalid' : '' }}" name="confirmpass" placeholder="Confirm new password" autocomplete="OFF">                       
                                                    @if($errors->has('confirmpass'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('confirmpass') }}</strong>
                                                    </span> 
                                                @endif 
                                                </div>
                                            </div>  
                                            <div class="col-lg-10 margin-auto">
                                                <button type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20">Change Password</button>                        
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
    </div>	
</section>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script>    
$(document).ready(function(){    
$.validator.addMethod("Regex", function(value, element) {
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes.");
$('#passwordchange').validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            currentpassword: {
                required: true,                
            },
            newpassword: {
                required: true,               
                Regex: true,               
            },
            confirmpass:{
                equalTo: "#newpassword"
            },
            
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        messages: {
            currentpassword: {
                required: "Current Password Required",                
            },
            newpassword: {
                required: "New Password Required",  
                Regex:"Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character",  
            },
            confirmpass:{
                required: "Address Line One Required",
            },
            
        }
    });
});   
</script>
@endsection