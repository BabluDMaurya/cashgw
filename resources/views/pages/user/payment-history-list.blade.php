@foreach($paymenthistory as $value)
                                    <tr class="">
                                        <td>{{$value->transactionid}}</td>
                                         <td>{{ucfirst($value->name)}}</td>
                                         <td>{{$value->amount}}</td>
                                         <td>{{$value->updated_at}}</td>
                                         <td>{{$value->email}}</td>
                                         <td><p class="truncl">{{$value->details}}</p></td>
                                         <td class="
                                                @if($value->tstatus == 1)
                                                {{__('green-text')}}
                                                @else {{__('red-text')}}
                                                @endif
                                             ">
                                                @if($value->tstatus == 1)
                                                {{__('Creadited')}}
                                                @else
                                                {{__('Debited')}}
                                                @endif
                                         </td>
                                         <td ><a class="btn btn-archive clickarchive" id="{{$value->id}}" data-archivetype="@if($value->archieve == 1){{__('2')}}@else{{__('1')}}@endif">@if($value->archieve == 1){{__('Archieve')}} @else {{__('Unarchieve')}} @endif</a></td>
                                     </tr>                                
                                @endforeach