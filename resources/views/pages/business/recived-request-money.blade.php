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
                            <item class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">USD Request </item>
                            <item class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">EURO Request</item>
                        </div>                        
                    </div>
                </nav>    
            <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="filter-sec">
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
                                        <button type="button" class="btn btn-primary round-btn text-center" data-toggle="modal" data-target="#addbalance"> Add Balance</button>
                                    </div>
                                    @if(count($requestedMoneyFromUserdoller) > 0)
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th>Date</th>
                                                <th>Email</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            @foreach($requestedMoneyFromUserdoller as $requestmoney)  
                                                <tr>
                                                    <td>{{$requestmoney['date']}}</td>
                                                    <td>{{$requestmoney['email']}}</td>
                                                    <td>{{$requestmoney['name']}}</td>
                                                    <td>{{$requestmoney['amount']}}</td>
                                                    <td>
                                                        @if($requestmoney['amount'] <= $mybal)                                                        
                                                        <div  class="btn icon-btn accept-btn acceptreq" data-id='{{$requestmoney['id']}}'  data-toggle="modal" data-target="#accept"><i class="far fa-check-circle"></i></div>                                                        
                                                        @else
                                                        <div class="btn icon-btn accept-btn acceptreq" data-toggle="tooltip" title="@php echo config('constants.NoBalanceToltip')@endphp"><i class="far fa-check-circle"></i></div>                                                        
                                                        @endif 
                                                        <div class="btn icon-btn reject-btn rejectreq" data-id='{{$requestmoney['id']}}' data-toggle="modal" data-target="#rejected"><i class="fas fa-ban"></i></div>
                                                    </td>
                                                </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <p>No Record Found</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                         <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="filter-sec">
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
                                        <button type="button" class="btn btn-primary round-btn text-center" data-toggle="modal" data-target="#addbalance"> Add Balance</button>
                                    </div>
                                    @if(count($requestedMoneyFromUsereuro) > 0)
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th>Date</th>
                                                <th>Email</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                            @foreach($requestedMoneyFromUsereuro as $requestmoney)                                                                                           
                                                <tr>
                                                    <td>{{$requestmoney['date']}}</td>
                                                    <td>{{$requestmoney['email']}}</td>
                                                    <td>{{$requestmoney['name']}}</td>
                                                    <td>{{$requestmoney['amount']}}</td>
                                                    <td>
<!--                                                        @if($requestmoney['amount'] <= $mybal)
                                                            <button type="button" data-id='{{$requestmoney['id']}}' class="btn btn-primary round-btn text-center acceptreq" data-toggle="modal" data-target="#accept">Accept</button>                                                        
                                                        @else
                                                            <button type="button" class="btn btn-primary round-btn text-center acceptreq" data-toggle="tooltip" title="@php echo config('constants.NoBalanceToltip')@endphp">Accept</button>                                                        
                                                        @endif                                                        
                                                        <button type="button" data-id='{{$requestmoney['id']}}' class="btn btn-danger round-btn text-center rejectreq" data-toggle="modal" data-target="#rejected">Reject</button>-->
                                                        @if($requestmoney['amount'] <= $mybal)                                                        
                                                        <div  class="btn icon-btn accept-btn acceptreq" data-id='{{$requestmoney['id']}}'  data-toggle="modal" data-target="#accept"><i class="far fa-check-circle"></i></div>                                                        
                                                        @else
                                                        <div class="btn icon-btn accept-btn acceptreq" data-toggle="tooltip" title="@php echo config('constants.NoBalanceToltip')@endphp"><i class="far fa-check-circle"></i></div>                                                        
                                                        @endif 
                                                        <div class="btn icon-btn reject-btn rejectreq" data-id='{{$requestmoney['id']}}' data-toggle="modal" data-target="#rejected"><i class="fas fa-ban"></i></div>
                                                    </td>
                                                </tr>                                             
                                            @endforeach                                                                                 
                                        </tbody>
                                    </table>
                                    @else
                                    <p>No Record Found</p>
                                    @endif   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    
<div class="modal fade " id="accept">
    <div class="modal-dialog modal-md">
        <div class="modal-content">   
            <div class="modal-header">
                <h4 class="modal-title text-center">Accept Request</h4>
                <button type="button" class="close" data-dismiss="modal">?</button>
            </div>
            @if(session('status') != 'accept')
            <div class="modal-body text-center">                
                    <p class="text-center">@php echo config('constants.AcceptRequest'); @endphp</p>
            </div>        
            <div class="modal-body text-center">
                <form action="{{URL('/business-recived-request/'.$user_id)}}" method="post"> 
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="" id="acceptrow" class="form-control  {{ $errors->has('id') ? ' is-invalid' : '' }}">
                @if($errors->has('userid'))                                                
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $errors->first('id') }}</strong>
                    </span> 
                @endif
                <input type="hidden" name="action" value="2" class="form-control  {{ $errors->has('action') ? ' is-invalid' : '' }}">
                @if($errors->has('action'))                                                
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $errors->first('action') }}</strong>
                    </span> 
                @endif
                <input type="submit" name="brrmaction" value="Accept" class="btn btn-primary round-btn text-center">
            </form>
            </div>
            @else
            <div class="modal-body text-center">
                <p class="text-center">@php echo config('constants.AcceptRequestSuccess'); @endphp</p>
            </div>
            <div class="modal-body text-center">
                <button type="button" class="btn btn-primary round-btn text-center" data-dismiss="modal" onClick="location.href=location.href">OK</button>                
            </div>
            @endif            
        </div>
    </div>
