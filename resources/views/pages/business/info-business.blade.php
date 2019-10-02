@extends('layouts.withoutheaderfooter')
@section('content')
<link rel="stylesheet" href="{{url('/public/css/jquery.steps.css')}}">
<link rel="stylesheet" href="{{url('/public/js/bootstrap-fileinput/bootstrap-fileinput.css')}}">
<link rel="stylesheet" href="{{url('/public/css/bootstrap-datepicker.css')}}"/>
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
                                    <label>Business Type <span class="asterik">*</span></label>
                                    <input type="text" name="btype" class="form-control" value="{{old('btype')}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group required bus_cer_main">
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
                                <div class="col-md-6 form-group required bus_cer_main">
                                    <label>Memorandum <span class="asterik">*</span></label>
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
                                                <input type="file" name="memorandum"> 
                                            </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                                Remove </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 form-group">
                                    <label>Memorandum <span class="asterik">*</span></label>
                                    <input type="text" name="memorandum" class="form-control" value="{{old('memorandum')}}">
                                </div> -->
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
                                    <div class="input-group date" data-provide="datepicker">
                                       <input type="text" class="form-control" name="dob"  value="{{old('dob')}}" placeholder="DD/MM/YYYY">
                                       <div class="input-group-addon">
                                           <span class="glyphicon glyphicon-th"></span>
                                       </div>
                                   </div>
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
                                    <label>Passport Expiry Date<span class="asterik">*</span></label>
                                    <div class="input-group date" data-provide="datepicker">
                                       <input type="text" class="form-control" name="passexpdt"  value="{{old('passexpdt')}}" placeholder="DD/MM/YYYY">
                                       <div class="input-group-addon">
                                           <span class="glyphicon glyphicon-th"></span>
                                       </div>
                                   </div>
                                </div>
                                 <div class="col-md-6 form-group required bus_cer_main">
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
                                <div class="col-md-6 form-group required bus_cer_main">
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
                                <div class="col-md-6 form-group">
                                    <label>Currency  <span class="asterik">*</span></label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="currency">
                                        <option value="">Please Select Currency</option>
                                        <option value="USD">USD</option>
                                        <option value="EURO">EURO</option>                                     
                                    </select>
                                </div>
                            </div>
                        </section>

                        <h2>Verification</h2>
                        <section class="alert_remove">    
                            <div class="errormess"></div>
                            <div class="alert alert-success alert-dismissible" style="display:none">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <span class="contactmess"></span>
                            </div>                            
                            <div class="col-md-6 form-group required margin-auto">
                                <label>Upload Photo<span class="asterik">*</span></label>
                                <input src="" type="file" class="upload_pro_image" id="upload_image" img_height="224" img_width="325">  
                                <input type="hidden" id="uploadphoto" name="uploadphoto">
                                <!--                                <div class="fileinput fileinput-new" data-provides="fileinput">
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
                                                                            
                                                                </div>-->
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
<script type="text/javascript" src="{{url('/public/js/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{url('/public/js/jquery.steps.js')}}"></script>
<script src="{{url('/public/js/bootstrap-datepicker.js')}}"></script> 
<script>
    $.fn.datepicker.defaults.format = "dd/mm/yyyy";
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
    });           
