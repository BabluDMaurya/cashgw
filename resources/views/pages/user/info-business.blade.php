@extends('layouts.withoutheaderfooter')
@section('content')
<link rel="stylesheet" href="{{url('/public/css/jquery.steps.css')}}">
<link rel="stylesheet" href="{{url('/public/js/bootstrap-fileinput/bootstrap-fileinput.css')}}">
<section class="sec-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 ">
                <h2 class="title-pg text-center">Tell us about yourself</h2>
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible"> 
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible"> 
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('warning') }}
                    </div>
                @endif
                <form id="kyc-form" class="business" name="kycfirst" action="/businesskyc" method="post">                    
                    <div id="wizard" class="business wizard clearfix" role="application">
                        {{ csrf_field() }}
                <h2>Business Details</h2>        
                <section>
                <div class="row">
                            <div class="col-md-6 form-group required">
                                <label>Business Name <span class="asterik">*</span></label>
                                <input type="text" name="bname" class="form-control" value="{{old('bname')}}"> 
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Business Type</label>
                                 <input type="text" name="btype" class="form-control" value="{{old('btype')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                                <label>Business Certificate <span class="asterik">*</span></label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
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
                                            <input type="file" name="bcirtificate"> 
                                        </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                            Remove </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Memorandum <span class="asterik">*</span></label>
                                 <input type="text" name="memorandum" class="form-control" value="{{old('memorandum')}}">
                            </div>
                        </div>
                        </section>        
                <h2> Representative Details</h2>
                <section>                    
                        <div class="row">
                            <div class="col-md-6 form-group required">
                                <label>First Name <span class="asterik">*</span></label>
                                <input type="text" name="fname" class="form-control" value="{{old('fname')}}">                                
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Middle Name</label>
                                <input type="text" name="mname" class="form-control" value="{{old('mname')}}">                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                               <label>Last Name <span class="asterik">*</span></label>
                               <input type="text" name="lname" class="form-control" value="{{old('lname')}}">
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Date of Birth <span class="asterik">*</span></label>
                                 <input type="text" name="dob" class="form-control" value="{{old('dob')}}" placeholder="DD/MM/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                               <label>Passport Number <span class="asterik">*</span></label>
                               <input type="text" name="passno" class="form-control"  value="{{old('passno')}}">
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Passport Country  <span class="asterik">*</span></label>
                                 <select class="form-control" name="passcountry">
                                     <option>India</option>
                                     <option>UK</option>
                                     <option>USA</option>
                                 </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                               <label>Passport Expiry Date <span class="asterik">*</span></label>
                               <input type="text" name="passexpdt" class="form-control"  value="{{old('passexpdt')}}" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Upload Passport  <span class="asterik">*</span></label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="input-group input-large">
                                        <div class="form-control uneditable-input" data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">{{old('passfile')}}
                                            </span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                            <span class="fileinput-new">
                                                Select file </span>
                                            <span class="fileinput-exists">
                                                Change </span>
                                            <input type="file" name="passfile">
                                        </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                            Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                </section>

                <h2> Representative Address</h2>
                <section>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                                <label>Address Line 1  <span class="asterik">*</span></label>
                                <input type="text" name="addlone" class="form-control"  placeholder="">
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Address Line 2</label>
                                 <input type="text" name="addltwo" class="form-control"  placeholder="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                                <label>Town/ City <span class="asterik">*</span></label>
                                <input type="text" name="towncity" class="form-control"  placeholder="">
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Zipcode</label>
                                 <input type="text" name="zip" class="form-control"  placeholder="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                                <label>State  <span class="asterik">*</span></label>
                                <input type="text" name="state" class="form-control"  placeholder="">
                            </div>
                            <div class="col-md-6 form-group">
                                 <label>Country</label>
                                 <select class="form-control" id="exampleFormControlSelect1" name="country">
                                     <option>India</option>
                                     <option>UK</option>
                                     <option>USA</option>
                                 </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group required">
                                <label>Proof of address <span class="asterik">*</span></label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
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
                                            <input type="file" name="proofaddress">
                                        </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                            Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <h2>Verification</h2>
                <section>                        
                    <h3 class="num-pass">P45454841</h3>
                    <div class="alert alert-success alert-dismissible" style="display:none">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class="contactmess"></span>
                    </div>
                    <div class="col-md-6 form-group required margin-auto">
                                <label>Upload Photo<span class="asterik">*</span></label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
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
                                            <input type="file" name="uploadphoto">
                                        </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                            Remove </a>
                                    </div>
                                            
                                </div>
                                <span class="error uploadphoto-error"></span>
                            </div>                    
                        <p class="text-center btm-line">(upload your photo holding passport + a sign with written the name of the site and the customer number)</p>                      
                </section>               
                </div> 
                </form>    
            </div>
        </div>
    </div>
    <div id="result"></div>
