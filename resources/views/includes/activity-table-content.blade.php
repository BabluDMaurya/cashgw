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
        
        if($i ==5 || $i == 6 || $i == 7 || $i == 8){
            $page = 'invoice';
        }else{
            $page = 'activity';
        }

            $type = $i;
    @endphp
    @if($i != 4)
    <div id="section{{$i}}" class="tab-pane fade in @if($i == 1){{__('active show')}} @endif">        
        <form action="{{URL($module.'-activity/'.$user_id.'/edit')}}" method="get" class="common-form w-100" id="searchform{{$i}}">
        <div class="form-row flex-form-row">
           <div class="form-group">
               <input type="hidden" name="type" value="{{$type}}"> 
              <div class="input-group date" data-provide="datepicker">                  
                 <input type="text" class="form-control changeform" name="seldate" value="" placeholder="DD/MM/YYYY" autocomplete="off">
                 <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                 </div>
              </div>
           </div>
           <div class="form-group">
              <select name="currency" class="form-control changeform" select="">
                  <option value="0" selected="" disabled>Select Currency</option>
                 <option value="1">USD</option>
                 <option value="2">EUR</option>
              </select>
           </div>
           <div class="form-group">
              <select class="form-control seloption" name="seloption">
                 <option value="1" selected="">Email Address</option>
                 <option value="2">Transaction ID</option>
                 <option value="3">First Name</option>
              </select>
           </div>
           <div class="form-group search-div">
              <input type="text" class="form-control search-input" name="stran" placeholder="Search Here" autocomplete="off" value="">
              <button type="button" class="searchdata search-btn"><i class="fas fa-search"></i></button>                            
           </div>
           <div class="form-group">
              <select name="archieve" class="form-control changeform">
                 <option value="0" selected="">All</option>
                 <option value="1">Archieve</option>
                 <option value="2">Unarchieve</option>
              </select>
           </div>
           <div class="text-right mt-point">
               @if(count($content) > 0)
              <div class="dropdown download-text">
                 <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fas fa-download"></i>
                 </a>
                 <div class="dropdown-menu" style="left: auto !important;right: 0" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item" type="submit" value="1" name="downloadpdf">Download PDF</button>
                 </div>
              </div>
             @endif  
           </div>
        </div>
     </form>    
        <table class="table table-bordered my-table">
            <thead>
                <tr>                    
                    <!--<th width="55px"></th>-->
                    <th class="width_95">Date</th>
                    <th class="width_150">Transaction ID</th>
                    <th class="width_100">Name</th>
                    <th class="width_160">Email</th>
                    @if($i != 1 && $i != 3 && $i != 6 && $i != 8)
                    <th class="width_70">payment</th>
                    @endif
                    <th class="width_85">Amount</th>
                    @if($i != 2 && $i != 5 && $i != 7 && $i != 9)
                    <th class="width_70">Fees</th>
                    @endif
                    <th class="width_145">Description</th>
                    <th class="width_100">Actions</th>
                </tr>
            </thead>
            <tbody id="activitydata{{$i}}" class="ellipse_text">
                @if(count($content) > 0)
                <tr><td colspan="8">First {{count($content)}} transactions</td></tr>                
                @foreach($content as $value)
                @php
                    if($value->invoice_id > 0 && ($value->type == 5 ||$value->type == 6||$value->type == 7 ||$value->type == 8)){
                        $rowid = $value->invoice_id;
                    }else{
                        $rowid = $value->id;
                    }
                @endphp
                <tr>                    
<!--                    <td>
                        <div class="ico-down">
                            <a href="#!" id="show-down"><i class="fas fa-angle-down"></i></a>
                        </div>
                    </td>-->
                    <td>
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            {{$value->updated_at}}
                        </a>
                    </td>                    
                    <td>
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            {{$value->transactionid}}
                        </a>
                    </td>
                    <td>
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            {{$value->name}}
                        </a>
                    </td>
                    <td>
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            {{$value->email}}
                        </a>
                    </td>
                    @if($i != 1 && $i != 3 && $i != 6 && $i != 8)
                    <td>
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            @if($value->status == 2){{__('Completed')}} @elseif($value->status == 3){{__('Rejected')}} @else {{__('Pending')}} @endif
                        </a>
                    </td>
                    @endif
                    <td>
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            {{$value->balance}}@if($value->currency == 1){{__('$')}} @else {{__('€')}} @endif
                        </a>
                    </td>
                    @if($i != 2 && $i != 5 && $i != 7 && $i != 9)
                    <td>
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            @if($value->fee > 0){{$value->fee}}@else {{__('0.00')}}@endif
                        </a>
                    </td>
                    @endif
                    <td class="dark">
                        <a href="{{URL($module.'-'.$page.'-details/'.encrypt($rowid))}}" class="text-dark">
                            {{$value->descriptions}}
                        </a>
                    </td>
                    <td >
                        <a class="btn btn-archive clickarchive" id="{{$value->id}}" data-archivetype="@if($value->archieve == 1){{__('2')}}@else{{__('1')}}@endif">
                            @if($value->archieve == 1){{__('Archieve')}} @else {{__('Unarchieve')}} @endif
                        </a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr><td colspan="8">No Transaction Done</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    @endif
    @endfor
</div>