</div>
<div class="modal fade " id="addbalance">
    <div class="modal-dialog modal-md">
        <div class="modal-content">     
            <div class="modal-header">
                <h4 class="modal-title text-center">Request For Balance</h4>
                <button type="button" class="close" data-dismiss="modal">?</button>
            </div>
            <div class="modal-body text-center">
                <p class="text-center">@php echo config('constants.RequestForBalance'); @endphp</p>
                <ul class="account-list currency-list text-center">
                    <li>
                        <label class="l-radio"> 
                            <span>Request For Admin</span>
                            <input type="radio" checked="checked" name="addbaloption" value="1">
                            <span class="checkmark"></span>
                        </label>
                    </li>
                    <li>
                        <label class="l-radio"> 
                             <span>Request For Customer</span>
                             <input type="radio" name="addbaloption" value="2">
                             <span class="checkmark"></span>
                        </label>
                    </li>
                </ul>      
            </div>
            <div class="modal-body text-center">
                <button type="button" class="btn btn-primary round-btn text-center" id="addbaloptionreq">Request</button>
            </div>
        </div>
    </div>
</div>    
<div class="modal fade " id="request">
    <div class="modal-dialog modal-md">
        <div class="modal-content">     
            <div class="modal-body text-center">
                <p class="text-center">
                    @if (session('status'))
                        {{session('status')}}
                    @endif
                </p>                
            </div>
            <div class="modal-body text-center">
                <a class="btn btn-primary round-btn text-center" data-dismiss="modal">OK</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="rejected">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Reject Request</h4>
                <button type="button" class="close" data-dismiss="modal">?</button>
            </div>
            @if(session('status') != 'rejected')
            <div class="modal-body text-center">
                    <p class="text-center">@php echo config('constants.RejectRequest'); @endphp</p>
            </div>        
            <div class="modal-body text-center">
                <form action="{{URL('/business-recived-request/'.$user_id)}}" method="post"> 
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="rejectrow" value="" class="form-control  {{ $errors->has('id') ? ' is-invalid' : '' }}">
                    @if($errors->has('userid'))                                                
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $errors->first('id') }}</strong>
                        </span> 
                    @endif
                    <input type="hidden" name="action" value="3" class="form-control  {{ $errors->has('action') ? ' is-invalid' : '' }}">
                    @if($errors->has('action'))                                                
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $errors->first('action') }}</strong>
                        </span> 
                    @endif
                    <input type="submit" name="brrmaction" value="Reject" class="btn btn-danger round-btn text-center">
                </form>
        </div>
            @else
                <div class="modal-body text-center">
                    <p class="text-center">@php echo config('constants.RejectRequestSuccess'); @endphp</p>
                </div>
                <div class="modal-body text-center">
                    <button type="button" class="btn btn-primary round-btn text-center" data-dismiss="modal" onClick="location.href=location.href">OK</button>                
                </div>
            @endif
        </div>
    </div>
</div>    
</section>
<script src="{{URL('/public/js/active_tab.js')}}" type="text/javascript"></script>
 <script>     
     $(document).ready(function(){
         $('[data-toggle="tooltip"]').tooltip();   
        $(document).on('click','.rejectreq',function(){
            var id = $(this).data('id'); 
            $('#rejectrow').val(id);
         });
         $(document).on('click','.acceptreq',function(){
            var id = $(this).data('id'); 
            $('#acceptrow').val(id);
         }); 
         $(document).on('click','#addbaloptionreq',function(){
             var option = $('input[name=addbaloption]:checked').val();
             if(option == 1){
                 $('#addbalance').modal('hide');
                 $('#add-currency').modal('show');
             }else{
                 $('#addbalance').modal('hide'); 
                 $.ajax({
                    url: "{{route('backurl')}}",
                    dataType: "json",
                    data: { backUrl:"{{URL('/business-recived-request/'.$user_id)}}"},
                    success: function(data) {
                        console.log(data);
                        if(data == true){
                             window.location.href="{{URL('/business-request-payment/'.$user_id)}}";
                        }
                    }
                });
                 
             }
         });
        @if (session('status'))
            @if(session('status') == 'accept')
                    $("#accept").modal('show');
            @elseif(session('status') == 'addbalance')       
                    $('#addbalance').modal('show'); 
            @elseif(session('status') == 'rejected')       
                    $('#rejected').modal('show'); 
            @else
                    $('#request').modal('show');
            @endif
        @endif
     });
 </script>
 <script>
$('#addbalance').on({'mousewheel': function(e) 
    {
    if (e.target.id == 'el') return;
    e.preventDefault();
    e.stopPropagation();
   }
});

</script>
@endsection