@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
        <div class="container">
            <div class="row">   
                <div class="col-md-12">
                    <button onclick="goBack()" type="button" class="btn blue-btn round-btn hvr-sweep-to-top mb-20 float-right back_pos_icon"><i class="fa fa-angle-left"></i> Back</button>
                </div>
                <div class="col-md-12">
                    <div class="block-item invoice-info shadow-block">                        
                        <div class="balance-new-title">
                            <h5 class="block-title">Invoice Details</h5>                            
                        </div>
                        <div class="invoice-details">
                            <div>
                                <strong>Invoice @if($invoice->invoice_status == 1){{__('Draft')}}@elseif($invoice->invoice_status == 2){{__('Schedule')}}@elseif($invoice->invoice_status == 3){{__('Sent')}}@elseif($invoice->invoice_status == 4){{__('Cancelled')}}@elseif($invoice->invoice_status == 5){{__('Paid')}}@else{{__('Status Unset')}}@endif</strong>                        
                                <p>Invoice Date : {{$invoice->invoice_date}}</p>
                                <p>Invoice Status : <a>@if($invoice->invoice_status == 5){{__('Paid')}}@else{{__('Unpaid')}}@endif</a></p>
                            </div>
                            <div>
                                <strong>&nbsp;</strong>                        
                                <p>Invoice Number : {{$invoice->invoice_number}}</p>
                                <p>Transaction Id : {{$invoice->transaction_id}}</p>
                            </div>
                            <div>
                                <h6 class="mt-1">Amount: <span class="price-text">{{$invoice->invoice_grand_total}}</span></h6>
                                
                            </div>
                        </div>                                                
                        <div class="table-responsive payment-table mt-4">
                            <table class="table text-right">
                                <thead>
                                    <tr>
                                        <th class="text-left">Item Description</th>
                                        <td class="text-right">Quantity</td>
                                        <td class="text-right">Price</th>
                                        <td class="text-right">Tax</th>
                                        <td class="text-right">Subtotal</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sum = 0;
                                    @endphp
                                    @if(count($invoiceitem) > 0)                                    
                                    @foreach($invoiceitem as $item)
                                        <tr>
                                            <td class="text-left">{{$item['itemdesc']}}</td>
                                            <td class="text-center">{{$item['itemquantity']}}</td>
                                            <td class="text-left">{{$item['itemprice']}}</td>
                                            <td>{{$item['itemtax']}}</td>
                                            <td>{{$item['itemprice'] + (($item['itemprice'] * $item['itemtax'])/100)}}</td>
                                          </tr>                                           
                                            @php                                  
                                                $sum+= intval($item['itemprice'] + (($item['itemprice'] * $item['itemtax'])/100));                                                
                                            @endphp
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                                <tfoot class="dotted-top-border">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                         <td></td>
                                        <td>Purchase total :</td>
                                        <td>{{$sum}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="table-responsive payment-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="7" class="text-left">Payment Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <th colspan="2">Purchase total</th>
                                      <td>{{$sum}}</td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <th colspan="2">Cashgw fee</th>
                                      <td>{{$calresult['TranCharge']}}</td>
                                      <td></td>
                                    </tr>
                                    <tr class="dotted-top-border" >
                                      <th colspan="2">Gross amount</th>
                                      <td>{{$sum + $calresult['TranCharge']}}</td>
                                      <td></td>
                                    </tr>                                    
                                </tbody>
                            </table>
                            <a class="btn btn-primary color_btn_white" href="{{URL('/business-pay-invoice/'.$invoiceId)}}">
                            @if($invoice->user_id == decrypt($user_id))                                
                                View
                            @else
                                Pay Now
                            @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection