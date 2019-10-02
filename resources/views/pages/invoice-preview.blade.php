<!DOCTYPE html>
<html>
    <head>
        <title>Cashgw - Invoice Preview</title>

        <!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta http-equiv="content-type" content="text-html; charset=utf-8">
        <style type="text/css">
            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            b, u, i, center,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td,
            article, aside, canvas, details, embed,
            figure, figcaption, footer, header, hgroup,
            menu, nav, output, ruby, section, summary,
            time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                font: inherit;
                font-size: 100%;
                vertical-align: baseline;
            }

            html {
                line-height: 1;
            }

            ol, ul {
                list-style: none;
            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
            }

            caption, th, td {
                text-align: left;
                font-weight: normal;
                vertical-align: middle;
            }

            q, blockquote {
                quotes: none;
            }
            q:before, q:after, blockquote:before, blockquote:after {
                content: "";
                content: none;
            }

            a img {
                border: none;
            }

            article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
                display: block;
            }

            body {
                font-family: Montserrat, Helvetica Neue, Arial,sans-serif;
                font-weight: 300;
                font-size: 12px;
                margin: 20px 50px 20px;
                padding: 0px;
                border: 1px solid #ddd;
                position: relative;
            }
            body:before {
                content: "";
                position: absolute;
                top: -2px;
                right: -2px;
                width: 0px;
                height: 0px;
                border-bottom: 70px solid #eee;
                border-left: 70px solid #fffffc;
                -webkit-box-shadow: 7px 7px 7px rgba(0,0,0,0.3);
                -moz-box-shadow: 7px 7px 7px rgba(0,0,0,0.3);
                box-shadow: 7px 7px 7px rgba(0,0,0,0.3);
                transform: rotate(90deg);
            }
            body a {
                text-decoration: none;
                color: inherit;
                font-size: 15px;
            }
            body a:hover {
                color: inherit;
                opacity: 0.7;
            }
            body .container {
                min-width: 500px;
                margin: 0 auto;
                padding: 0 20px;
            }
            body .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }
            body .left {
                float: left;
            }
            body .right {
                float: right;
            }
            body .helper {
                display: inline-block;
                height: 100%;
                vertical-align: middle;
            }
            body .no-break {
                page-break-inside: avoid;
            }

            header {
                margin-top: 30px;
                margin-bottom:30px;
            }
            header figure{
                padding-bottom: 25px;
            }
            header figure img {
                margin-top: 13px;
                width: 200px;
                height: 100px;
                object-fit: contain;
            }
            header .company-address {
                float: left;
                width: 100%;
                line-height: 1.7em;
                padding-top: 20px;
                clear: both;
            }
            .company-address p{width:30%}
            header .company-address .title {
                color: #0cbafa;
                font-weight: 400;
                font-size: 24px;
                text-transform: uppercase;
                line-height: 28px;
            }
            header .company-contact {
                float: right;
                height: 60px;
                padding: 0 10px;
                background-color: #0cbafa;
                color: white;
                position: absolute;
                bottom:25px;
                right: 0px;
            }
            header .company-contact span {
                display: inline-block;
                vertical-align: middle;
            }
            header .company-contact .circle {
                width: 20px;
                height: 20px;
                background-color: white;
                border-radius: 50%;
                text-align: center;
            }
            header .company-contact .circle img {
                vertical-align: middle;
            }
            header .company-contact .phone {
                height: 100%;
                margin-right: 20px;
            }
            header .company-contact .email {
                height: 100%;
                min-width: 100px;
                text-align: right;
            }

            section .details {
                margin-bottom: 55px;
            }
            section .details .client {
                width: 50%;
                line-height: 20px;
            }
            section .details .client .name {
                color: #000;
                font-weight: bold;
            }
            section .details .data {
                width: 50%;
                text-align: right;
                position: relative;
                bottom: 110px;
            }
            section .details .title {
                margin-bottom: 15px;
                color: #0cbafa;
                font-size: 3em;
                font-weight: 400;
                text-transform: uppercase;
            }
            section table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                font-size: 0.9166em;
            }
            section table .qty, section table .unit,section table .tax, section table .total {
                width: 15%;
                font-size: 14px;
            }
            section table .desc {
                width: 45%;
            }
            section table thead {
                display: table-header-group;
                vertical-align: middle;
                border-color: inherit;
            }
            section table thead th {
                padding: 14px 10px;
                background: #0cbafa;
                border-bottom: 5px solid #FFFFFF;
                border-right: 4px solid #FFFFFF;
                text-align: right;
                color: white;
                font-weight: 400;
                text-transform: uppercase;
            }
            section table thead th:last-child {
                border-right: none;
            }
            section table thead .desc {
                text-align: left;
            }
            section table thead .qty {
                text-align: center;
            }
            section table tbody td {
                padding: 10px;
                background: #E8F3DB;
                color: #777777;
                text-align: right;
                border-bottom: 5px solid #FFFFFF;
                border-right: 1px solid #00000029;
            }
            section table tbody td:last-child {
                border-right: none;
            }
            section table tbody h3 {
                margin-bottom: 5px;
                color: #0cbafa;
                font-weight: 600;
                font-size: 18px;
            }
            section table tbody .desc {
                text-align: left;
            }
            section table tbody .qty {
                text-align: center;
            }
            section table.grand-total {
                margin-bottom: 45px;
            }
            section table.grand-total td {
                padding: 8px 10px;
                border: none;
                color: #777777;
                text-align: right;
            }
            section table.grand-total .desc {
                background-color: transparent;
            }
            section table.grand-total tr:last-child td {
                font-weight: 600;
                color: #0cbafa;
                font-size: 1.18181818181818em;
            }

            footer {
                margin-bottom: 20px;
            }
            footer .thanks {
                margin-bottom: 40px;
                color: #0cbafa;
                font-size: 1.16666666666667em;
                font-weight: 600;
            }
            footer .notice {
                margin-bottom: 25px;
            }
            footer .end {
                padding-top: 5px;
                border-top: 2px solid #0cbafa;
                text-align: center;
            }
            .res_pos {
                position: relative;
            }
            p{
                font-size: 15px;
                line-height: 23px;
            }
            strong {
                font-weight: bold;
            }
            .date {
                font-size: 15px;
                color: #000;
                line-height: 23px;
            }
            .notice div{
                font-size: 15px;
                line-height: 23px;	
            }
            .payment {
                text-align: right;
                margin-right: 20px;
            }
            a.pay_btn {
                padding: 12px 24px;
                background: #0cbafa;
                border: 1px solid #0cbafa;
                color: #fff;
                font-size: 14px;
                cursor: pointer;
                transition: 0.3s ease-in-out;
                opacity: 0.7;
            }
            a.pay_btn:hover{
                transition: 0.3s ease-in-out;
                opacity: 1;  

            }
            @media only screen and (max-width:768px) {
                section .details .data {

                    bottom: 160px;
                }
            }

            @media only screen and (max-width:525px) {
                body {
                    font-family: Montserrat, Helvetica Neue, Arial,sans-serif;
                    font-weight: 300;
                    font-size: 12px;
                    margin: 0px;
                    padding: 0px;
                    border: 1px solid transparent;
                    position: relative;
                }
                body:before{
                    display: none;
                }
                header figure img {
                    width: 140px;
                }
                header .company-contact {
                    bottom: 14px;
                    right: 0px;
                }
                section .details .data {
                    bottom: 5px;
                    font-size: 12px;
                }
            }
        </style>
    </head>

    <body>
        <header class="clearfix">
            <div class="container">
                <figure>
                    @php
                    if($invoiceData[0]['business_logo'] != '' && $invoiceData[0]['business_logo'] != 'logo.png'){
                            $img = $invoiceData[0]['user_id']."/".$invoiceData[0]['business_logo'];
                        }else{
                            $img = $invoiceData[0]['business_logo'];
                        }
                    @endphp    
                    <img class="logo" src="{{url('/public/images/')}}/@if($invoiceData[0]['business_logo'] != ''){{$img}}@else{{__('38/38_PhotoFile.png')}}@endif">                                                                            
                </figure>
                <div class="company-address">
                    <h2 class="title">{{ $invoiceData[0]['business_name'] }}</h2>
                    <p><br><strong>{{ $invoiceData[0]['first_name'] }}</strong> , </br> {{ $invoiceData[0]['address'] }}
                    </p>
                </div>
                <div class="res_pos">
                    <div class="company-contact">
