@extends('layouts.userdashboard')
@section('content')
<section id="tabs">
    <div class="content_height">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
            <nav>
                    <div class="container pd0 position-relative">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <item class="nav-item nav-link @if(session('active-tab') != 'Sent-Request-To-Users-Tab'){{__('active')}}@endif" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Sent Request To Admin</item>
                            <item class="nav-item nav-link @if(session('active-tab') == 'Sent-Request-To-Users-Tab'){{__('active')}}@endif" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Sent Request To Users</item>
                        </div>                        
                    </div>
                </nav>    
            <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade @if(session('active-tab') != 'Sent-Request-To-Users-Tab'){{__('show active')}}@endif" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">

                                    @if(count($requestedMoneyFromAdmin)>0)
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Currency</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                           
                                            @foreach($requestedMoneyFromAdmin as $requestmoney)                                                                                           
                                                <tr>
                                                    <td>{{$requestmoney['date']}}</td>                                                   
                                                    <td class="rowamount">{{$requestmoney['amount']}}</td>
                                                    <td class="rowcurrency">{{$requestmoney['currency']}}</td>
                                                    <td>
                                                        @if($requestmoney['status'] == 2){{__('Complete')}}@elseif($requestmoney['status'] == 1){{__('Pending')}}@elseif($requestmoney['status'] == 3){{__('Rejected')}} @elseif($requestmoney['status'] == 4){{__('Cancel')}} @endif                                                      
                                                    </td>
                                                    <td>
                                                        @if($requestmoney['status'] == 1)
                                                        <div  class="btn icon-btn accept-btn acceptreqadmin" data-id='{{$requestmoney['id']}}'  data-toggle="modal" data-target="#edit"><span data-toggle="tooltip" data-placement="top" title="Edit!"><i class="far fa-edit"></i></span></div>                                                        
                                                        <div class="btn icon-btn reject-btn rejectreqtoadmin" data-id='{{$requestmoney['id']}}' data-toggle="modal" data-target="#rejected"><span data-toggle="tooltip" data-placement="top" title="Reject!"><i class="fa fa-times"></i></span></div>
                                                        <!--<div  class="btn icon-btn accept-btn acceptreqadmin" data-id='{{$requestmoney['id']}}'  data-toggle="modal" data-target="#edit"><i class="far fa-check-circle"></i></div>-->                                                        
                                                        <!--<div  class="btn icon-btn accept-btn acceptreq" data-id='{{$requestmoney['id']}}'  data-toggle="modal" data-target="#edit"><i class="far fa-check-circle"></i></div>-->                                                        
                                                        <!--<div class="btn icon-btn reject-btn rejectreqtoadmin" data-id='{{$requestmoney['id']}}' data-toggle="modal" data-target="#rejected"><i class="fas fa-ban"></i></div>-->
                                                        <!--<div class="btn icon-btn reject-btn rejectreq" data-id='{{$requestmoney['id']}}' data-toggle="modal" data-target="#rejected"><i class="fas fa-ban"></i></div>-->
                                                        @else
                                                        {{__('No Action')}}
                                                        @endif
                                                    </td>
                                                </tr> 
                                            
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
                    <div class="tab-pane fade @if(session('active-tab') == 'Sent-Request-To-Users-Tab'){{__('show active')}}@endif" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                         <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">

                                    @if(count($requestedMoneyFromUser)>0)
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th class="width_91">Date</th>
                                                <th class="width_130">Email</th>
                                                <th class="width_95">Name</th>
                                                <th class="width_95">Amount</th>
                                                <th class="width_95">Currency</th>
                                                <th class="width_95">Status</th>
                                                <th class="width_130">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                           
                                            
                                            @foreach($requestedMoneyFromUser as $requestmoney) 
                                                <tr>
                                                    <td>{{$requestmoney['date']}}</td>   
                                                    <td>{{$requestmoney['email']}}</td>   
                                                    <td>{{$requestmoney['name']}}</td>   
                                                    <td class="rowamount">{{$requestmoney['amount']}}</td>
                                                    <td class="rowcurrency">{{$requestmoney['currency']}}</td>
                                                    <td>
                                                        @if($requestmoney['status'] == 2){{__('Complete')}}@elseif($requestmoney['status'] == 1){{__('Pending')}}@elseif($requestmoney['status'] == 3){{__('Rejected')}} @elseif($requestmoney['status'] == 4){{__('Unregister User')}} @endif                                                      
                                                    </td>
                                                    <td>
                                                    @if(($requestmoney['status'] == 1) || ($requestmoney['status'] == 4))
                                                        <div  class="btn icon-btn accept-btn acceptreq" data-id='{{$requestmoney['id']}}'  data-toggle="modal" data-target="#edit"><span data-toggle="tooltip" data-placement="top" title="Edit!"><i class="far fa-edit"></i></span></div>                                                        
                                                        <div class="btn icon-btn reject-btn rejectreq" data-id='{{$requestmoney['id']}}' data-toggle="modal" data-target="#rejected"><span data-toggle="tooltip" data-placement="top" title="Reject"><i class="fa fa-times"></i></span></div>
                                                        @else
                                                        {{__('No Action')}} 
                                                        @endif
                                                    </td>
                                                </tr> 
                                              
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
    
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">   
            <div class="modal-header">
                <h4 class="modal-title text-center">Edit Request</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body text-center">                
                    <p class="text-center">@php echo config('constants.EditRequest'); @endphp</p>
            </div>        
            <div class="modal-body text-center">
                <form action="{{URL('/individual-sent-request/'.$user_id)}}" method="post" id="myformedit"> 
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
                <div class="form-group">
                            <input type="text" name="amount" value="" id="rowamount" class="form-control bg-white input-show {{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="Enter Amount">
                @if($errors->has('amount'))                                                
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span> 
                @endif
                            <ul class="account-list currency-list input-show">
                                <li>
                                    <div>
                                        <label class="l-radio"> 
                                            <span>USD</span>
                                            <input type="radio" name="balance_request" class="USD" value="1">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <label class="l-radio">                                
                                            <span>EUR</span>
                                            <input type="radio" name="balance_request" class="EURO" value="2">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                            </div>
                <input type="submit" name="brrmaction" value="Edit" class="showloader btn btn-primary round-btn text-center">
            </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-success">
    <div class="modal-dialog modal-md">
        <div class="modal-content">   
            <div class="modal-header">
                <h4 class="modal-title text-center">Edit Request</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body text-center">
                <p class="text-center">@php echo config('constants.EditRequestSuccess'); @endphp</p>
            </div>
            <div class="modal-body text-center">
                <button type="button" class="btn btn-primary round-btn text-center" data-dismiss="modal">OK</button>                
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="rejected">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Reject Request</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body text-center">
                    <p class="text-center">@php echo config('constants.RejectSentRequest'); @endphp</p>
            </div>        
            <div class="modal-body text-center">
                <form action="{{URL('/individual-sent-request/'.$user_id)}}" method="post" id="myformreject"> 
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="rejectrow" value="" class="form-control  {{ $errors->has('id') ? ' is-invalid' : '' }}">
                    @if($errors->has('userid'))                                                
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $errors->first('id') }}</strong>
                        </span> 
                    @endif
                    <input type="hidden" name="action" id="actionrow" value="3" class="form-control  {{ $errors->has('action') ? ' is-invalid' : '' }}">
                    @if($errors->has('action'))                                                
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $errors->first('action') }}</strong>
                        </span> 
                    @endif
                    <input type="submit" name="brrmaction" value="Reject" class="showloader btn btn-danger round-btn text-center">
                </form>
        </div>
        </div>
    </div>
