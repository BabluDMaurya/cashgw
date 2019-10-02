
@if(!empty($SingleInvoiceDetails['business_name']))
{{$SingleInvoiceDetails['business_name']}}
@endif
<br>


@if(!empty($SingleInvoiceDetails['first_name']))
{{$SingleInvoiceDetails['first_name']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['address']))
{{$SingleInvoiceDetails['address']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['phone']))
{{$SingleInvoiceDetails['phone']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['email_id']))
{{$SingleInvoiceDetails['email_id']}}
@endif
<br>

<label>Invoice Number: </label>
{{$SingleInvoiceDetails['invoice_number']}}
<br>

@if(!empty($SingleInvoiceDetails['invoice_date']))
<label>Invoice Date: </label>
{{$SingleInvoiceDetails['invoice_date']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['due_date']))
<label>Due Date: </label>
@php
$duedate = date('d-m-Y', strtotime("+". $SingleInvoiceDetails['due_date']. "days"));
@endphp
{{$duedate}}
@endif
<br>


@if(!empty($SingleInvoiceDetails['invoice_grand_total']))
<label>Amount: </label>
{{$SingleInvoiceDetails['invoice_grand_total']}}
@endif
<br>


@if(!empty($SingleInvoiceDetails['bill_to_email']))
<label>Bill To: </label>
{{$SingleInvoiceDetails['bill_to_email']}}
@endif
<br>

@if(!empty($invoiceItemList))
@foreach($invoiceItemList as $items)
{{$items->item_name}}
{{$items->item_quantity}}
{{$items->item_price}}
{{$items->item_tax_rate}}
{{$items->item_amount}}
@endforeach
@endif

@if(!empty($SingleInvoiceDetails['invoice_subtotal']))
<label>Subtotal: </label>
{{$SingleInvoiceDetails['invoice_subtotal']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['invoice_discount_in_percent']))
<label>Discount(%): </label>
{{$SingleInvoiceDetails['invoice_discount_in_percent']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['invoice_discount_in_value']))
<label>Discount In Value: </label>
{{$SingleInvoiceDetails['invoice_discount_in_value']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['invoice_shipping']))
<label>Invoice Shipping: </label>
{{$SingleInvoiceDetails['invoice_shipping']}}
@endif
<br>

@if(!empty($SingleInvoiceDetails['invoice_grand_total']))
<label>Invoice Total: </label>
{{$SingleInvoiceDetails['invoice_grand_total']}}
@endif
<br>
    @php
        if(isset($SingleInvoiceDetails['business_logo']) && $SingleInvoiceDetails['business_logo'] != 'logo.png'){
            $img = $userid."/".$SingleInvoiceDetails['business_logo'];
        }else{
            $img = $SingleInvoiceDetails['business_logo'];
        }
    @endphp 
<img src="{{url('/public/images/')}}/@if(isset($SingleInvoiceDetails['business_logo'])){{$img}}@endif" style="max-width: 150px;height: 100px;margin-top:30px;">                                                   







