@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        @if (session('status'))
                    <div class="alert alert-success alert-dismissible"> 
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('status') }}
                    </div>
                @endif
        <div class="row">
            <div class="col-md-4">
                <div class="block-item shadow-block">
                    @include('includes.userdashboardsidebarmenu')
                </div>
            </div>
             <div class="col-md-8">
                <div class="block-item shadow-block">
                    <div class="detail-det available-bal">
                        <ul class="account-list">
                            
                                        <li>
                                            <div>
                                                <div class="img-card">
                                                    <img src="{{url('/public/images/flag.jpg')}}">
                                                </div>
                                                <div>USD<span class="text-below">primary</span></div>
                                            </div>
                                            <div class="d-flex align-items-baseline">
                                                <span>$ @if($balance['USD'] > 0){{$balance['USD']}} @else 0.00 @endif USD</span>
                                                @if($balance['USD'] > 0)
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <form action="{{URL('/individual-balance/'.$user_id.'/edit')}}" method="get">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="currencytype" value="USD">
                                                            <button type="submit" class="btn dropdown-item">Convert Currency</button>                                             
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </li>     
                                        
                                        <li>
                                            <div>
                                                <div class="img-card">
                                                    <img src="{{url('/public/images/eur.jpg')}}">
                                                </div>
                                                <div>EUR</div>
                                            </div>
                                            <div class="d-flex align-items-baseline">
                                                <span>&euro; @if($balance['EUR'] > 0){{$balance['EUR']}} @else 0.00 @endif EUR</span>
                                                @if($balance['EUR'] > 0)
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <form action="{{URL('/individual-balance/'.$user_id.'/edit')}}" method="get">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="currencytype" value="EUR">
                                                            <button type="submit" class="btn dropdown-item">Convert Currency</button>                                             
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </li>     
                        </ul> 
                        <a href="#!" data-toggle="modal" data-target="#add-currency" class="add-currency" ><i class="fas fa-plus-circle"></i> Add balance</a><br>
                        <p><small class="light-text" >* This amount is an estimate based on the most recent currency conversion rate.</small></p>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</section>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.modal').on('hidden.bs.modal', function(e){        
               $(this)
                  .find("input,textarea,select")
                     .val('')
                     .end()
                  .find('.invalid-feedback').removeClass('error').text('')
                     .end();           
        });
        
        $.validator.addMethod('positiveNumber',
    function (value) { 
        return Number(value) > 0;
    }, 'Enter a positive number.');
    
       $('.myform').each(function(){
        $(this).validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {            
            balance:{
                required: true,
                positiveNumber: true,
            },
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
                positiveNumber: "Please enter Positive Number.",
            },
        }
    });
    });
});    
</script>
@endsection