</div> 
    <div class="modal fade " id="rejected-success">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Reject Request</h4>
                <button type="button" class="close" data-dismiss="modal">�</button>
            </div>
                <div class="modal-body text-center">
                    <p class="text-center">@php echo config('constants.RejectSentRequestSuccess'); @endphp</p>
                </div>
                <div class="modal-body text-center">
                    <button type="button" class="btn btn-primary round-btn text-center" data-dismiss="modal">OK</button>                
                </div>
        </div>
    </div>
</div> 
</section>
<script src="{{URL('/public/js/active_tab.js')}}" type="text/javascript"></script>
 <script>     
     $(document).ready(function(){
         jQuery.validator.addMethod("digits", function(value, element) {
        return this.optional(element) || /^[0-9]+$/i.test(value);
      }, "Number only please"); 
        $('#myformedit').validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            amount: {
                required: true,
                digits: true
            },
            balance_request:{
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
                amount: {
                    required: "Amount Required",
                    digits: "Number Allowed",
                },
                balance_request:{
                    required: "Select Currency",
                }
            }
        });
        
        $(document).on('click','.showloader',function(){
        if ($('#myformedit').valid()){
                $('.loader').show();
            }
        if ($('#myformreject').valid()){
                $('.loader').show();
            }    
        });
         $('[data-toggle="tooltip"]').tooltip();   
        $(document).on('click','.rejectreq',function(){
            $('#rejectrow').val($(this).data('id'));
         });
         $(document).on('click','.rejectreqtoadmin',function(){
            $('#rejectrow').val($(this).data('id'));
            $('#actionrow').val('4');
         });
         $(document).on('click','.acceptreq',function(){
            $('#rowamount').val($(this).parent('td').siblings('td.rowamount').text());
            $('#acceptrow').val($(this).data('id'));
            $('input[name=balance_request].'+$(this).parent('td').siblings('td.rowcurrency').text()).attr('checked','checked');
         });
         $(document).on('click','.acceptreqadmin',function(){
            $('input[name=action]').val('1'); 
            $('#rowamount').val($(this).parent('td').siblings('td.rowamount').text());
            $('#acceptrow').val($(this).data('id'));
            $('input[name=balance_request].'+$(this).parent('td').siblings('td.rowcurrency').text()).attr('checked','checked');
         });
     });     
 </script>
 <script>
     $(document).ready(function(){
        @if (session('status'))
            @if(session('status') == 'edit')
                    $("#edit-success").modal('show');
            @elseif(session('status') == 'addbalance')       
                    $('#addbalance').modal('show'); 
            @elseif(session('status') == 'rejected')       
                    $('#rejected-success').modal('show'); 
            @else
                    $('#request').modal('show');
            @endif
        @endif
     });
</script>
   <script>
$('#edit, #rejected').on({'mousewheel': function(e) 
    {
    if (e.target.id == 'el') return;
    e.preventDefault();
    e.stopPropagation();
   }
});

</script>
@endsection