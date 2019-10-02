@if(count($InvoiceStatusDetailsGrid)>0)
@php
    if($role == 2){
        $invoicedetailsurl = 'business-invoice-details';
    }else{
        $invoicedetailsurl = 'individual-invoice-details';
    }
@endphp
@foreach($InvoiceStatusDetailsGrid as $invDetails)
<tr>
    <td>
        <div class="position-relative">
            <label class="l-checkbox">       
                <input type="checkbox" value="{{$invDetails->id}}" name="chkinvoiceid">
                <span class="checkmark"></span>
            </label>
        </div>
    </td>
    <td><a href="{{URL($invoicedetailsurl.'/'.encrypt($invDetails->id))}}" class="text-dark">{{date('j-M-Y', strtotime($invDetails->invoice_date))}}</a></td>
    <td><a href="{{URL($invoicedetailsurl.'/'.encrypt($invDetails->id))}}" class="text-dark">{{$invDetails->invoice_number}}</a></td>
    <td><a href="{{URL($invoicedetailsurl.'/'.encrypt($invDetails->id))}}" class="text-dark">{{$invDetails->bill_to_email}}</a></td>
    <td>
        <a href="{{URL($invoicedetailsurl.'/'.encrypt($invDetails->id))}}" class="text-dark">
            @if($invDetails->invoice_status == 1)    
            Draft
            @elseif($invDetails->invoice_status == 2) 
            Scheduled
            @elseif($invDetails->invoice_status == 3)
            Unpaid(Sent)
            @elseif($invDetails->invoice_status == 4)
            Cancelled
            @else
            Paid
            @endif
            <span class="light-text">Due {{date('j-M-Y', strtotime($invDetails->due_date_value))}}</span>
        </a>
    </td>
    <td>
        <select class="form-control" id="selectInvoiceOptions">
            <option selected="" disabled="" value="">Select Actions</option>
            @if($invDetails->invoice_status != 5)
            <option value="{{encrypt($invDetails->id)}}" link="@if($role == 2){{__('business-edit-invoice')}}@else{{__('edit-invoice')}}@endif">Edit</option>
            @endif
            <option value="{{encrypt($invDetails->id)}}" link="@if($role == 2){{__('business-copy-invoice')}}@else{{__('copy-invoice')}}@endif">Copy</option>
            <option value="{{encrypt($invDetails->id)}}" link="@if($role == 2){{__('business-print-invoice')}}@else{{__('print-invoice')}}@endif">Print</option>                                                        
            <option value="{{encrypt($invDetails->id)}}" link="@if($role == 2){{__('business-generate-pdf')}}@else{{__('generate-pdf')}}@endif">Pdf</option>            
<!--            <option value="{{encrypt($invDetails->id)}}">Share Link</option>-->
            @if($invDetails->invoice_status == 3 || $invDetails->invoice_status == 2 )    
            <option value="{{encrypt($invDetails->id)}}" link="@if($role == 2){{__('business-cancel-invoice')}}@else{{__('cancel-invoice')}}@endif">Cancel</option>
            @elseif($invDetails->invoice_status == 1) 
            <option value="{{encrypt($invDetails->id)}}" link="@if($role == 2){{__('business-delete-draft-invoice')}}@else{{__('delete-draft-invoice')}}@endif">Delete</option>
            @endif
        </select>
    </td>
    <td><a href="{{URL($invoicedetailsurl.'/'.encrypt($invDetails->id))}}" class="text-dark">$ {{$invDetails->invoice_grand_total}}</a></td>
</tr> 
@endforeach
@else
<tr><td class="text-center" style="font-size: 20px;" colspan="7">No Record Found.</td></tr>
@endif