@extends('layouts.businessdashboard')
@section('content')
@php
    $mybal = 0
@endphp
<section id="tabs">
    <div class="content_height">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
            <nav>
                    <div class="container pd0 position-relative">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <item class="nav-item nav-link @if((session('active-tab') != 'User-Requested-Money-Tab') && (session('active-tab') != 'Admin-Requested-Money-Tab')){{__('active')}}@endif" id="nav-send-tab" data-toggle="tab" href="#nav-send" role="tab" aria-controls="nav-send" aria-selected="true">Recived Money</item>
                            <item class="nav-item nav-link @if((session('active-tab') == 'User-Requested-Money-Tab') && (session('active-tab') != 'Admin-Requested-Money-Tab')){{__('active')}}@endif" id="nav-user-tab" data-toggle="tab" href="#nav-user" role="tab" aria-controls="nav-user" aria-selected="false">User Requested Money</item>
                            <item class="nav-item nav-link @if((session('active-tab') != 'User-Requested-Money-Tab') && (session('active-tab') == 'Admin-Requested-Money-Tab')){{__('active')}}@endif" id="nav-admin-tab" data-toggle="tab" href="#nav-admin" role="tab" aria-controls="nav-admin" aria-selected="false">Admin Requested Money</item>
                        </div>                        
                    </div>
                </nav>                    
            <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                <div class="tab-pane fade @if((session('active-tab') != 'User-Requested-Money-Tab') && (session('active-tab') != 'Admin-Requested-Money-Tab')){{__('show active')}}@endif" id="nav-send" role="tabpanel" aria-labelledby="nav-send-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space border-0">
                                            <div class="col-md-12">
                                                <div class="account-list currency-list d-flex">
                                                    <div class="mr-4">
                                                        <div>
                                                            <label class="l-radio"> 
                                                                <span >USD </span>
                                                                <input type="radio" name="radio1" value="usd-tab-1" checked=""  tabId="1">
                                                                <span class="checkmark checkedmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div>
                                                            <label class="l-radio"> 
                                                                <span >EUR </span>
                                                                <input type="radio" name="radio1" value="eur-tab-1"  tabId="1">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="usd-tab-1 currency-table1" style="display: block"> 
                                        <p class="price-b"> 
                                                @if(!empty($balance))
                                                    @foreach($balance as $bal)
                                                        @if($bal->currency_requested == 1)
                                                        <strong>USD : {{$bal->balance}}</strong>
                                                            @php
                                                                $mybal = $bal->balance
                                                            @endphp
                                                        @endif 
                                                    @endforeach
                                                @else
                                                <strong>0.00</strong>
                                                @endif                                                
                                        </p>
                                        @if(count($sendMoney)>0)
                                        <table class="table table-bordered my-table">                    
                                            <thead>                                               
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Email</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sendMoney as $value)
                                                @if($value['currencytype'] == 1)
                                                <tr>                                                
                                                    <td>{{$value['date']}}</td>
                                                    <td>{{$value['email']}}</td>
                                                    <td>{{$value['name']}}</td>
                                                    <td>{{$value['balance']}}</td>                                                    
                                                </tr>
                                                @endif                                                                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No Transaction Done</p>
                                        @endif
                                    </div>
                                    <div class="eur-tab-1 currency-table1" style="display: none">
                                        <p class="price-b"> 
                                                @if(!empty($balance))
                                                    @foreach($balance as $bal)
                                                        @if($bal->currency_requested == 2)
                                                        <strong>EURO : {{$bal->balance}}</strong>
                                                            @php
                                                                $mybal = $bal->balance
                                                            @endphp
                                                        @endif 
                                                    @endforeach
                                                @else
                                                <strong>0.00</strong>
                                                @endif
                                        </p>
                                        @if(count($sendMoney)>0)
                                        <table class="table table-bordered my-table">                    
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Email</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sendMoney as $value)
                                                @if($value['currencytype'] == 2)
                                                <tr>                                                
                                                    <td>{{$value['date']}}</td>
                                                    <td>{{$value['email']}}</td>
                                                    <td>{{$value['name']}}</td>
                                                    <td>{{$value['balance']}}</td>                                                    
                                                </tr>
                                                @endif                                                                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No Transaction Done</p>
                                        @endif
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="tab-pane fade @if((session('active-tab') == 'User-Requested-Money-Tab') && (session('active-tab') != 'Admin-Requested-Money-Tab')){{__('show active')}}@endif" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space border-0">
                                            <div class="col-md-12">
                                                <div class="account-list currency-list d-flex">
                                                    <div class="mr-4">
                                                        <div>
                                                            <label class="l-radio"> 
                                                                <span >USD </span>
                                                                <input type="radio" name="radio2" value="usd-tab-2" checked=""  tabId="2">
                                                                <span class="checkmark checkedmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div>
                                                            <label class="l-radio"> 
                                                                <span >EUR </span>
                                                                <input type="radio" name="radio2" value="eur-tab-2"  tabId="2">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="usd-tab-2 currency-table2" style="display: block"> 
                                        <p class="price-b"> 
                                                @if(!empty($balance))
                                                    @foreach($balance as $bal)
                                                        @if($bal->currency_requested == 1)
                                                        <strong>USD : {{$bal->balance}}</strong>
                                                            @php
                                                                $mybal = $bal->balance
                                                            @endphp
                                                        @endif 
                                                    @endforeach
                                                @else
                                                <strong>0.00</strong>
                                                @endif                                                
                                        </p>
                                        @if(count($requestUsers)>0)
                                        <table class="table table-bordered my-table">                    
                                            <thead>                                                
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Email</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($requestUsers as $value)
                                                @if($value['currencytype'] == 1)
                                                <tr>                                                
                                                    <td>{{$value['date']}}</td>
                                                    <td>{{$value['email']}}</td>
                                                    <td>{{$value['name']}}</td>
                                                    <td>{{$value['balance']}}</td>                                                    
                                                </tr>
                                                @endif                                                                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No Transaction Done</p>
                                        @endif
                                    </div>
                                    <div class="eur-tab-2 currency-table2" style="display: none">
                                        <p class="price-b"> 
                                                @if(!empty($balance))
                                                    @foreach($balance as $bal)
                                                        @if($bal->currency_requested == 2)
                                                        <strong>EURO : {{$bal->balance}}</strong>
                                                            @php
                                                                $mybal = $bal->balance
                                                            @endphp
                                                        @endif 
                                                    @endforeach
                                                @else
                                                <strong>0.00</strong>
                                                @endif
                                        </p>
                                        @if(count($requestUsers)>0)
                                        <table class="table table-bordered my-table">                    
                                            <thead>
                                                
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Email</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($requestUsers as $value)
                                                @if($value['currencytype'] == 2)
                                                <tr>                                                
                                                    <td>{{$value['date']}}</td>
                                                    <td>{{$value['email']}}</td>
                                                    <td>{{$value['name']}}</td>
                                                    <td>{{$value['balance']}}</td>                                                    
                                                </tr>
                                                @endif                                                                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No Transaction Done</p>
                                        @endif
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="tab-pane fade @if((session('active-tab') != 'User-Requested-Money-Tab') && (session('active-tab') == 'Admin-Requested-Money-Tab')){{__('show active')}}@endif" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
                         <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space border-0">
                                            <div class="col-md-12">
                                                <div class="account-list currency-list d-flex">
                                                    <div class="mr-4">
                                                        <div>
                                                            <label class="l-radio"> 
                                                                <span >USD </span>
                                                                <input type="radio" name="radio3" value="usd-tab-3" checked=""  tabId="3">
                                                                <span class="checkmark checkedmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div>
                                                            <label class="l-radio"> 
                                                                <span >EUR </span>
                                                                <input type="radio" name="radio3" value="eur-tab-3"  tabId="3">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="usd-tab-3 currency-table3" style="display: block"> 
                                        <p class="price-b"> 
                                                @if(!empty($balance))
                                                    @foreach($balance as $bal)
                                                        @if($bal->currency_requested == 1)
                                                        <strong>USD : {{$bal->balance}}</strong>
                                                            @php
                                                                $mybal = $bal->balance
                                                            @endphp
                                                        @endif 
                                                    @endforeach
                                                @else
                                                <strong>0.00</strong>
                                                @endif                                                
                                        </p>
                                        @if(count($requestAdmin)>0)
                                        <table class="table table-bordered my-table">                    
                                            <thead>
                                                
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Email</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($requestAdmin as $value)
                                                @if($value['currencytype'] == 1)
                                                <tr>                                                
                                                    <td>{{$value['date']}}</td>
                                                    <td>{{$value['email']}}</td>
                                                    <td>{{$value['name']}}</td>
                                                    <td>{{$value['balance']}}</td>                                                    
                                                </tr>
                                                @endif                                                                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No Transaction Done</p>
                                        @endif
                                    </div>
                                    <div class="eur-tab-3 currency-table3" style="display: none">
                                        <p class="price-b"> 
                                                @if(!empty($balance))
                                                    @foreach($balance as $bal)
                                                        @if($bal->currency_requested == 2)
                                                        <strong>EURO : {{$bal->balance}}</strong>
                                                            @php
                                                                $mybal = $bal->balance
                                                            @endphp
                                                        @endif 
                                                    @endforeach
                                                @else
                                                <strong>0.00</strong>
                                                @endif
                                        </p>
                                        @if(count($requestAdmin)>0)
                                        <table class="table table-bordered my-table">                    
                                            <thead>
                                               
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Email</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($requestAdmin as $value)
                                                @if($value['currencytype'] == 2)
                                                <tr>                                                
                                                    <td>{{$value['date']}}</td>
                                                    <td>{{$value['email']}}</td>
                                                    <td>{{$value['name']}}</td>
                                                    <td>{{$value['balance']}}</td>                                                    
                                                </tr>
                                                @endif                                                                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No Transaction Done</p>
                                        @endif
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
<script src="{{URL('/public/js/active_tab.js')}}" type="text/javascript"></script>
 <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
  window.FontAwesomeConfig = {
    searchPseudoElements: true
  }
  
  $(document).ready(function(){
    $('.account-list input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
         var tabId = $(this).attr("tabId");
        var targetBox = $("." + inputValue);
        $(".currency-table"+tabId).hide();
        $(targetBox).show();
        $(this).parent().parent().parent().parent().find('.checkmark').removeClass('checkedmark');
    });
});

</script>
@endsection