@extends('layouts.admin')
@section('content')
<div class="slim-mainpanel">
    <div class="container-fluid">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL('/admin')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Primary Address Approval</li>
            </ol>
            <h6 class="slim-pagetitle">Primary Address Approval</h6>
        </div>
        <div class="alert alert-success approvemsg" style="display:none;width: 40%;margin: 0 auto;top: -49px;margin-bottom: -40px;">Address Approved Successfully.</div>
        <div class="alert alert-danger rejectmsg" style="display:none;width: 40%;margin: 0 auto;top: -49px;margin-bottom: -40px;">Address Rejected Successfully.</div>
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
                                @if(count($IndividualPrimaryAddressDetails)>0)     
                                <table class="table table-hover mg-b-0 table-primary text-center">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Date</th>
                                            <th>Address line 1</th>
                                            <th>Address line 2</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($IndividualPrimaryAddressDetails as $indipriaddvalues)                                            
                                            <tr class="">                                               
                                                <td>{{decrypt($indipriaddvalues->fname)}} {{decrypt($indipriaddvalues->lname)}}</td>
                                                <td>{{$indipriaddvalues->email}}</td>
                                                <td>{{date('j-F-Y', strtotime($indipriaddvalues->created_at))}}</td>
                                                <td>{{decrypt($indipriaddvalues->add_line_one)}}</td>
                                                <td>{{decrypt($indipriaddvalues->add_line_two)}}</td>                                                
                                                <td class="btn_pad approve_btn">
                                                @if($indipriaddvalues->admin_status==1)
                                                Approved
                                                <button id="{{encrypt($indipriaddvalues->id)}}" class="viewaddress btn btn-primary btn-icon  btn_wid_40 ml-10"><span data-toggle="tooltip" data-placement="top" title="view!"><div class="position-relative "><i class="fa fa-eye" aria-hidden="true"></i></div></span></button>
                                                @elseif($indipriaddvalues->admin_status==2) 
                                                Rejected
                                                <button id="{{encrypt($indipriaddvalues->id)}}" class="viewaddress btn btn-primary btn-icon  btn_wid_40 ml-10"><span data-toggle="tooltip" data-placement="top" title="view!"><div class="position-relative "><i class="fa fa-eye" aria-hidden="true"></i></div></span></button>
                                                @else
                                                <button id="{{encrypt($indipriaddvalues->id)}}" class="viewaddress btn btn-primary btn-icon btn_wid_40 ml-10 activetab" data-currenttabchild="1"><span data-toggle="tooltip" data-placement="top" title="view!"><div class="position-relative "><i class="fa fa-eye" aria-hidden="true"></i></div></span></button>
                                                <button data-role="1" data-statuschangeid="{{encrypt($indipriaddvalues->id)}}" id="{{encrypt($indipriaddvalues->user_id)}}" class="btn btn-primary btn-icon approveByadmin btn_wid_40 ml-10 activetab" data-currenttabchild="1" status="1"><span data-toggle="tooltip" data-placement="top" title="view!"><div><i class="icon ion-checkmark"></i></div></span></button>  
                                                <button data-role="1" data-statuschangeid="{{encrypt($indipriaddvalues->id)}}" id="{{encrypt($indipriaddvalues->user_id)}}" class="btn-danger btn-icon approveByadmin btn_wid_40 ml-10 activetab" data-currenttabchild="1" status="2"><span data-toggle="tooltip" data-placement="top" title="view!"><div><i class="icon ion-close"></i></div></span></button> 
                                                @endif
                                               </td>
                                            </tr> 
                                        @endforeach                                    
                                    </tbody>
                                </table>
                                @else
                                <h1 class="text-center">No Record Found.</h1>
                                @endif
                            </div>
                        </div>
                        <div id="business" class="tab-pane">
                            <div class="table-responsive">
                                @if(count($BusinessPrimaryAddressDetails)>0)     
                                <table class="table table-hover mg-b-0 table-primary text-center">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Business Name</th>
                                            <th>Date</th>
                                            <th>Address line 1</th>
                                            <th>Address line 2</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($BusinessPrimaryAddressDetails as $busipriaddvalues)                                            
                                            <tr class="">                                               
                                                <td>{{decrypt($busipriaddvalues->fname)}} {{decrypt($busipriaddvalues->lname)}}</td>
                                                <td>{{$busipriaddvalues->email}}</td>
                                                <td>{{decrypt($busipriaddvalues->business_name)}}</td>
                                                <td>{{date('j-F-Y', strtotime($busipriaddvalues->created_at))}}</td>
                                                <td>{{decrypt($busipriaddvalues->add_line_one)}}</td>
                                                <td>{{decrypt($busipriaddvalues->add_line_two)}}</td>                                                
                                                <td class="btn_pad approve_btn">  
                                                @if($busipriaddvalues->admin_status==1)
                                                Approved
                                                <button id="{{encrypt($busipriaddvalues->id)}}" class="viewaddress btn btn-primary btn-icon btn_wid_40 ml-10"><span data-toggle="tooltip" data-placement="top" title="view!"><div class="position-relative"><i class="fa fa-eye" aria-hidden="true"></i></div></span></button>
                                                @elseif($busipriaddvalues->admin_status==2) 
                                                Rejected
                                                <button id="{{encrypt($busipriaddvalues->id)}}" class="viewaddress btn btn-primary btn-icon btn_wid_40 ml-10"><span data-toggle="tooltip" data-placement="top" title="view!"><div class="position-relative"><i class="fa fa-eye" aria-hidden="true"></i></div></span></button>
                                                @else
                                                <button id="{{encrypt($busipriaddvalues->id)}}" class="viewaddress btn btn-primary btn-icon btn_wid_40 ml-10 activetab" data-currenttabchild="2"><span data-toggle="tooltip" data-placement="top" title="view!"><div class="position-relative"><i class="fa fa-eye" aria-hidden="true"></i></div></span></button>
                                                    <button data-role="2" data-statuschangeid="{{encrypt($busipriaddvalues->id)}}" id="{{encrypt($busipriaddvalues->user_id)}}" class="btn btn-primary btn-icon approveByadmin btn_wid_40 ml-10 activetab" data-currenttabchild="2" status="1"><span data-toggle="tooltip" data-placement="top" title="Approve!"><div><i class="icon ion-checkmark"></i></div></span></button>  
                                                    <button data-role="2" data-statuschangeid="{{encrypt($busipriaddvalues->id)}}" id="{{encrypt($busipriaddvalues->user_id)}}" class="btn-danger btn-icon approveByadmin btn_wid_40 ml-10 activetab" data-currenttabchild="2" status="2"><span data-toggle="tooltip" data-placement="top" title="Reject!"><div><i class="icon ion-close"></i></div></span></button> 
                                                @endif
                                                </td>
                                            </tr> 
                                        @endforeach  
                                    </tbody>
                                </table>
                                @else
                                <h1 class="text-center">No Record Found.</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade " id="view-address">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Address for Approval</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">�</span>
        </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="ViewUserAddressDiv"></div>               
            </div>
        </div>
    </div>
