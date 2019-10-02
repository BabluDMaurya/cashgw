@extends('layouts.businessdashboard')
@section('content')
<section class="main-content body_min_height ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block-item invoice-info shadow-block transaction_section">
                        <div class="row">
                            <div class="col-md-12">
                                @if(!empty($activity))
                                <div class="common_details">
                                        <div class="row top_details">
                                            <div class="col-md-4">
                                                <h3>Transaction Details</h3>
                                            </div>
                                            <div class="col-md-8">
                                               <p>{{$activity->updated_at}}</p> 
                                            </div>
                                        </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="common_details_para">
                                                <p class="name_font">{{$activity->name}}</p>
                                        <p><span>Email: </span>{{$activity->email}}</p>
                                        <p><span>Type:</span> @if($activity->type == 1){{__('Sent Money')}} @elseif($activity->type == 2) {{__('Request Money')}} @elseif($activity->type == 3) {{__('Sent Money')}} @elseif($activity->type == 4) {{__('Curency Conversion')}} @elseif($activity->type == 5) {{__('Sent Invoice')}} @elseif($activity->type == 6) {{__('Recive Invoice')}} @elseif($activity->type == 7) {{__('Paid Invoice')}}@else{{__('Request For Money To Admin')}} @endif</p>
                                        <p><span>Payment Status:</span><a href="#"> @if($activity->status == 2){{__('Completed')}} @elseif($activity->status == 3){{__('Rejected')}} @else {{__('Pending')}} @endif</a></p>
                                        <p> <span>Status:</span> New Request</p>
                                    </div>
                                        </div>
                                        <div class="col-md-4">
                                           <div class="common_details_para">
                                               <p class="unique_id"><span>Transaction ID</span> : {{$activity->transactionid}}</p>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="common_details_para">
                                                <ul>                                                    
                                                    <li class="amount_dollar">{{$activity->balance}}@if($activity->currency == 1){{__('USD')}} @else {{__('EUR')}} @endif</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-4">
                                    
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                    <div class="other_details_para">
                                        <p><span>Notes :</span> {{$activity->descriptions}}</p>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end">                                             
                                          @if(($activity->to_user_id == decrypt($user_id)))                                               
                                                <!--<button type="button" class="details_btn hvr-sweep-to-top">Reminder</button>-->
                                                <!--<button type="button" class="details_btn hvr-sweep-to-top">View All</button>-->
                                            @else  
                                                @if($activity->status != 2)
                                                    <form action="{{URL('/business-recived-request/'.$user_id)}}" method="post"> 
                                                       {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <input type="hidden" name="id" value="{{$activity->invoice_id}}" id="acceptrow" class="form-control  {{ $errors->has('id') ? ' is-invalid' : '' }}">
                                                    @if($errors->has('userid'))                                                
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                            <strong>{{ $errors->first('id') }}</strong>
                                                        </span> 
                                                    @endif
                                                    <input type="hidden" name="action" value="2" class="form-control  {{ $errors->has('action') ? ' is-invalid' : '' }}">
                                                    @if($errors->has('action'))                                                
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                            <strong>{{ $errors->first('action') }}</strong>
                                                        </span> 
                                                    @endif
                                                    <input type="submit" name="brrmaction" value="Pay Now" class="details_btn hvr-sweep-to-top">
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @else
                                    {{__('Data Not Available')}}
                                @endif
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
@endsection