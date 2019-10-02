@extends('layouts.admin')
@section('content')
<div class="slim-mainpanel">
    <div class="container-fluid">
        <div class="slim-pageheader">            
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL('/admin')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">KYC Approval Request</li>
            </ol>
            <h6 class="slim-pagetitle">KYC Business Approval Request</h6>
        </div>
         @if (session('status'))
                                <div class=" main_alert alert alert-success alert-dismissible"> 
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('status') }}
                                </div>
                            @endif
        <!--<div class="alert alert-success statusmsg" style="display:none;width: 40%;margin: 0 auto;top: -49px;margin-bottom: -40px;">Updated Successfully.</div>-->
        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="nav nav-tabs custom-tabs" id="nav-tab" role="tablist">
                        <item class="nav-item nav-link active" id="nav-pending-tab" data-toggle="tab" href="#pending" role="tab" >Pending</item>
                        <item class="nav-item nav-link" id="nav-approval-tab" data-toggle="tab" href="#approved" role="tab" >Approved</item>
                        <item class="nav-item nav-link" id="nav-rejected-tab" data-toggle="tab" href="#rejected" role="tab" >Rejected</item>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content custom-content" id="nav-tabContent">                        
                        <div id="pending" class="tab-pane  active">
                            <div class="table-responsive">
                                @if(count($BusinessDetailsPending)>0)     
                                <table class="table table-hover mg-b-0 table-primary text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Business Name</th>
                                            <td>Business Type</td>
                                            <th>DOB</th>
                                            <th>Date</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($BusinessDetailsPending as $busiDetailspending)    
                                        <tr>
                                            <th class="text-left" scope="row">{{decrypt($busiDetailspending->business_name)}}</th>
                                            <td>{{decrypt($busiDetailspending->business_type)}}</td>
                                            <td>{{decrypt($busiDetailspending->dob)}}</td>
                                            <td>{{date('j/m/Y', strtotime($busiDetailspending->created_at))}}</td>
                                            <td>{{decrypt($busiDetailspending->town_or_city)}}</td>                                           
                                            <td>{{decrypt($busiDetailspending->country)}}</td>
                                            <td>{{$busiDetailspending->email}}</td>                                            
                                            <td class="action-btns text-center">
                                            <button id="{{encrypt($busiDetailspending->user_id)}}" class="btn btn-primary btn-icon verifyByadmin activetab" data-currenttabchild="2" status="1" data-toggle="modal" data-target="#exampleModal"><div><i class="icon ion-checkmark"></i></div></button> 
                                            <button id="{{encrypt($busiDetailspending->user_id)}}" class="btn btn-danger btn-icon verifyByadmin activetab" data-currenttabchild="3" status="2" data-toggle="modal" data-target="#rejectModal"><div><i class="icon ion-close"></i></div></button> 
<!--                                                <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Approved">
                                                    <div>
                                                        <i class="icon ion-checkmark"></i>
                                                    </div>
                                                </a> 
                                                <a href="#" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Reject">
                                                    <div>
                                                        <i class="icon ion-close"></i>
                                                    </div>
                                                </a>-->
                                            </td>
                                        </tr> 
                                        @endforeach       
                                    </tbody>
                                </table>
                                @else
                                <h1 class="text-center">No Record Found</h1>
                                @endif
                            </div>
                        </div>
                        <div id="approved" class="tab-pane">
                            <div class="table-responsive">                                
                                @if(count($BusinessDetailsApproved)>0)     
                                <table class="table table-hover mg-b-0 table-primary text-center">
                                    <thead>
                                        <tr class="text-left">
                                            <th>Business Name</th>
                                            <th>Business Type</th>
                                            <th>DOB</th>
                                            <th>Date</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Email</th>    
                                            <th colspan="2">Fees / Action</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($BusinessDetailsApproved as $busiDetailsApp)   
                                        <tr class="text-left">
                                            <th class="text-left" scope="row">{{decrypt($busiDetailsApp->business_name)}}</th>
                                            <td>{{decrypt($busiDetailsApp->business_type)}}</td>
                                            <td>{{decrypt($busiDetailsApp->dob)}}</td>
                                            <td>{{date('j/m/Y', strtotime($busiDetailsApp->created_at))}}</td>
                                            <td>{{decrypt($busiDetailsApp->town_or_city)}}</td>
                                            <td>{{decrypt($busiDetailsApp->country)}}</td>
                                            <td>{{$busiDetailsApp->email}}</td>
                                            <td> @if($busiDetailsApp->fees == 1){{__('% Default')}}@elseif($busiDetailsApp->fees == 2){{__('Flat Default')}}@else{{__('Set')}}@endif</td>
                                            <td><a class="btn btn-primary btn-icon editfees" id="{{encrypt($busiDetailsApp->user_id)}}"><div><i class="icon ion-edit"></i></div></a></td>
                                        </tr>
                                       @endforeach    
                                    </tbody>
                                </table>
                                @else
                                <h1 class="text-center">No Record Found</h1>
                                @endif
                            </div>
                        </div>
                        <div id="rejected" class="tab-pane">
                            <div class="table-responsive">
                                @if(count($BusinessDetailsRejected)>0)     
                                <table class="table table-hover mg-b-0 table-primary text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Business Name</th>
                                            <th>Business Type</th>
                                            <th>DOB</th>
                                            <th>Date</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Email</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($BusinessDetailsRejected as $busiDetailsRej)   
                                        <tr>
                                            <th class="text-left" scope="row">{{decrypt($busiDetailsRej->business_name)}}</th>
                                            <td>{{decrypt($busiDetailsRej->business_type)}}</td>
                                            <td>{{decrypt($busiDetailsRej->dob)}}</td>
                                            <td>{{date('j/m/Y', strtotime($busiDetailsRej->created_at))}}</td>
                                            <td>{{decrypt($busiDetailsRej->town_or_city)}}</td>
                                            <td>{{decrypt($busiDetailsRej->country)}}</td>
                                            <td>{{$busiDetailsRej->email}}</td>
                                        </tr>
                                       @endforeach    
                                    </tbody>
                                </table>
                                @else
                                <h1 class="text-center">No Record Found</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>   
