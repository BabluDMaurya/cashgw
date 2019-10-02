@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
                <h4 class="mb-20 text-center">Convert Currency</h4>
                <p class="mb-20 text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br> Lorem Ipsum has been the industry's standard </p>
                <div class="d-block w-100">
                         <div class="total-saving">
                         <p class="text-center mb-4">
                            Your account have 
                            @if(!empty($balance))                                                                      
                            <strong> <span id="remainbalance">{{$balance['balance']}}</span> {{$currency}}</strong> balance 
                            @else
                                0.00 {{currency}}
                            @endif     
                        </p>
                        </div> 
                     </div>
            <div class="row" id="message">      
                <form action="{{URL('/individual-balance/'.$user_id)}}" class="common-form w-100 mb-0 myform" id="ccformpre">
                    
                <ul class="account-list currency-list mb-0">                    
                    <li>
                        <div class="form-group required col-lg-3">
                            <input type="text" class="form-control" name="balance" placeholder="Enter Amount" value="@if(!empty(session('balance'))) {{session('balance')}} @endif">
                        </div>
                        <div class="form-group required col-lg-3"> 
                            <input type="text" class="form-control" name="fromcurrency" value="{{$currency}}" readonly>
                        </div>
                        <div class="form-group d-block col-lg-3">                        
                            <select name="tocurrency" class="form-control tocurrency w-100">
                                <option selected disabled>select Currency</option>
                                <option value="USD" @if($currency == 'USD') disabled @endif >USD</option>
                                <option value="EUR" @if($currency == 'EUR') disabled @endif >EUR</option>
                            </select>
                        </div>
                        <div class="form-group text-center col-lg-3">
                            <button type="submit" name="ccform" class="btn dark-btn round-btn btn-block hvr-sweep-to-top l-btn">Submit</button>
                        </div>
                    </li>
                    </ul>  
                </form>
                <div id="ajaxresponce" class="block-item shadow-block" style="display: none">
                    <div class="form-row">
                        <div class="form-group col-lg-3">
                            <label for="canvertion_charge" class="col-form-label ">
                                Canvertion Charge : <span id="canvertion_charge">{{session('canvertion_charge')}}</span>
                            </label>                                
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="amount" class="col-form-label ">
                                Amount : <span id="amount">{{session('amount')}}</span>
                            </label>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="convertionRate" class="col-form-label ">
                                Convertion Rate : <span id="convertionRate">{{session('convertionRate')}}</span>
                            </label>                             
                        </div>
                        
<!--                        <div class="form-group col-lg-4">
                            <label for="cashgw_charge" class="col-form-label ">
                                Cashgw Charge : <span id="cashgw_charge">{{session('cashgw_charge')}}</span>
                            </label>                                                                                                            
                        </div>-->
                        <div class="form-group col-lg-3">
                            <label for="convertedAmount" class="col-form-label ">
                                Converted Amount : <span id="convertedAmount">{{session('convertedAmount')}}</span>
                            </label>                                                        
                        </div> 
                    </div> 
                    <div class="text-center mt-4">                  
                        <form action="{{URL('/individual-balance/'.$user_id)}}" class="align-self-center common-form d-flex mb-0 myform" id="newform">
                            <input type="hidden" name="amount" value="">
                            <input type="hidden" name="convertionRate" value="">
                            <input type="hidden" name="canvertion_charge" value="">
<!--                            <input type="hidden" name="cashgw_charge" value="">-->
                            <input type="hidden" name="convertedAmount" value="">
                            <input type="hidden" name="from_currency" value="">
                            <input type="hidden" name="to_currency" value="">
                            <input  type="submit" name="convertcurrency" class="btn dark-btn round-btn btn-inline-block" value="Convert"/>                                
                            <a  href="{{URL('/individual-balance/'.$user_id)}}" class="btn dark-btn round-btn btn-inline-block">Cancel</a>                                
                        </form>
                    </div>  
            </div>
        </div>
    </div>
</section>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script>
    $(document).ready(function(){
       $('.myform').each(function(){
        $(this).validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {            
            balance:{
                required: true,
            },
            tocurrency:{
                required: true,
            },
            fromcurrency:{
                required: true,
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        messages: {            
            balance:{
                required: "Amount Required",
            },
            tocurrency:{
                required: "Currency Required",
            },
            fromcurrency:{
                required: "Currency Required",
            }
        },
        submitHandler: function(form) {
            $('.loader').show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 
            $.ajax({
                url :$(form).attr('action'),
                type :"PUT",
                data: $(form).serialize(),
                success: function(response){
                    $('.loader').hide();
                    if(response.ccstatus == 'Success'){
                        $.each(response, function(key, value) {
                            $('#'+key).text(value);
                            $('input[name='+key+']').val(value);
                        })
                        $('#ajaxresponce').show();
                    }else if(response.ccstatus == 'Fail'){
                        $('#message').html('<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Please Enter Enough Money</div>');                        
                        setInterval(function(){ 
                            location.reload();
                        }, 3000);
                    }else if(response.status == 'success'){
                        $('#message').html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Currency convertion Successfull.</div>');
                        $('#remainbalance').text(response.remainbalance);
                        setInterval(function(){ 
                            window.location.replace($(form).attr('action'));
                        }, 3000);
                    }else if(response.error_status == '403'){
                        $('#message').html('<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error_message+'</div>');                        
                        setInterval(function(){ 
                            location.reload();
                        }, 3000);
                    }
                }
        });
        }
    });
    });
});    
</script>
@endsection