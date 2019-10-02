@extends("layouts.$dashboard")
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <div id="message"></div>
                    <h4 class="mb-20">Confirm OTP</h4>
                    <p class="mb-20">cashgw send you a mail with otp. Enter otp for proceeds</p>
                    <div class="col-md-4 margin-auto">
                        <form class="common-form myform" method="POST" action="" id="confirm_otp">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" name="otp" class="form-control bg-white {{ $errors->has('otp') ? ' is-invalid' : '' }}" placeholder="Enter otp">
                                @if($errors->has('otp'))                                                
                                <span class="invalid-feedback" role="alert" style="display: block">
                                    <strong>{{ $errors->first('otp') }}</strong>
                                </span> 
                                @endif
                            </div>
                            <input type="hidden" name="invoiceId" id="invoiceId" value="{{$invoice_id}}" >
                            <div class="actionclass">
                                <button  type="submit" class="btn dark-btn round-btn btn-block w-100 hvr-sweep-to-top l-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link href="{{url('/public/css/jquery.ui.autocomplete.css')}}"/>
<script src="{{url('/public/js/jquery.js')}}"></script>
<script src="{{url('/public/js/jquery-ui.min.js')}}"></script>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script>
$(document).ready(function () {
    $('#confirm_otp').validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            "otp": {
                required: true,
                number: true,
                maxlength: 5,
                minlength: 5,
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        messages:{
            "otp": {
                required:"OTP Required",
                number: "OTP must be Number",
                maxlength: "Length Should be 5 digits",
                minlength: "Length Should be 5 digits",
            }
        },
        submitHandler: function (form) {
            $('.loader').show();
            var data = $("#confirm_otp").serializeArray();
            $.ajax({
                url: BASE_URL + '/{{$invoice_otp_check}}',
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.loader').hide();
                    var result = JSON.parse(response);
                    if (result.status == 'paid') {
                        $('#message').html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>');
                        setInterval(function () {
                            window.location.href = BASE_URL + '/{{$manage}}/' + result.userId;
                        }, 4000);
                    } else if (result.status == 'noMoney') {
                        $('#message').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>');
                        setInterval(function () {
                            window.location.href = BASE_URL + '/{{$balance}}/' + result.userId;
                        }, 4000);
                    } else if (result.status == 'wrongOtp') {
                        $('#message').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>');
                    } else {
                        $('#message').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>');
                    }
                }
            });
        }
    });
});
</script>
@endsection