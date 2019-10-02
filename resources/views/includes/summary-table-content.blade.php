<div class="nav nav-tabs " id="nav-tab" role="tablist">
    <item class="nav-item nav-link active" id="nav-section1-tab" data-toggle="tab" href="#section1" role="tab" aria-controls="nav-section1" aria-selected="true">Sent Money</item>
    <item class="nav-item nav-link" id="nav-section2-tab" data-toggle="tab" href="#section2" role="tab" aria-controls="nav-section2" aria-selected="false">Requested Money</item>
    <item class="nav-item nav-link" id="nav-section3-tab" data-toggle="tab" href="#section3" role="tab" aria-controls="nav-section3" aria-selected="false">Received Money</item>
    <!--<item class="nav-item nav-link" id="nav-section4-tab" data-toggle="tab" href="#section4" role="tab" aria-controls="nav-section4" aria-selected="false">Sent Invoice</item>-->
    <item class="nav-item nav-link" id="nav-section5-tab" data-toggle="tab" href="#section5" role="tab" aria-controls="nav-section5" aria-selected="false">Sent Invoice</item>
    <item class="nav-item nav-link" id="nav-section6-tab" data-toggle="tab" href="#section6" role="tab" aria-controls="nav-section6" aria-selected="false">Invoice Paid</item>
    <item class="nav-item nav-link" id="nav-section7-tab" data-toggle="tab" href="#section7" role="tab" aria-controls="nav-section7" aria-selected="false">Invoice Received</item>
    <item class="nav-item nav-link" id="nav-section8-tab" data-toggle="tab" href="#section8" role="tab" aria-controls="nav-section8" aria-selected="false">Invoice Processed</item>
    <item class="nav-item nav-link" id="nav-section9-tab" data-toggle="tab" href="#section9" role="tab" aria-controls="nav-section9" aria-selected="false">Admin Activity</item>
</div>                                 
<div class="tab-content" id="nav-tabContent">
    @for($i=1; $i<=9; $i++)
    @php
        if($i == 1){
            $content = $sendmoney;
        }elseif($i == 2){            
            $content = $requestmoney;
        }elseif($i == 3){
            $content = $sentmoney;
        }elseif($i == 5){
            $content = $sentinvoice;
        }elseif($i == 6){
            $content = $paidinvoice;
        }elseif($i == 7){
            $content = $receivedinvoice;
        }elseif($i == 8){
            $content = $processedinvoice;
        }elseif($i == 9){
            $content = $admin;
        }         
    @endphp
     @if($i != 4)
    <div id="section{{$i}}" class="tab-pane fade in @if($i == 1){{__('active show')}} @endif">
        @if(count($content) > 0)
        <a class="d-flex justify-content-end activetab mb-30" data-currenttabchild="{{$i}}" href="{{URL($module.'-activity/'.$user_id)}}">View All</a>
        @endif
        <table class="table table-bordered my-table truncate_ellipse">
            <thead>
                <tr>                    
                    <!--<th width="55px"></th>-->
                    <th class="width_75">Date</th>
                    <th class="width_130">Transaction ID</th>
                    <th class="width_80">Name</th>
                    <th class="width_130">Email</th>
                     @if($i != 1 && $i != 3 && $i != 6 && $i != 8)
                    <th class="width_70">payment</th>
                    @endif
                    <th class="width_60">Amount</th>
                    @if($i != 2 && $i != 5 && $i != 7 && $i != 9)
                    <th class="width_70">Fees</th>
                    @endif
                    <th class="width_160">Description</th>
                    <!--<th style="width:90px;">Actions</th>-->
                </tr>
            </thead>
            <tbody>
                @if(count($content) > 0)
                <tr><td colspan="7">First {{count($content)}} transactions</td></tr>                
                @foreach($content as $value)
                <tr>                    
<!--                    <td>
                        <div class="ico-down">
                            <a href="#!" id="show-down"><i class="fas fa-angle-down"></i></a>
                        </div>
                    </td>-->
                    <td>{{$value->updated_at}}</td>
                    <td>
                        {{$value->transactionid}}                        
                    </td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    @if($i != 1 && $i != 3 && $i != 6 && $i != 8)
                    <td>@if($value->status == 2){{__('Completed')}} @elseif($value->status == 3){{__('Rejected')}} @else {{__('Pending')}} @endif</td>
                    @endif
                    <td>{{$value->balance}}@if($value->currency == 1){{__('$')}} @else {{__('?')}} @endif</td>
                    @if($i != 2 && $i != 5 && $i != 7 && $i != 9)
                    <td>@if($value->fee > 0){{$value->fee}}@else {{__('0.00')}}@endif</td>
                    @endif
                    <td class="dark">
                        <div class="text-view">
                            <p class="truncl">{{$value->descriptions}}</p> 
                                <a href="#!" id="primary" data-toggle="modal" data-target="#para-viewall" class="">View All</a>
                        </div>
                    </td>
                    <!--<td ><a class="btn btn-archive clickarchive" id="{{$value->id}}" data-archivetype="@if($value->archieve == 1){{__('2')}}@else{{__('1')}}@endif">@if($value->archieve == 1){{__('Archieve')}} @else {{__('Unarchieve')}} @endif</a></td>-->
                </tr>
                @endforeach
                @else
                <tr><td colspan="7">No Transaction Done</td></tr>
                @endif
            </tbody>
        </table>
    </div>
     
     
     <div class="modal fade " id="para-viewall">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Description</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries.</p>
            </div>
        </div>
    </div>
</div>
     
     
     
    @endif 
    @endfor
</div>