<!-- Modal -->
<div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fees Model</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="divloader"></div>
          <form id="penddinguser" method="post" action="{{URL('/BusinessVerifyUserByAdmin')}}">
              {{csrf_field()}}
        <div class="form-group">  
            <input type="hidden" name="id" id="user-id">
            <input type="hidden" name="status_val" id="user-status">
        </div>  
        <div class="form-group" id="editfees">  
            <select class="form-control" name="selcharge">
                <option value="1" selected>% Default</option>
                <option value="2">Flat Default</option>
                <option value="3">Set</option>
            </select>
            
            <div id="charge">            
            @if(count($defaultTCharge) > 0)
            
            @foreach($defaultTCharge as $value)
            
            @if($value->transaction_type == 1)            
            <div class="form-group">
                <label class="col-form-label">Request Fees: {{$value->charge}}%</label>
            </div>
            @elseif($value->transaction_type == 2)
            <div class="form-group">
                <label class="col-form-label">Invoice Fees: {{$value->charge}}%</label>
            </div>
            @elseif($value->transaction_type == 3)
            <div class="form-group">
                <label class="col-form-label">Currency Converter Fees: {{$value->charge}}%</label>
            </div>  
            @endif
            @endforeach
            @endif
        </div>
        </div>      
      </div>
      <div class="modal-footer">        
        <button type="submit" class="btn btn-primary">Add Fees</button>
      </div>
    </form>  
    </div>
  </div>
</div>
<div class="modal fade" id="rejectModal" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fees Model</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="divloader"></div>
          <p>Are You Sure Want to Reject User.</p>
          <form method="post" action="{{URL('/BusinessVerifyUserByAdmin')}}">
              {{csrf_field()}}              
        <div class="form-group">  
            <input type="hidden" name="id" id="reject-user-id">
            <input type="hidden" name="status_val" id="reject-user-status">
            <input type="hidden" name="reject" value="1">
        </div>  
      
      <div class="modal-footer">        
        <button type="submit" class="btn btn-primary">Reject</button>
      </div>
    </form>
    </div>      
    </div>
  </div>
</div>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script src="{{URL('/public/js/active_tab.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
//    $('.myform').each(function(){
        $('#penddinguser').validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            requestfees: {
                required: true
            },
            invoicefees: {
                required: true
            },
            currencyconverterfees:{
                required: true,
            },
            setcharge:{
                required: true,
            },
            selcharge:{
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
            requestfees: {
                required: "Request Fees Required",
            },
            invoicefees: {
                required: "Invoice Fees Required",
            },
            currencyconverterfees:{
                required: "Currency Converter Fees Required",
            }
            }
            //        }
    });
//    });
});
    $(document).on('click', '.verifyByadmin', function (event) {
        if($(this).attr('status') != 2){
               $('#user-id').val($(this).attr('id'));  
               $('#user-status').val($(this).attr('status'));    
           }else{
               $('#reject-user-id').val($(this).attr('id'));  
               $('#reject-user-status').val($(this).attr('status'));    
           } 
    });
    $(document).on('change','select[name=selcharge]',function(e){
        $('.divloader').show();
        var optionSelected = $("option:selected", this);                
        var optionval = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'admin-ajax-request-fees',            
            type:'Post',            
            data:{selectedoption:optionval},            
            success:function(responce){
                $('.divloader').hide();
                $('#charge').html(responce);
            }
        });        
    });
    $(document).on('click','.editfees',function(event){
        $('#user-id').val($(this).attr('id'));
        $('#user-status').val('3');    
        $('.divloader').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'admin-ajax-request-feesedit',            
            type:'Post',            
            data:{editfeesid:$(this).attr('id')},            
            success:function(responce){
                $('.divloader').hide();
                $('#exampleModal').modal('show');
                $('#editfees').html(responce);
            }
        });       
    });
</script>
@endsection