<!--                        <div class="phone left">
                            <span class="circle"><img src="../images/call.png" alt=""><span class="helper"></span></span>
                            <a href="tel:+{{ $invoiceData[0]['phone'] }}">+{{ $invoiceData[0]['phone'] }}</a>
                            <span class="helper"></span>
                        </div>-->
                        <div class="email right">
                            <span class="circle"><img src="../images/msg.png" alt=""><span class="helper"></span></span>
                            <a href="mailto:{{ $invoiceData[0]['email_id'] }}">{{ $invoiceData[0]['email_id'] }}</a>
                            <span class="helper"></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section>
            <div class="container">
                <div class="details clearfix">
                    <div class="data right">
                        <div class="title">Invoice</div>
                        <div class="date">
                            Invoice : {{ $invoiceData[0]['invoice_number'] }}<br>                            
                            Date of Invoice: {{ $invoiceData[0]['invoice_date'] }}<br>
                            Due Date: {{ $invoiceData[0]['due_date_value'] }}
                            <br>
                        </div>
                    </div>
                </div>

                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="desc">Description</th>
                            <th class="qty">Quantity</th>
                            <th class="unit">Unit price</th>
                            <th class="tax">Tax</th>
                            <th class="total">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($invoiceItems) > 0)
                        @foreach($invoiceItems as $details)
                        <tr>
                            <td class="desc"><h3>{{ $details->item_name }}</h3>
                                <p>{{ $details->item_desc }}</p></td>
                            <td class="qty">{{ $details->item_quantity }}</td>
                            <td class="unit">{{$currencyDeails[0]['symbol']}} {{ $details->item_price }}</td>
                            @php
                            if(!empty($details->tax_rate)){
                             $taxRate =  $details->tax_rate;
                            }else{
                             $taxRate = 0;
                            }
                            @endphp
                            <td class="tax">{{ $taxRate }}%</td>
                            <td class="total">{{$currencyDeails[0]['symbol']}} {{ $details->item_amount }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>No Data Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="no-break">
                    <table class="grand-total">
                        <tbody>
                            <tr>
                                <td class="desc"></td>
                                <td class="qty"></td>
                                <td class="unit">SUBTOTAL:</td>
                                <td class="total">{{$currencyDeails[0]['symbol']}} {{ $invoiceData[0]['invoice_subtotal'] }}</td>
                            </tr>
                            <tr>
                                <td class="desc"></td>
                                <td class="qty"></td>
                                <td class="unit">Discount:</td>
                                <td class="total">{{$currencyDeails[0]['symbol']}} {{ $invoiceData[0]['invoice_discount_in_value'] }}</td>
                            </tr>
                            <tr>
                                <td class="desc"></td>
                                <td class="qty"></td>
                                <td class="unit">Shipping:</td>
                                <td class="total">{{$currencyDeails[0]['symbol']}} {{ $invoiceData[0]['invoice_shipping'] }}</td>
                            </tr>
                            <tr>
                                <td class="desc"></td>
                                <td class="unit" colspan="2">GRAND TOTAL:</td>
                                <td class="total">{{$currencyDeails[0]['symbol']}} {{ $invoiceData[0]['invoice_grand_total'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        @if(($invoiceData[0]['invoice_status'] != 5 && $invoiceData[0]['invoice_status'] == 3) &&( $login_id != $invoiceData[0]['user_id']))
        <section>
            <div class="payment">
                <a href="{{ url($paynow) }}/{{$invoice_id}}" type="button" class="pay_btn"> Pay Now</a>
            </div>
        </section>
        @endif
        <footer>
            <div class="container">
                <div class="thanks">Thank you!</div>
                <div class="notice">
<!--                    <div>NOTICE:</div>
                    <div>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>-->
                </div>
                <div class="end">Invoice was created on a computer and is valid without the signature and seal.</div>
            </div>
        </footer>

    </body>

</html>

<!--<div class="row">
    <div class="container">
        <p><b>Business Name:</b> {{ $invoiceData[0]['business_name'] }}</p>
        <p><b>Name:</b> {{ $invoiceData[0]['first_name'] }}</p>
         <p><b>Phone:</b> {{ $invoiceData[0]['phone'] }}</p>
        <p><b>Email:</b> {{ $invoiceData[0]['bill_to_email'] }}</p>
        <p><b>Address:</b> {{ $invoiceData[0]['address'] }}</p>
        <p><b>Invoice Subtotal:</b> {{ $invoiceData[0]['invoice_subtotal'] }}</p>
        <p><b>Discount:</b> {{ $invoiceData[0]['invoice_discount_in_value'] }}</p>
        <p><b>Shipping:</b> {{ $invoiceData[0]['invoice_shipping'] }}</p>
        <p><b>Grand Total:</b> {{ $invoiceData[0]['invoice_grand_total'] }}</p>
        <a href="{{ url('/confirm-pay-invoice/') }}/{{$invoice_id}}">Pay now</a>
     </div>
</div>-->
