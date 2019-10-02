<!DOCTYPE html>
<html>
    <head>
        <title>{{$CreateInvoice->invoice_number}}</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            td, th {
                text-align: left;
                padding: 8px;
            }
        </style>
    </head>
    <body style="background:#fffffc;padding:50px;font-family: Montserrat, Helvetica Neue, Arial,sans-serif;border: 1px solid #dddddd;margin: 20px;">
        <div class="container">
            <table style="border-collapse: collapse;width: 100%;">
                
                <tr>
                    <th colspan="2" style="text-align: left;padding: 8px;">
                            @php
                            if(isset($CreateInvoice->business_logo) && $CreateInvoice->business_logo != 'logo.png'){
                                $img = $user_id."/".$CreateInvoice->business_logo;
                            }else{
                                $img = $CreateInvoice->business_logo;
                            }
                        @endphp 
                    <img src="{{URL('/public/images/')}}/{{$img}}" style="width:130px;height: 100px;">                                                   

                    </th>
                    <th style="text-align: left;padding: 8px;">
                        <h1 style="font-size: 30px;margin-bottom: 0;text-transform: uppercase;color: #ced4da;font-family: Montserrat, Helvetica Neue, Arial, sans-serif;font-weight: 700;text-align: right;padding-left:0px;;">Invoice</h1>
                    </th>
                </tr>
                <tr style="text-align: left;padding: 8px;">
                    <td></td>
                    <td></td>
                    <td style="text-align: right;font-family: Montserrat, Helvetica Neue, Arial,sans-serif">
                        Invoice# : <span>{{$CreateInvoice->invoice_number}}</span>
                    </td>                      
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;font-family: Montserrat, Helvetica Neue, Arial,sans-serif">Invoice Date : 
                        <span>{{$CreateInvoice->invoice_date}}</span></td>
                </tr>
                <tr>
                    <td style="padding-left: 0px;">
                        <h1 style="font-size: 24px;margin-bottom: 0;text-transform: uppercase;color: #000000a6;font-family: Montserrat, Helvetica Neue, Arial,sans-serif;font-weight: normal;margin-top: -10px;">{{$CreateInvoice->business_name}}</h1>
                    </td>
                    <td></td>
                    <td style="text-align: right;font-family: Montserrat, Helvetica Neue, Arial,sans-serif">Due Date : 
                        <span>{{$CreateInvoice->due_date_value}}</span></td>                     
                </tr>
                
                <tr>
                    <td colspan="2" style="font-family: Montserrat, Helvetica Neue, Arial,sans-serif;line-height: 26px;padding-left:0px;">{{$CreateInvoice->first_name}},<br>{{$CreateInvoice->address}}</td>
                </tr>
                <tr>
                    <td style="font-family: Montserrat, Helvetica Neue, Arial,sans-serif;padding-left:0px;">Phone : {{$CreateInvoice->phone}}</td>
                </tr>
                <tr>
                    <td style="font-family: Montserrat, Helvetica Neue, Arial,sans-serif;padding-left:0px;">{{$CreateInvoice->email_id}}</td>
                </tr>
                
                <table style="margin-top: 30px;">
                    <thead>
                        <tr>
                            <th style="background: #e6e6e6;border: 1px solid #000; width: 50%;line-height: 38px;">Description</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Quantity</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Unit Price</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Tax</th>
                            <th style="background: #e6e6e6;border: 1px solid #000;width: 10%;line-height: 38px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($InvoiceItemList) > 0)
                        @foreach($InvoiceItemList as $value)
                        <tr>
                            <td style="border:1px solid #000;background: #f9f9f6;line-height: 20px;">{{$value->item_desc}}</td>
                            <td style="border:1px solid #000;line-height: 20px;">{{$value->item_quantity}}</td>
                            <td style="border:1px solid #000;line-height: 20px;">{{$value->item_price}}</td>
                            <td style="border:1px solid #000;line-height: 20px;">{{$value->item_tax_id}}</td>
                            <td style="border:1px solid #000;line-height: 20px;">{{$value->item_price}}</td>
                        </tr>                        
                        @endforeach
                        @endif                        
                        <tr>
                            <td colspan="2" rowspan="4" style="padding-left: 0px;">
                                <label>Notes</label>
                                <p style="width: 85%;">{{$CreateInvoice->notes_to_recepient}}</p>
                            </td>
                            <td colspan="3" style="    border-bottom: 1px solid #ccc;    padding: 12px 8px;text-align: right;">Sub-Total : <span>{{$CreateInvoice->invoice_subtotal}}</span></td>
                        </tr>

                        <tr>
                            <td colspan="3" style="    border-bottom: 1px solid #ccc;    padding: 12px 8px;text-align: right;">Discount : <span> {{$CreateInvoice->invoice_discount_in_value}}</span></td>

                        </tr>
                        <tr>
                            <td colspan="3" style="    border-bottom: 1px solid #ccc;
                                padding: 20px 7px;
                                color: #000;
                                font-weight: bold;
                                font-size: 24px;text-align: right;">Total Due : <span style="padding: 0px !important;
                                                font-size: 24px;
                                                color: red;
                                                font-weight: bold;margin: 0;color: #015fff">{{$CreateInvoice->invoice_grand_total}}</span></td>                  
                        </tr>
                    </tbody>
                </table>
            
            </table>
        </div>
    </body>
</html>