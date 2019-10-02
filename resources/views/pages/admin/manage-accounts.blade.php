@extends('layouts.admin')
@section('content')
    <div class="slim-mainpanel">
      	<div class="container-fluid">
	        <div class="slim-pageheader">
	          <ol class="breadcrumb slim-breadcrumb">
	            <li class="breadcrumb-item"><a href="{{URL('/admin')}}">Home</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Manage Accounts</li>
	          </ol>
	          <h6 class="slim-pagetitle">Manage Accounts</h6>
	        </div>
                            @if (session('status'))
                                <div class=" main_alert alert alert-success alert-dismissible"> 
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('status') }}
                                </div>
                            @endif
	        <div class="section-wrapper">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="nav nav-tabs custom-tabs" id="nav-tab" role="tablist">
                                <item class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#individual" role="tab" aria-controls="nav-home" aria-selected="true">Individual</item>
                                <item class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#business" role="tab" aria-controls="nav-profile" aria-selected="false">Business</item>
                            </div>                            
                            <!-- Tab panes -->
                            <div class="tab-content custom-content" id="nav-tabContent">
                                <div id="individual" class="tab-pane active">
                                    <div class="table-responsive">
                                        <table class="table table-hover mg-b-0 table-primary text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Name</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>State</th>
                                                    <th>Country</th>
                                                    <th colspan="2">Fees / Action</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($IndividualUser))
                                                @foreach($IndividualUser as $induser)
                                                <tr>
                                                    <th class="text-left" scope="row">{{decrypt($induser->fname)}}</th>
                                                    <td>{{$induser->email}}</td>
                                                    <td>{{decrypt($induser->add_line_one),decrypt($induser->add_line_two)}}</td>
                                                    <td>{{decrypt($induser->state)}}</td>
                                                    <td>{{decrypt($induser->country)}}</td>
                                                    <td>@if($induser->fees == 1){{__('% Default')}}@elseif($induser->fees == 2){{__('Flat Default')}}@else{{__('Set')}}@endif</td>
                                                    <td><a class="btn btn-primary btn-icon editfees" id="{{encrypt($induser->user_id)}}"><div><i class="icon ion-edit"></i></div></a></td>
                                                    <td class="action-btns text-center">
                                                        <a href="{{URL('/manage-accounts/'.encrypt($induser->user_id))}}" class="btn btn-info viewaccounts activetab" data-currenttabchild="1">View</a> 
                                                        <form action="{{URL('/manage-accounts/'.$induser->user_id)}}" method="post">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="_method" value="PUT"/>     
                                                            <input type="hidden" name="role" value="1">
                                                        @if($induser->account_status == 1)                                                        
                                                        <input hidden="hidden" name="status" value="2">
                                                        <button type="submit" class="btn btn-danger activetab" data-currenttabchild="1" name="delete" class="activted">
                                                                Active
                                                            </button> 
                                                        @else
                                                        <input hidden="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-primary activetab" data-currenttabchild="1" name="active" class="delete">
                                                                Deactive
                                                            </button>
                                                        @endif                                                        
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="business" class="tab-pane">
                                    <div class="table-responsive">
                                        <table class="table table-hover mg-b-0 table-primary text-center">
                                          <thead>
                                                <tr>
                                                    <th class="text-left">Business Name</th>
                                                    <th>Business Type</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>State</th>
                                                    <th>Country</th>
                                                    <th colspan="2">Fees / Action</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($BusinessUser))
                                                @foreach($BusinessUser as $buiuser)
                                                <tr>
                                                    <th class="text-left" scope="row">{{decrypt($buiuser->business_name)}}</th>
                                                    <td>{{decrypt($buiuser->business_type)}}</td>
                                                    <td>{{decrypt($buiuser->fname)}}</td>
                                                    <td>{{$buiuser->email}}</td>
                                                    <td>{{decrypt($buiuser->add_line_one),decrypt($buiuser->add_line_two)}}</td>
                                                    <td>{{decrypt($buiuser->state)}}</td>
                                                    <td>{{decrypt($buiuser->country)}}</td>
                                                    <td>@if($buiuser->fees == 1){{__('% Default')}}@elseif($buiuser->fees == 2){{__('Flat Default')}}@else{{__('Set')}}@endif</td>
                                                    <td><a class="btn btn-primary btn-icon editfees" id="{{encrypt($buiuser->user_id)}}"><div><i class="icon ion-edit"></i></div></a></td>
                                                    <td class="action-btns text-center">
                                                        <a href="{{URL('/manage-accounts/'.encrypt($buiuser->user_id))}}" class="btn btn-info viewaccounts activetab" data-currenttabchild="2">View</a>
                                                        <form action="{{URL('/manage-accounts/'.$buiuser->user_id)}}" method="post">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="_method" value="PUT"/>     
                                                            <input type="hidden" name="role" value="2">
                                                        @if($buiuser->account_status == 1)                                                        
                                                        <input hidden="hidden" name="status" value="2">
                                                        <button type="submit" class="btn btn-danger activetab" data-currenttabchild="2" name="delete" class="activted">
                                                                Active
                                                            </button> 
                                                        @else
                                                        <input hidden="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-primary activetab" data-currenttabchild="2" name="active" class="delete">
                                                                Deactive
                                                            </button>
                                                        @endif                                                        
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                               @endif 
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
       	 	</div>
      	</div>
    </div>    
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
          <form id="penddinguser" method="post" action="{{URL('/feeedit')}}">
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
      <div class="modal-footer">        
        <button type="submit" class="btn btn-primary">Add Fees</button>
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
    });
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