</section>
<script type="text/javascript" src="{{url('/public/js/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{url('/public/js/jquery.steps.js')}}"></script>
<script>
                $(function ()
                {   
                    $.validator.addMethod("alpha", function(value, element) {
                        return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
                     });
                     $.validator.addMethod("alphanumeric", function(value, element) {
                        return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s]+$/);
                     });
                     jQuery.validator.addMethod("zipcode", function(value, element) {
                        return this.optional(element) || /^\d{5}(?:-\d{4})?$/.test(value);
                      }, "Please provide a valid zipcode.");
                    $.validator.addMethod("passportno", function(value, element) {
//                        return this.optional(element) || value == value.match(/^(?!^0+$)[a-zA-Z0-9]{3,20}$/);
                          return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s]+$/);
                     }); 
                     $.validator.addMethod("aDate",function(value, element) {
                            return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
                        },"Please enter a date in the format!");
                        
                        
                        $.validator.addMethod("aDate",function(value, element) {
                            return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
                        },"Please enter a date in the format!");
                        
                        $.validator.addMethod("birth", function (value, element) {
                        var year = value.split('/');
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1; //January is 0!
                        var yyyy = today.getFullYear();                        
                        
                        if ( value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) < yyyy ){
                            return true;
                        }else if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) == yyyy){
                            if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) < mm ){
                                return true;
                            }else if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) == mm ){
                                if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[0]) <= dd ){
                                    return true;
                                }else{
                                      return false;     
                                }
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    });  
                    
                    $.validator.addMethod("passportdate", function (value, element) {
                        var year = value.split('/');
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1; //January is 0!
                        var yyyy = today.getFullYear();                        
                        
                        if ( value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) > yyyy ){
                            return true;
                        }else if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) == yyyy){
                            if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) > mm ){
                                return true;
                            }else if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) == mm ){
                                if(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[0]) >= dd ){
                                    return true;
                                }else{
                                      return false;     
                                }
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    });
                        
                var form = $("#kyc-form");
                form.validate({
                    errorPlacement: function errorPlacement(error, element) { element.before(error); },
                    rules: {
                        // Business Details
                        bname:{
                          required:true,
                            alpha : true  
                        },
                        btype:{
                          required:true,
                            alpha : true  
                        },
                        bcirtificate:{
                          required:true,
                            accept : true  
                        },
                        memorandum:{
                          required:true,
                            alpha : true  
                        },
                        // Representative Details
                        fname:{
                            required:true,
                            alpha : true
                        },
                        'mname':"alpha",
                        lname:{
                            required:true,
                            alpha : true
                        },
                        passno:{
                            required:true,
                            rangelength:[3,10],
                            passportno:true,                            
                        },
                        dob:{
                            required:true,
                            aDate: true,
                            birth:true,
                        }, 
                        'passcountry':"required",
                        passfile:{
                            required:true,
                            accept:"jpg,png,jpeg,gif",
                        },
                        passexpdt:{
                            required:true,
                            aDate: true,
                            passportdate:true,
                        },
                        //Representative Address
                        'addlone':"required",
                        towncity:{
                            required:true,
                            alpha:true,
                        },
                        state:{
                            required:true,
                            alpha:true,        
                        },
                        zip:{
                            required:true,
                            zipcode:true,
                        },
                        proofaddress:{
                            required:true,
                            accept:"jpg,png,jpeg,gif",
                        },
                        
                        //Verification
                        uploadphoto:{
                            required:true,
                            accept:"jpg,png,jpeg,gif",
                        },
                    },
                    messages:{
                        // Business Details
                        bname:{
                          required:"Bisiness Name Required",
                            alpha:"Only Alphabate allow",
                        },
                        btype:{
                          required:"Business Type Required",
                            alpha:"Only Alphabate allow",
                        },
                        bcirtificate:{
                          required:"Business Certificate Required",
                            accept: "Only image type jpg/png/jpeg/gif is allowed",  
                        },
                        memorandum:{
                          required:"Memorandum Required",
                            alpha:"Only Alphabate allow", 
                        },
                        // Representative Details
                        fname:{
                            required:"First Name Required",
                            alpha:"Only Alphabate allow",
                        },
                        'mname':"Only Alphabate allow",
                        lname:{
                            required:"Last Name Required",
                            alpha:"Only Alphabate allow",
                        },
                        passno:{
                            required:"Passport Number Required",
                            rangelength: "Length should be in between 3 to 10.",
                            passportno:"Only Alpha numeric charecter allow.",
                            
                        },
                        
                        dob:{
                            required:"Date of Birth Required",
                            aDate: "Please enter a valid date (DD/MM/YYYY)",
                            birth:"Date of birth smaller then current date",
                        }, 
                        'passcountry':"Passport Country Required",
                        passfile:{
                            required:"Passport File Required",
                            accept: "Only image type jpg/png/jpeg/gif is allowed",
                        },
                        passexpdt:{
                            required:"Passport Expiry Date Required",
                            aDate: "Please enter a valid date (DD/MM/YYYY)",
                            passportdate:"Passport Expiry Date greter then current date",
                        },
                        //Representative Address
                        'addlone':"Address Line 1 Required",
                        towncity:{
                            required:"Town/ City Required",
                            alpha:"Only Alphabate allow",
                        },
                        state:{
                            required:"State Required",
                            alpha:"Only Alphabate allow",
                        },  
                        zip:{
                            required:"Zipcode Required",
                            zipcode:"Please provide a valid zipcode."
                        },
                        proofaddress:{
                            required:"Proof of address Required",
                            accept: "Only image type jpg/png/jpeg/gif is allowed",
                        },
                        //Verification
                        uploadphoto:{
                            required:"Upload Photo Required",
                            accept: "Only image type jpg/png/jpeg/gif is allowed",
                        },
                    }
                });
                form.children("div").steps({
                    headerTag: "h2",
                    bodyTag: "section",
                    transitionEffect: "slideLeft",
                    onStepChanging: function (event, currentIndex, newIndex)
                    {
                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    },
                    onFinishing: function (event, currentIndex)
                    {
                        form.validate().settings.ignore = ":disabled";
                        return form.valid();
                    },
                    onFinished: function (event, currentIndex)
                    {   
                        event.preventDefault();
                        var formData = new FormData(document.getElementById('kyc-form'));
                        $('.loader').show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                         
                         $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType:'json',
                            success: function(result){ 
                                $('.loader').hide();
                               window.location.replace("/login");                              
                            },
                            error: function(result){
                                if(result.status === 422) {
                                  var errors = result.responseJSON;
                                  $('.alert').hide();                                               
                                  $.each(result.responseJSON, function (key, value) {
                                      $('input[name="'+key+'"]').removeClass('valid').addClass('is-invalid');
                                      $('.help-block-'+key).remove();
                                      $('input[name='+key+']').after('<span class="invalid-feedback help-block help-block-'+key+'" role="alert"><strong>'+value+'</strong></span>');
                                  });
                                }else if(result.status === 401){
                                    $('.alert').show();
                                    $('.contactmess').html('Unauthenticated.');
                                        $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
                                            $(".alert-success").slideUp(500);
                                            window.location.replace("/login");
                                    });
                                }
                              }
                        });
                    }
                });
                });
    $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });  
    $(".alert-warning").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-warning").slideUp(500);
    });           
</script>
@endsection