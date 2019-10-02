@extends('layouts.admindashboard')
@section('content')
<style>
    .tab-content{min-height: 380px;}
    .verify{
        float: left !important;
        margin-left: -5px;
        padding: 8px;
        border-radius: 15px;
        margin-right: 8px;
    }
    .reject{
        padding: 8px;
        border-radius: 15px;
    }
</style>
<section id="tabs">
    <div class="">		
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                <nav>
                    <div class="container pd0 position-relative">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Individual </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Business</a>
                        </div>                        
                    </div>
                </nav>
                <div class="alert alert-success statusmsg" style="display:none;width: 50%;margin: 0 auto;top: 10px;">Updated Successfully.</div>
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">                                    
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($IndividualDetails as $indiDetails)
                                            <tr class="">                                               
                                                <td>{{decrypt($indiDetails->fname)}}</td>
                                                <td>{{date('j-F-Y', strtotime($indiDetails->created_at))}}</td>
                                                <td>{{$indiDetails->email}}</td>
                                                <td class="red-text">
                                                    @if(($indiDetails->admin_verify)==1)
                                                    Verified
                                                    @elseif(($indiDetails->admin_verify)==2)
                                                    Reject
                                                    @else
                                                    Non Verified
                                                    @endif 
                                                </td>
                                                <td>                                                
                                                    <button id="{{encrypt($indiDetails->user_id)}}" class="verify btn dark-btn round-btn hvr-sweep-to-top verifyByadmin" status="1">Verified</button>  
                                                    <button id="{{encrypt($indiDetails->user_id)}}" class="reject btn dark-btn round-btn hvr-sweep-to-top verifyByadmin" status="2">Reject</button> 
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">                                    
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($BusinessDetails as $busiDetails)
                                            <tr class="">                                                
                                                <td>{{decrypt($busiDetails->fname)}}</td>
                                                <td>{{date('j-F-Y', strtotime($busiDetails->created_at))}}</td>
                                                <td>{{$busiDetails->email}}</td>
                                                <td class="red-text">
                                                    @if(($busiDetails->admin_verify)==1)
                                                    Verified
                                                    @elseif(($busiDetails->admin_verify)==2)
                                                    Reject
                                                    @else
                                                    Non Verified
                                                    @endif </td>
                                                <td>
                                                    <button id="{{encrypt($busiDetails->user_id)}}" class="verify btn dark-btn round-btn hvr-sweep-to-top verifyByadmin" status="1">Verified</button>  
                                                    <button id="{{encrypt($busiDetails->user_id)}}" class="reject btn dark-btn round-btn hvr-sweep-to-top verifyByadmin" status="2">Reject</button> 
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
</section>
<script>
    $(document).on('click', '.verifyByadmin', function (event) {
        event.preventDefault();        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).attr('id');  
        var status_val = $(this).attr('status');
        
        $.ajax({
            url: '/VerifyUserByAdmin',
            type: 'post',
            data: {id: id,status_val:status_val},
            success: function () {
               $('.statusmsg').show();
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