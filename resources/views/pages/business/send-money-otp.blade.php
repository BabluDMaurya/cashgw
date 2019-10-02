@extends('layouts.businessdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h4 class="mb-20">Confirm OTP</h4>
                    <p class="mb-20">cashgw send you a mail with otp. Enter otp for proceeds</p>
                    <div class="col-md-4 margin-auto">
                        <form class="common-form myform" method="POST" action="{{URL($data['murl'])}}">
                            {{ csrf_field() }}
                            @if($data['recivedrequest'] == 'Yes') 
                                <input name="_method" value="PUT" type="hidden">
                                <input type="hidden" name="email" class="form-control bg-white" value="{{$data['email']}}" readonly>                                
                                <input type="hidden" name="id" class="form-control bg-white" value="{{$data['id']}}" readonly>                                
                                <input type="hidden" name="action" class="form-control bg-white" value="{{$data['action']}}" readonly>                                
                                <input type="hidden" name="amount" class="form-control bg-white" value="{{$data['amount']}}" readonly>
                            @else 
                                <input type="hidden" name="id" class="form-control bg-white" value="{{$user_id}}" readonly>                                
                                <input type="hidden" name="search_text" class="form-control bg-white" value="{{$data['search_text']}}" readonly>                                
                                <input type="hidden" name="email" class="form-control bg-white" value="{{$data['email']}}" readonly>                                
                                <input type="hidden" name="user_id" class="form-control bg-white" value="{{$data['user_id']}}" readonly>
                                <input type="hidden" checked="checked" name="balance_request" value="{{$data['currency']}}" readonly>
                                <input type="hidden" name="amount" class="form-control bg-white " value="{{$data['amount']}}" readonly>
                                <input type="hidden" name="note" class="form-control" value="{{$data['note']}}" readonly>
                            @endif    
                            <div class="form-group">
                                <input type="text" name="otp" class="form-control bg-white {{ $errors->has('otp') ? ' is-invalid' : '' }}" placeholder="Enter otp" autocomplete="Off">
                                @if($errors->has('otp'))                                                
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span> 
                                @endif
                            </div>
                            <div class="actionclass">
                            <button  type="submit" class="showloader btn dark-btn round-btn btn-block w-100 hvr-sweep-to-top l-btn">Submit</button>
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
     $(document).on('click','.showloader',function(){
    if ($('.myform').valid()) {
            $('.loader').show();
        } else {           
            e.preventDefault();
            $('.loader').hide();
        }
});
    $(document).ready(function () {
        $(document).on('change','#search_text',function(){
            $('input[name=amount]').removeClass('input-hide').addClass('input-show');
            $('input[name=note]').removeClass('input-hide').addClass('input-show');
            $('.currency-list').removeClass('input-hide').addClass('input-show');
            $('input[name=amount]').focus();
        });
        $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });
   
    src = "{{ route('searchajax') }}";
     $("#search_text").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
        select: function (event, ui) {
            $('input[name=user_id]').val(ui.item.id); // display the selected text
            $("#search_text").val(ui.item.value); // save selected id to hidden input
        },
        change: function( event, ui ) {
            $('input[name=user_id]').val( ui.item? ui.item.id : 0 );
        } 
    });
    // 
    $('.myform').each(function(){
        $(this).validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            search_text: {
                required: true,
            },
            amount: {
                required: true,
                digits: true,
            },
            note:{
                required: true,
                maxlength: 40,
            },
            otp:{
                required: true,
                digits: true,
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        messages: {
            search_text: {
                required: "Email Address or Phone Number Required",
            },
            amount: {
                required: "Amount Required",
                digits: "Please enter integers number",
            },
            note:{
                required: "Note Required",
                maxlength: "Note not more then 40 charecters",
            },
            otp:{
                required: "OTP Required",
                digits: "Please enter valid OTP",
            }
        }
    });
    });
    @if (session('status'))
            @if(session('status') == 'addbalance')       
                $('#addbalance').modal('show'); 
            @endif
        @endif
});
</script>
@endsection