@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    @if (session('status') && (session('status')!= 'addbalance'))
                        <div class="alert alert-success alert-dismissible"> 
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('status') }}
                        </div>
                    @endif
                    <h4 class="mb-20">{{$data['title']}}</h4>
                    <p class="mb-20">{{$data['desc']}}</p>
                    <div class="col-md-4 margin-auto">
                        <form class="common-form myform request_payment_amount" method="{{$data['method']}}" action="{{URL($data['url'])}}" >
                            {{ csrf_field() }}
                            <div class="form-group">                                
                                <input type="text" name="search_text" value="{{$data['search_text']}}" class="putemailfromAB form-control bg-white {{ $errors->has('search_text') ? ' is-invalid' : '' }}" id="search_text" value="{{old('search_text')}}" placeholder="Email addresse" readonly>
                                @if($errors->has('search_text'))                                                
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $errors->first('search_text') }}</strong>
                                    </span> 
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="hiddenUserId"  name="user_id" class="form-control bg-white {{ $errors->has('user_id') ? ' is-invalid' : '' }}" value="{{$data['user_id']}}">
                                <input type="hidden" name="id"  value="{{$user_id}}">
                                <input type="hidden" name="murl" value="{{$data['murl']}}">
                                <input name="typeuser" type="hidden" value="indi">
                                @if($errors->has('user_id'))                                                
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span> 
                                @endif
                            </div>
                            <!--<div id="cusinfo" class="form-group">-->
                            <ul class="account-list currency-list {{ $errors->has('amount') || $errors->has('user_id') || $errors->has('search_text') ? ' is-invalid input-show' : '' }}">
                                <li>
                                    <div>
                                        <label class="l-radio"> 
                                            <span>USD</span>
                                            <input type="radio" checked="checked" name="balance_request" value="1">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <label class="l-radio">                                
                                            <span>EUR</span>
                                            <input type="radio" name="balance_request" value="2">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li> 
                                <li>
                                    <div class="form-group required W-100">
                                    <input type="text" name="amount" class="form-control bg-white {{ $errors->has('amount') || $errors->has('user_id') || $errors->has('search_text') ? ' is-invalid input-show' : '' }}" placeholder="Enter Amount" value="{{old('amount')}}">
                                    @if($errors->has('amount'))                                                
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span> 
                                    @endif
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group required W-100 ">
                                   <input type="text" name="note" class="form-control input_placeholder bg-white {{ $errors->has('note') ? ' is-invalid input-show' : '' }}" value="{{old('note')}}" placeholder="Enter note ">
                                       <!---<textarea rows="3" class="form-control bg-white {{ $errors->has('note') ? ' is-invalid input-show' : '' }}" value="{{old('note')}}" placeholder="Enter note ">   </textarea>--->
                                    @if($errors->has('note'))                                                
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                            <strong>{{ $errors->first('note') }}</strong>
                                        </span> 
                                    @endif
                                    </div>
                                </li>
                            </ul>
                                
                                
                            <!--</div>-->                              
                            <div class="actionclass">
                            <button  type="submit" class="showloader btn dark-btn round-btn btn-block w-100 hvr-sweep-to-top l-btn">{{ $errors->has("amount") ? "Send" : "Next" }}</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade " id="addbalance">
    <div class="modal-dialog modal-md">
        <div class="modal-content">     
            <div class="modal-header">
                <h4 class="modal-title text-center">Add Balance</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body text-center">
                <p class="text-center">You don't have enough balance.</p>
            </div>
            <div class="modal-body text-center">
                <a href="{{URL('/business-balance/'.$user_id)}}" class="btn btn-primary round-btn text-center">Add Balance</a>
            </div>
        </div>
    </div>
</div>
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