@extends('layouts.businessdashboard')
@section('content')
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">              
                <div class="main-content">
            <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">                                       
                         <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="display_flex_end filter-sec manage_invoice_btn">                                        
                                        <a href="{{URL('/business-manage-invoice/'.$user_id)}}" class="btn btn-primary round-btn text-right" > Manage Invoice</a>
                                    </div>
                                    @if(count($recieved_invoice_data) > 0)
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th>Invoice Date</th>
                                                <th>Invoice Number</th>
                                                <th>Sender Email</th>
                                                <th>Grand Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                            @foreach($recieved_invoice_data as $invoicedata)  
                                                <tr>
                                                    <td>{{$invoicedata['invoice_date']}}</td>
                                                    <td>{{$invoicedata['invoice_number']}}</td>
                                                    <td>{{$invoicedata['email_id']}}</td>
                                                    <td>{{$invoicedata['invoice_grand_total']}}</td>
                                                    <td>@if($invoicedata['invoice_status'] != 5){{__('Pending')}}@else{{__('Paid')}}@endif</td>
                                                    <td><a class="showlink" href="@if($invoicedata['invoice_status'] != 5){{URL('/business-pay-invoice/'.encrypt($invoicedata['id']))}}@else{{__('#')}}@endif ">@if($invoicedata['invoice_status'] != 5){{__('Pay Now')}}@else{{__('No Action')}}@endif</a></td>
                                                </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <p>No Invoice Received</p>
                                    @endif   
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