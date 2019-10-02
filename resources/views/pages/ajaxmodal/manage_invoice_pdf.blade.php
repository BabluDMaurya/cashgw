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
                                                <th>Date</th>
                                                <th>Invoice</th>
                                                <th>Recipient</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="activitydata">
                                            @if(count($activites) > 0)                                            
                                            @foreach($activites as $activity)                                                
                                            <tr>
                                                <td>{{$activity->updated_at}}</td>
                                                <td>{{$activity->invoice_number}}</td>
                                                <td>{{$activity->bill_to_email}}</td>
                                                <td>@if($activity->invoice_status == 1){{__('Draft')}}@elseif($activity->invoice_status == 2){{__('Scheduled')}} @elseif($activity->invoice_status == 3){{__('Unpaid')}}@elseif($activity->invoice_status == 4){{__('Cancelled')}}@elseif($activity->invoice_status == 5){{__('Paid')}}@else {{__('NA')}} @endif</td>
                                                <td>{{$activity->invoice_grand_total}} @if($activity->currency == 1){{__('$')}} @else {{__('€')}} @endif</td>                                                
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