</div>
<script src="{{URL('/public/js/active_tab.js')}}" type="text/javascript"></script>
<script>
$(document).on('click', '.viewaddress', function (event) {
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).attr('id');
        //alert(id);
        $.ajax({
            url: '/viewaddressforapproval',
            type: 'post',
            data: {id: id},
            success: function (data) {
                $('.ViewUserAddressDiv').html(data);
                $('#view-address').modal('show');
            },
            error: function () {
                console.log("ajax call went wrong:");
            },
        });
    });
        
     $(document).on('click', '.approveByadmin', function (event) {
        event.preventDefault();        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var user_id = $(this).attr('id');  
        var status_val = $(this).attr('status'); 
        var id = $(this).data('statuschangeid');   
        var role = $(this).data('role'); 
         $(".loader").show();
        $.ajax({
            url: '/AppOrRejectAddressByAdmin',
            type: 'post',
            data: {id:id,user_id: user_id,status_val:status_val,role:role},
            success: function (result) {
                $(".loader").fadeOut(1000);
                if(result==1){ 
                $('.approvemsg').show();
                $(".approvemsg").fadeTo(3000, 500).slideUp(500, function () {
                    $(".approvemsg").slideUp(500);
               
                setTimeout($('#approvemsg').modal('hide'), 20000);
                    location.reload();
                });
                }else{
                $('.rejectmsg').show();
                $(".rejectmsg").fadeTo(3000, 500).slideUp(500, function () {
                    $(".rejectmsg").slideUp(500);
               
                setTimeout($('.rejectmsg').modal('hide'), 20000);
                    location.reload();
                });
                }
                
            },
            error: function () {
                console.log("ajax call went wrong:");
            },
        });
    });
</script>
@endsection