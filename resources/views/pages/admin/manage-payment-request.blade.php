@extends('layouts.admin')
@section('content')

<div class="slim-mainpanel">
      	<div class="container-fluid">
	        <div class="slim-pageheader">
	          <ol class="breadcrumb slim-breadcrumb">
	            <li class="breadcrumb-item"><a href="{{URL('/admin')}}">Home</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Request Money</li>
	          </ol>
                    <div class="alert alert-success statusmsg" style="display:none;width: 50%;margin: 0 auto;top: 10px;"></div>
	          <h6 class="slim-pagetitle">Request Money</h6>
	        </div>
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
                                                    <th>Amount</th>
                                                    <th>Bank</th>
                                                    <th>Reference Code</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($IndividualPaymentRequest as $indiPayDetails)  
                                                <tr>
                                                    <th class="text-left" scope="row">{{decrypt($indiPayDetails->fname)}}</th>
                                                    <td>{{$indiPayDetails->email}}</td>
                                                    <td>
                                                        {{decrypt($indiPayDetails->balance)}} 
                                                        @if(decrypt($indiPayDetails->currency_requested)==1)
                                                        (USD)
                                                        @else
                                                        (EUR)                                                    
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{decrypt($indiPayDetails->bank_name)}} 
                                                    </td>
                                                     <td>
                                                        {{decrypt($indiPayDetails->refcode)}} 
                                                    </td>
                                                    <td>{{date('j-F-Y', strtotime($indiPayDetails->created_at))}}</td>
                                                    <td class="action-btns text-center">
                                                        @if($indiPayDetails->admin_action==1)
                                                            <button id="{{encrypt($indiPayDetails->id)}}" class="verify btn btn-primary btn-icon verifyreqadmin activetab" data-currenttabchild="1" data-toggle="tooltip" data-placement="top" title="Approved" status="2"><div>
                                                                <i class="icon ion-checkmark"></i>
                                                            </div></button> 
                                                            <button id="{{encrypt($indiPayDetails->id)}}" class="reject btn btn-danger btn-icon verifyreqadmin activetab" data-currenttabchild="1" data-toggle="tooltip" data-placement="top" title="Reject" status="3"><div>
                                                                <i class="icon ion-close"></i>
                                                            </div></button>
                                                            @elseif($indiPayDetails->admin_action==2)
                                                            Approved
                                                            @elseif($indiPayDetails->admin_action==3)
                                                            Reject
                                                            @else
                                                            Cancel
                                                            @endif 
                                                    </td>
                                                </tr>
                                                @endforeach
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
                                                    <th>Email</th>
                                                    <th>Amount</th>
                                                    <th>Bank</th>
                                                    <th>Reference Code</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($BusinessPaymentRequest as $busiPayDetails)  
                                            <tr>
                                                <th class="text-left" scope="row">{{decrypt($busiPayDetails->fname)}}</th>
                                                    <td>{{decrypt($busiPayDetails->business_type)}}</td>
                                                <td>{{$busiPayDetails->email}}</td>
                                                <td>
                                                    {{decrypt($busiPayDetails->balance)}} 
                                                    @if(decrypt($busiPayDetails->currency_requested)==1)
                                                    (USD)
                                                    @else
                                                    (EUR)                                                    
                                                    @endif
                                                </td>
                                                <td>
                                                        {{decrypt($busiPayDetails->bank_name)}} 
                                                    </td>
                                                     <td>
                                                        {{decrypt($busiPayDetails->refcode)}} 
                                                    </td>
                                                <td>{{date('j-F-Y', strtotime($busiPayDetails->created_at))}}</td>
                                                <td class="action-btns text-center">
                                                    @if($busiPayDetails->admin_action==1)
                                                    <button id="{{encrypt($busiPayDetails->id)}}" class="verify btn btn-primary btn-icon verifyreqadmin activetab" data-currenttabchild="2" data-toggle="tooltip" data-placement="top" title="Approved" status="2"><div>
                                                        <i class="icon ion-checkmark"></i>
                                                    </div></button> 
                                                    <button id="{{encrypt($busiPayDetails->id)}}" class="reject btn btn-danger btn-icon verifyreqadmin activetab" data-currenttabchild="2" data-toggle="tooltip" data-placement="top" title="Reject" status="3"><div>
                                                        <i class="icon ion-close"></i>
                                                    </div></button>
                                                    @elseif($busiPayDetails->admin_action==2)
                                                    Approved
                                                    @elseif($busiPayDetails->admin_action==3    )
                                                    Reject
                                                    @else
                                                    Cancel
                                                    @endif                                                    
                                                </td>
                                            </tr>                                            
                                            @endforeach 
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
<script src="{{URL('/public/js/active_tab.js')}}" type="text/javascript"></script>
<script>
    $(document).on('click', '.verifyreqadmin', function (event) {
        event.preventDefault();  
        $('.loader').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).attr('id');  
        var status_val = $(this).attr('status');
        
        $.ajax({
            url: '{{URL("/payment-request-admin")}}',
            type: 'post',
            data: {id: id,status_val:status_val},
            success: function (data) {  
                $('.loader').hide();
               if(data == 2){
                   $('.statusmsg').show();
                   $('.statusmsg').text('Approved Successfully.');   
               }else if(data == 3){
                   $('.statusmsg').show();
                   $('.statusmsg').text('Rejected Successfully.');
               }else{
                   $('.statusmsg').text(data);
               }
                $(".statusmsg").fadeTo(3000, 500).slideUp(500, function () {
                    $(".statusmsg").slideUp(500);               
                setTimeout($('#statusmsg').modal('hide'), 20000);
                    location.reload();
                });
            },
            error: function () {
                console.log("ajax call went wrong:");
            },
        });
    });
</script>
@endsection