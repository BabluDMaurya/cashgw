@extends('layouts.pdf')
@section('content')
<style>
html{
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
}
.block-item.shadow-block {
    padding: 20px 20px 10px;
}
</style>
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">                                      
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>
                                                <th width="120px">Transaction ID</th>
                                                <th>Date</th>
                                                <th width="120px">Type</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Balance</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="activitydata">
                                            <tr>
                                                <td colspan="11">First @if(count($activites) > 0){{count($activites)}} @else {{0}} @endif Transactions</td>
                                            </tr>
                                            @if(count($activites) > 0)                                            
                                            @foreach($activites as $activity)
                                                
                                            <tr>
                                                <td>{{$activity->transactionid}}</td>
                                                <td>{{$activity->updated_at}}</td>
                                                <td>@if($activity->type == 1){{__('Sent Money')}} @elseif($activity->type == 2) {{__('Request Money')}} @elseif($activity->type == 3) {{__('Recived Money')}} @elseif($activity->type == 4) {{__('Curency Conversion')}} @elseif($activity->type == 5) {{__('Sent Invoice')}} @elseif($activity->type == 6) {{__('Recive Invoice')}} @elseif($activity->type == 7) {{__('Paid Invoice')}} @endif</td>
                                                <td>{{$activity->name}}</td>
                                                <td>{{$activity->email}}</td>
                                                <td>@if($activity->status == 2){{__('Completed')}} @else {{__('Pending')}} @endif</td>
                                                <td>{{$activity->balance}} @if($activity->currency == 1){{__('$')}} @else {{__('€')}} @endif</td>
                                                <td>{{$activity->descriptions}}</a></td>
                                                <td >@if($activity->archieve == 1){{__('Archieve')}} @else {{__('Unarchieve')}} @endif</td>
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
</section>
@endsection