</script>
<script>
$(function ()
{

    $.validator.addMethod("alpha", function (value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z \s]+$/);
    });
    $.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s]+$/);
    });
    jQuery.validator.addMethod("zipcode", function (value, element) {
        return this.optional(element) || /^\d{6}$/.test(value);
    }, "Please provide a valid zipcode.");
    $.validator.addMethod("passportno", function (value, element) {
//                        return this.optional(element) || value == value.match(/^(?!^0+$)[a-zA-Z0-9]{3,20}$/);
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s]+$/);
    });
    $.validator.addMethod("aDate", function (value, element) {
        return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
    }, "Please enter a date in the format!");


    $.validator.addMethod("aDate", function (value, element) {
        return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
    }, "Please enter a date in the format!");

    $.validator.addMethod("birth", function (value, element) {
        var year = value.split('/');
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear() - 18;
        
        if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) < yyyy) {
            return true;
        } else if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) == yyyy) {
            if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) < mm) {
                return true;
            } else if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) == mm) {
                if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[0]) <= dd) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    });

    $.validator.addMethod("passportdate", function (value, element) {
        var year = value.split('/');
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) > yyyy) {            
            return true;
        } else if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[2]) == yyyy) {
            if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) > mm) {
                return true;
            } else if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[1]) == mm) {
                if (value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/) && parseInt(year[0]) >= dd) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    });

    var form = $("#kyc-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        },
        rules: {
            // Business Details
            bname: {
                required: true,
                alpha: true
            },
            btype: {
                required: true,
                alpha: true
            },
            bcirtificate: {
                required: true,
                extension: "xls|docs|pdf|jpg|png|jpeg",
            },
            memorandum: {
                required: true,
                extension: "pdf",
            },
            // Representative Details
            fname: {
                required: true,
                alpha: true
            },
            'mname': "alpha",
            lname: {
                required: true,
                alpha: true
            },
            passno: {
                required: true,
                rangelength: [3, 10],
                alphanumeric: true,
            },
            dob: {
                required: true,
                aDate: true,
                birth: true,
            },
            'passcountry': "required",
            passfile: {
                required: true,
                extension: "pdf|jpg|png|jpeg",
            },
            passexpdt: {
                required: true,
                aDate: true,
                passportdate: true,
            },
            //Representative Address
            addlone:{ 
                required:true,
                maxlength : 100,
            },
            addltwo:{               
                maxlength : 100,
            },
            towncity: {
                required: true,
                alpha: true,
            },
            state: {
                required: true,
                alpha: true,
            },
            zip: {
                required: true,
                zipcode: true,
            },
            proofaddress: {
                required: true,
                extension: "pdf|jpg|png|jpeg",
            },
            currency: {
                required: true,
            },

            //Verification
            uploadphoto:{
                required:true,
                extension:"jpg|png|jpeg",         
            },
        },
        messages: {
            // Business Details
            bname: {
                required: "Bisiness Name Required",
                alpha: "Only Alphabate allow",
            },
            btype: {
                required: "Business Type Required",
                alpha: "Only Alphabate allow",
            },
            bcirtificate: {
                required: "Business Certificate Required",
                extension: "Only image type jpg/png/jpeg/pdf/docs/excel is allowed",
            },
            memorandum: {
                required: "Memorandum PDF File Required",
                extension: "Only document type pdf is allowed",
            },
            // Representative Details
            fname: {
                required: "First Name Required",
                alpha: "Only Alphabate allow",
            },
            'mname': "Only Alphabate allow",
            lname: {
                required: "Last Name Required",
                alpha: "Only Alphabate allow",
            },
            passno: {
                required: "Passport Number Required",
                rangelength: "Length should be in between 3 to 10.",
                alphanumeric: "Only Alpha numeric charecter allow.",

            },
            dob: {
                required: "Date of Birth Required",
                aDate: "Please enter a valid date (DD/MM/YYYY)",
                birth: "Date of birth More then 18 Years.",
            },
            'passcountry': "Passport Country Required",
            passfile: {
                required: "Passport File Required",
                extension: "Only image type jpg/png/jpeg/pdf is allowed",
            },
            passexpdt: {
                required: "Passport Expiry Date Required",
                aDate: "Please enter a valid date (DD/MM/YYYY)",
                passportdate: "Passport Expiry Date Greater than current date",
            },
            //Representative Address
            addlone:{ 
                required:"Address Line 1 Required",
                maxlength : "Address Line 100 charecter allowed",
            },
            addltwo:{               
                maxlength : "Address Line 100 charecter allowed",
            },
            towncity: {
                required: "Town/ City Required",
                alpha: "Only Alphabate allow",
            },
            state: {
                required: "State Required",
                alpha: "Only Alphabate allow",
            },
            zip: {
                required: "Zipcode Required",
                zipcode: "Only 5 digits numbers allowed."
            },
            proofaddress: {
                required: "Proof of address Required",
                extension: "Only image type jpg/png/jpeg/pdf is allowed",
            },
            currency: {
                required: "Currency Required", 
            },
            //Verification
            uploadphoto:{
                required:"Upload Photo Required",
                extension: "Only image type jpg/png/jpeg is allowed",                           
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.loader').show();
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (result) {
                    $('.loader').hide();
                    window.location.replace("/login");
                },
                error: function (result) {
                    $('.loader').hide();
                    if (result.status === 422) {
                        var errors = result.responseJSON;                       
                        $.each(result.responseJSON.errors, function (key, value) {
                            $('input[name="' + key + '"]').removeClass('valid').addClass('is-invalid');
                            $('.help-block-' + key).remove();
                            $('input[name=' + key + ']').after('<span class="invalid-feedback help-block help-block-' + key + '" role="alert"><strong>' + value + '</strong></span>');
                        });
                        $('.errormess').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Some thing wrong.please check the steps.</strong></div>');
                        $(".alert-danger").fadeTo(5000, 500).slideUp(500, function(){
                            $(".alert-danger").slideUp(500);
                        }); 
                    } else if (result.status === 401) {
                        $('.errormess').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Unauthenticated.</strong></div>');
                            $(".alert-danger").fadeTo(5000, 500).slideUp(500, function(){
                            $(".alert-danger").slideUp(500);
                            window.location.replace("/login");
                        });                       
                    }
                }
            });
        }
    });
});
$(".alert-success").fadeTo(5000, 500).slideUp(500, function () {
    $(".alert-success").slideUp(500);
});
$(".alert-warning").fadeTo(5000, 500).slideUp(500, function () {
    $(".alert-warning").slideUp(500);
});
</script>
<script src="{{url('/public/js/croppie.js')}}"></script>
<script>
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
        size: 'viewport',
    }).then(function (response) {
        $(".loader").show();
        $('#uploadimageModal2').modal('hide');
        response = window.btoa(response);
        $.ajax({
            url: '{{URL("/kycaddprofilepic")}}',
            type: "POST",
            data: {"myphoto": response},
            success: function (result)
            {
                console.log(result);
                var imageUrl = $.trim(result);
                var val = imageUrl;
                $('#uploadphoto').attr('value', val);
                $(".loader").fadeOut(1000);
            }
        });
    });
});
</script>
@endsection