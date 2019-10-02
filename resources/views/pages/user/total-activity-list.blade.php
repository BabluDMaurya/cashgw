@if(count($content) > 0)
<tr><td colspan="8">First {{count($content)}} transactions</td></tr>                
@foreach($content as $value)
@php
                    if($value->invoice_id > 0){
                        $rowid = $value->invoice_id;
                    }else{
                        $rowid = $value->id;
                    }
                @endphp
<tr>    
<!--    <td>
        <div class="ico-down">
            <a href="#!" id="show-down"><i class="fas fa-angle-down"></i></a>
        </div>
    </td>-->
    <td><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">{{$value->updated_at}}</a></td>

    <td><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">{{$value->transactionid}}</a></td>
    <td><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">{{$value->name}}</a></td>
    <td><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">{{$value->email}}</a></td>
    @if($value->type != 1 && $value->type != 3 && $value->type != 6 && $value->type != 8)
    <td><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">@if($value->status == 2){{__('Completed')}} @elseif($value->status == 3){{__('Rejected')}} @else {{__('Pending')}} @endif</a></td>
    @endif
    <td><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">{{$value->balance}}@if($value->currency == 1){{__('$')}} @else {{__('€')}} @endif</a></td>
    @if($value->type != 2 && $value->type != 5 && $value->type != 7 && $value->type != 9)
    <td><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">@if($value->fee > 0){{$value->fee}}@else {{__('0.00')}}@endif</a></td>
    @endif
    <td class="dark"><a href="{{URL('individual-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">{{$value->descriptions}}</a></td>
    <td ><a class="btn btn-archive clickarchive" id="{{$value->id}}" data-archivetype="@if($value->archieve == 1){{__('2')}}@else{{__('1')}}@endif">@if($value->archieve == 1){{__('Archieve')}} @else {{__('Unarchieve')}} @endif</a></td>
</tr>
@endforeach
@else
<tr><td colspan="8">No Transaction Done</td></tr>
@endif