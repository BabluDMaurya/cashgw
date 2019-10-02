<div class="container">
    <table class="content" width="100%" style="border-collapse: collapse;
           width: 100%;">
        <tr>
            <th colspan="2" style="text-align: left;padding: 8px;">
                @php
                    if(isset($InvoicePreviewData['invoice_business_logo_pre']) && $InvoicePreviewData['invoice_business_logo_pre'] != 'logo.png'){
                        $img = $userid."/".$InvoicePreviewData['invoice_business_logo_pre'];
                    }else{
                        $img = $InvoicePreviewData['invoice_business_logo_pre'];
                    }
                @endphp
                @if(!empty($InvoicePreviewData['invoice_business_logo_pre']))                
                <img src="{{URL('public/images/')."/".$img}}" width="172px" height="97px">
                @endif
            </th>
            <th style="text-align: left;padding: 8px;">
                <h1 style="font-size: 30px;margin-bottom: 0;text-transform: uppercase;color: #ced4da;font-family: Montserrat, Helvetica Neue, Arial, sans-serif;font-weight: 700;text-align: right;padding-left:0px;;">Invoice</h1>
            </th>
        </tr>
        <tr style="text-align: left;padding: 8px;">
            <td></td>
            <td></td>
            <td  class="res_invoice_wdipl" style="text-align:right;">Invoice : 
                <span>{{$InvoicePreviewData['invoice_number']}}</span></td>

        </tr>
        <tr>
            <td></td>
            <td></td>
            <td class="invoice_date" style="text-align: right;font-family: Montserrat, Helvetica Neue, Arial,sans-serif">Invoice Date : 
                <span>@if(!empty($InvoicePreviewData['invoice_date']))
                    {{$InvoicePreviewData['invoice_date']}}
                    @else
                    {{__('DD/MM/YYYY')}}
                    @endif
                </span>
            </td>
        </tr>
        <tr>

            <td colspan="2" style="padding-left: 0px;">
                <h1 class="res_h1" style="font-size: 24px;margin-bottom: 0;text-transform: uppercase;color: #000000a6;font-weight: normal;margin-top: -10px;"> @if(!empty($InvoicePreviewData['business_name'])){{$InvoicePreviewData['business_name']}}@endif</h1>
            </td>

            <td class="res_pos" style="text-align: right;font-family: Montserrat, Helvetica Neue, Arial,sans-serif">Due Date : 
                <span>@if(!empty($InvoicePreviewData['due_date']))
                    @php
                    $duedate = date('d-m-Y', strtotime("+". $InvoicePreviewData['due_date']. "days"));
                    @endphp
                    {{$duedate}}
                    @else
                    {{__('DD/MM/YYYY')}}
                    @endif
                </span>
            </td> 
        </tr>
        <tr>
        </tr>
        <tr>
            <td colspan="2" style="line-height: 26px;padding-left:0px;">                       
                @if(!empty($InvoicePreviewData['first_name']))
                First Name : {{$InvoicePreviewData['first_name']}}
                @endif<br>
                @if(!empty($InvoicePreviewData['address']))
                Address : {{$InvoicePreviewData['address']}}
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding-left:0px;"> @if(!empty($InvoicePreviewData['phone'])){{__('Phone :')}}{{$InvoicePreviewData['phone']}}@endif</td>
        </tr>
        <tr>
            <td style="padding-left:0px;">Email : @if(!empty($InvoicePreviewData['mailToSender'])){{$InvoicePreviewData['mailToSender']}}@endif</td>
        </tr>
<!--        <tr>BILL To: 
            @if(!empty($InvoicePreviewData['bill_to_email']))
            {{$InvoicePreviewData['bill_to_email']}}
            @endif
        </tr>-->
        <tr>
            <td colspan="3" width="100%" style="padding-left: 0px;">
                <table class="overflow_res_scroll" width="100%" style="margin-top: 30px;overflow-x: scroll;">
                    <thead>
                        <tr>
                            <th style="background: #e6e6e6;border: 1px solid #000; width: 50%;line-height: 38px;">Description</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Quantity</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Price</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Tax</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($InvoicePreviewData['item_name']))
                        @for ($i = 0; $i < count($InvoicePreviewData['item_name']); $i++) 
                        <tr>
                        <td style="border:1px solid #000;background: #f9f9f6;line-height: 20px;">{{$InvoicePreviewData['item_name'][$i]}}<br>{{$InvoicePreviewData['item_desc'][$i]}}</td>
                        <td style="border:1px solid #000;line-height: 20px;">{{$InvoicePreviewData['item_quantity'][$i]}}</td>
                        <td style="border:1px solid #000;line-height: 20px;">{{$InvoicePreviewData['item_price'][$i]}}</td>
                        <td style="border:1px solid #000;line-height: 20px;">{{$InvoicePreviewData['item_tax_id'][$i]}}</td>
                        <td style="border:1px solid #000;line-height: 20px;">{{$InvoicePreviewData['item_amount'][$i]}}</td>
                        <tr>
                        @endfor
                        @endif
                    <tr>
                        <td colspan="2" rowspan="4" style="padding-left: 0px;">
                            <label>Notes : </label>
                            <p style="width: 85%;">@if(!empty($InvoicePreviewData['notes_to_recepient'])){{$InvoicePreviewData['notes_to_recepient']}}@endif</p>
                        </td>
                        <td colspan="3" style="border-bottom: 1px solid #ccc;padding: 12px 8px;text-align: right;">Sub-Total : <span>@if(!empty($InvoicePreviewData['invoice_subtotal'])){{$InvoicePreviewData['invoice_subtotal']}}@endif</span></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom: 1px solid #ccc;padding: 12px 8px;text-align: right;">Discount : <span> @if(!empty($InvoicePreviewData['invoice_discount_in_value'])){{$InvoicePreviewData['invoice_discount_in_value']}}@endif</span></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom: 1px solid #ccc;padding: 12px 8px;text-align: right;">Shipping : <span> @if(!empty($InvoicePreviewData['invoice_shipping'])){{$InvoicePreviewData['invoice_shipping']}}@endif</span></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom: 1px solid #ccc;
                            padding: 20px 7px;
                            color: #000;
                            font-weight: bold;
                            font-size: 24px;text-align: right;">
                            Total Due : 
                            <span style="padding: 0px !important;
                                  font-size: 24px;
                                  color: red;
                                  font-weight: bold;margin: 0;color: #015fff">@if(!empty($InvoicePreviewData['invoice_grand_total'])){{$InvoicePreviewData['invoice_grand_total']}}@endif
                            </span>
                        </td>                    
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
