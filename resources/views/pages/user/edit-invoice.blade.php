@extends('layouts.userdashboard')
@section('content')
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                @include('includes.invoice-menu')
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <form action="{{URL('/UpdateInvoiceData/')}}" class="common-form" id="InvoiceForm" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="title-equal-space">
                                                <div class="col-md-6">
                                                    <h5 class="block-title">Edit Invoice</h5>
                                                </div>
                                                @if(session('status'))                                                
                                                <div class="alert alert-success alert-dismissible" id="msg" style="margin-left: 33px;"> 
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{ session('status') }}
                                                </div>
                                                 @elseif($errors->has('item_name') || $errors->has('item_desc') || $errors->has('item_price'))
                                                    <div class="alert alert-danger alert-dismissible" style="margin-left: 33px;"> 
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    @if($errors->has('item_name'))
                                                        {{$errors->first('item_name')}}
                                                    @elseif($errors->has('item_desc'))
                                                        {{$errors->first('item_desc')}}
                                                    @elseif($errors->has('item_price'))
                                                        {{$errors->first('item_price')}}   
                                                    @endif    
                                                </div>
                                                @endif
                                                <div class="d-flex align-items-center">
                                                    <input type="button" class="preview_btn btn  round-btn  hvr-sweep-to-top  blue-btn" value="Preview">
                                                    <input type="button" form_type="3" class="form_type_status btn round-btn  hvr-sweep-to-top blue-btn" value="Save">
                                                    @if($SingleInvoiceDetails->invoice_status != 3 && $SingleInvoiceDetails->invoice_status !=5)
                                                    <input type="button" form_type="1" class="form_type_status btn round-btn  hvr-sweep-to-top blue-btn" value="Save As Draft">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{ csrf_field() }}
<!--                                        <div class="row filter-section">                                        
                                            <div class="select-boxes  border-bottom">
                                                <div class="d-flex select-with-label">
                                                    <label>Invoice Category</label>
                                                    <select class="form-control {{ $errors->has('invoice_category_id') ? ' is-invalid' : '' }}" name="invoice_category_id" id="invoice_category_id">
                                                        <option value="">Please select category</option>                                                                                                  
                                                        @foreach($allCategory as $categories)                                                                                              
                                                        <option value="{{$categories->id}}" {{$SingleInvoiceDetails->invoice_cat_id == $categories->id ? 'selected' : ''}}>{{$categories->category_name}}</option>                                                    
                                                        @endforeach                                              
                                                    </select>
                                                    @if($errors->has('invoice_category_id'))                                                
                                                    <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('invoice_category_id') }}</strong>
                                                    </span> 
                                                    @endif
                                                </div>                                         
                                            </div>
                                        </div>                                    -->
                                        <section class="data-section">                                        
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="common-form pos_rel">
                                                        <div class="form-group row">
                                                            <label for="invoice_number" class="col-lg-4 col-form-label ">Invoice number</label>
<!--                                                            @php
                                                            $fname = strtoupper($individualKyc->fname[0]);
                                                            $lname = strtoupper($individualKyc->lname[0]);        
                                                            $randstring = mt_rand(1000,9000);         
                                                            $todaydate = date('Ymd');

                                                            $invoicenumber = 'CG'.$todaydate.$fname.$lname.$randstring;
                                                            @endphp-->
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" value="{{$SingleInvoiceDetails->invoice_number}}" name="invoice_number" readonly="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="invoice_date" class="col-lg-4 col-form-label ">Invoice date</label>
                                                            <div class="col-lg-8">
                                                                <div class="input-group">
                                                                    @php
                                                                    $date = $SingleInvoiceDetails->invoice_date;
                                                                    $newData = new DateTime($date);
                                                                    $date = $newData->format('d-m-Y')
                                                                    @endphp
                                                                    <input type="text" class="form-control datepicker {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}" placeholder="" name="invoice_date" autocomplete="off" value="{{$date}}">
                                                                    <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                    </div>
                                                                </div>
                                                                @if($errors->has('invoice_date'))                                                
                                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                                    <strong>{{ $errors->first('invoice_date') }}</strong>
                                                                </span> 
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="reference" class="col-lg-4 col-form-label ">Reference</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" placeholder="Such as PO #" name="reference" value="{{$SingleInvoiceDetails->reference}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="due_date" class="col-lg-4 col-form-label ">Due Date</label>
                                                            <div class="col-lg-8">
                                                                @php
                                                                $date = $SingleInvoiceDetails->invoice_date; 
                                                                $createdDate = date("Y-m-d", strtotime($date));
                                                                $dueDate = $SingleInvoiceDetails->due_date_value;
                                                                $diff = abs(strtotime($dueDate) - strtotime($createdDate));
                                                                $days = floor(($diff / (60*60*24)));
                                                                @endphp
                                                                <select class="form-control {{ $errors->has('due_date') ? ' is-invalid' : '' }}" name="due_date">
                                                                    <option value="" selected="">Due on receipt</option>
                                                                    <option value="10" {{ ($days == 10) ? "selected" : "" }} >Due in 10 Days</option>
                                                                    <option value="20" {{ ($days == 20) ? "selected" : "" }}>Due in 20 Days</option>
                                                                    <option value="30" {{ ($days == 30) ? "selected" : "" }}>Due in 30 Days</option>
                                                                    <option value="40" {{ ($days == 40) ? "selected" : "" }}>Due in 40 Days</option>
                                                                </select>
                                                                @if($errors->has('due_date')    )                                                
                                                                <span class="invalid-feedback" role="alert" style="display: block">
                                                                    <strong>{{ $errors->first('due_date') }}</strong>
                                                                </span> 
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 no-flex">
                                                    <div class="fileinput fileinput-exists" data-provides="fileinput">  
                                                        <div class="fileinput-preview fileinput-exists thumbnail">  
                                                                @php
                                                                    if(isset($SingleInvoiceDetails['business_logo']) && $SingleInvoiceDetails['business_logo'] != 'logo.png'){
                                                                        $img = $individualKyc->user_id."/".$SingleInvoiceDetails['business_logo'];
                                                                    }else{
                                                                        $img = $SingleInvoiceDetails['business_logo'];
                                                                    }
                                                                @endphp 
                                                            <img src="{{url('/public/images/')}}/@if(isset($SingleInvoiceDetails['business_logo'])){{$SingleInvoiceDetails['business_logo']}}@else{{$individualKyc->photo}}@endif" id="business_logo">                                                   
                                                        </div>
                                                        <div>
                                                            <span class="btn default btn-file">
                                                                <span class="fileinput-new">
                                                                    Select image </span>
                                                                <span class="fileinput-exists">
                                                                    Change </span>
                                                                <input type="hidden">
                                                                <input type="file" name="invoice_business_logo">
                                                                <input type="hidden" name="invoice_business_logo_pre" value="@if(isset($SingleInvoiceDetails['business_logo'])){{$img}}@else{{$individualKyc->photo}}@endif">
                                                            </span>
                                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                                Remove </a>
                                                        </div>
                                                    </div>
                                                    <div class="bus-info">
                                                        <a href="#!" class="more-bus-in"> <i class="fas fa-angle-down"></i></a>  Your Business Information                                                    
                                                    </div>
                                                    <div class="bus-det">                                                        
                                                        <span id="business_name"></span><br>
                                                        <input type="hidden" id="business_name_input" name="business_name" value="@if(isset($getBusinessInfoDetails['business_name'])){{$getBusinessInfoDetails['business_name']}}@else{{$SingleInvoiceDetails->business_name}}@endif">
                                                        <span id="first_name">@if(isset($getBusinessInfoDetails['first_name'])){{$getBusinessInfoDetails['first_name']}}@else{{$individualKyc->fname}}@endif</span><br>
                                                        <input type="hidden" id="first_name_input" name="first_name" value="@if(isset($getBusinessInfoDetails['first_name'])){{$getBusinessInfoDetails['first_name']}}@else{{$individualKyc->fname}}@endif">
                                                        <span id="address">
                                                            @if(isset($getBusinessInfoDetails['address']))
                                                                {{$getBusinessInfoDetails['address']}}
                                                            @else
                                                                {{$individualKyc->town_or_city}}<br>{{$individualKyc->state}}<br>{{$individualKyc->country}}
                                                            @endif
                                                        </span><br>  
                                                        <input type="hidden" id="address_input" name="address" value="
                                                               @if(isset($getBusinessInfoDetails['address']))
                                                                    {{$getBusinessInfoDetails['address']}}
                                                               @else
                                                                    {{$individualKyc->town_or_city}},{{$individualKyc->state}},{{$individualKyc->country}}
                                                               @endif
                                                               ">
                                                        <i class="fas fa-phone"></i> <span id="phone">
                                                            @if(isset($getBusinessInfoDetails['phone']))
                                                                {{$getBusinessInfoDetails['phone']}}
                                                            @else
                                                                {{$individualtwodetails->primary_phone}}
                                                            @endif
                                                        </span><br>  
                                                        <input type="hidden" id="phone_input" name="phone" value="
                                                               @if(isset($getBusinessInfoDetails['phone']))
                                                                {{$getBusinessInfoDetails['phone']}}
                                                            @else
                                                                {{$individualtwodetails->primary_phone}}
                                                            @endif
                                                               ">
                                                        <i class="fas fa-envelope"></i> <span id="email_id">
                                                            @if(isset($getBusinessInfoDetails['email_id']))
                                                                {{$getBusinessInfoDetails['email_id']}}
                                                            @else
                                                                {{$individualtwodetails->primary_email}}
                                                            @endif
                                                        </span>
                                                        <input type="hidden" id="email_id_input" name="mailToSender" value="
                                                               @if(isset($getBusinessInfoDetails['email_id']))
                                                                {{$getBusinessInfoDetails['email_id']}}
                                                            @else
                                                                {{$individualtwodetails->primary_email}}
                                                            @endif
                                                               ">
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="bill-to-sec">                                        
                                            <div class="form-group row">
                                                <div class=" d-flex w-100">
                                                    <div class="col-lg-1">
                                                        <label class="col-form-label ">Bill to:</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control {{ $errors->has('bill_to_email') ? ' is-invalid' : '' }}" id="InvoiceBillTo" name="bill_to_email" value="{{$SingleInvoiceDetails->bill_to_email}}" placeholder="Enter Email address">
                                                        @if($errors->has('bill_to_email'))                                                
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                            <strong>{{ $errors->first('bill_to_email') }}</strong>
                                                        </span> 
                                                        @endif
                                                        <div id="optionEmail" style="display:none">
                                                            <ul>
                                                                <li class="addItemIcon">Add new customer</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <a href="#!" class="contact-book" data-toggle="modal" data-target="#address-book-modal"><img src="{{URL('public/images/contact.png')}}"></a>
                                                        <a href="#!" id="bill-multiple" class="btn  round-btn  hvr-sweep-to-top  blue-btn"><i class="fas fa-plus"></i> Bill CC customers </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($SingleInvoiceDetails->cc_email))
                                            <div class="form-group row" id="cc" style="display: block">
                                                <div class=" d-flex w-100">
                                                    <div class="col-lg-1">
                                                        <label for="cc" class="col-form-label ">CC:</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name="cc_email" placeholder="Enter Email address" value="{{$SingleInvoiceDetails->cc_email}}">
                                                    </div>
                                                </div>
                                            </div> 
                                            @else
                                            <div class="form-group row" id="cc">
                                                <div class=" d-flex w-100">
                                                    <div class="col-lg-1">
                                                        <label for="cc" class="col-form-label ">CC:</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" name="cc_email" placeholder="Enter Email address">
                                                    </div>
                                                </div>
                                            </div> 
                                            @endif
                                        </section>   
                                        <section class="light-gray-bg">
                                            <label>Customize</label>
                                            <div class="d-flex select-boxes customize-select" style="width: 100%;">                                                
                                                <select class="form-control border-none" id="taxTypeSelect" name="taxTypeSelect" style="width: 20%;">  
                                                    <option value="{{encrypt(0)}}">Select Tax</option>        
                                                    @foreach($allTaxList as $taxes)
                                                    @if($taxes->id == $SingleInvoiceDetails->tax_id)
                                                    @php
                                                    $selected = 'selected';
                                                    @endphp
                                                    @else
                                                    @php
                                                    $selected = '';
                                                    @endphp
                                                    @endif
                                                    <option value="{{$taxes->id}}" taxValue="{{$taxes->tax_rate}}" {{$selected}}>{{$taxes->tax_name}} {{$taxes->tax_rate}}%</option>
                                                    @endforeach                                                                                                      
                                                </select>                                                   
                                                <select class="form-control" style="width: 25%;" id="selectCurrency" name="select_currency"> 
                                                    @foreach($currencyMaster as $currency)
                                                    @if($currency->id == $SingleInvoiceDetails->currency)
                                                    @php
                                                    $selected = 'selected';
                                                    $currencySymbol = $currency->symbol;
                                                    @endphp
                                                    @else
                                                    @php
                                                    $selected = '';
                                                    @endphp
                                                    @endif
                                                    @if(!isset($currencySymbol))
                                                    @php
                                                    $currencySymbol = $currencyMaster[0]->symbol;
                                                    @endphp
                                                    @endif
                                                    <option value="{{$currency->id}}" CurrencySymbol="{{$currency->symbol}}" {{$selected}}>{{$currency->name}}({{$currency->symbol}})</option>
                                                    @endforeach                                                      
                                                </select> 
                                                    <input type="hidden" value="{{$currencySymbol}}" name="hiddenCurrencySymbol" id="hiddenCurrencySymbol">
                                            </div>
                                        </section>
                                        <table class="table table-bordered my-table mb-0 mt-20 complicate-table">
                                            <thead>
                                            <th width="300px">Description</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Tax</th>
                                            <th width="150px">Amount</th>
                                            <th width="50px">&nbsp;</th>
                                            </thead>
                                            <tbody class="tbodycls" id="getAjaxItemDetailsDiv">
                                                @if(count($invoiceItemList)>0)
                                                @foreach($invoiceItemList as $items)
                                                <tr>
                                                    <td class="edit-table">
                                                        <input type="text" class="form-control" value="{{$items->item_name}}" name="item_name[]" placeholder="Item Name">        
                                                    </td>
                                                    <td class=""><input name="item_quantity[]" type="number" min="1" value="@if($items->item_quantity > 0){{$items->item_quantity}}@else{{__('1')}}@endif" class="form-control input-custom mr-15 itemQuantity"></td>
                                                    <td class=""><input name="item_price[]" type="number" min="0" value="{{$items->item_price}}" class="form-control input-custom mr-15 itemPrice"></td>
                                                    <td>
                                                        <select class="form-control border-none itemTax" id="optax" name="item_tax_id[]">
                                                            <option value="0" tax_rate="0">No Tax</option>
                                                            @foreach($allTaxList as $taxes)
                                                            @if($taxes->id == $SingleInvoiceDetails->tax_id)
                                                            @if($taxes->id == $items->item_tax_id)
                                                            @php
                                                            $selected = 'selected';
                                                            @endphp
                                                            @else
                                                            @php
                                                            $selected = '';
                                                            @endphp
                                                            @endif
                                                            <option value="{{$taxes->id }}" tax_rate="{{$taxes->tax_rate}}" {{$selected}}>{{$taxes->tax_name}} {{$taxes->tax_rate}}%</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </td>    
                                                    <td class="gre-bg-td"><input name="item_amount[]" type="text" value="" class="form-control input-custom mr-15 itemAmount" readonly></td>
                                                    <td class="text-center delete-tbody"><i class="far fa-trash-alt"></i></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="edit-table">        
                                                        <input type="text" class="form-control" value="{{$items->item_desc}}" name="item_desc[]" placeholder="Enter Description">    
                                                        <input type="hidden" name="itemId[]" value="{{encrypt($items->id)}}"
                                                    </td>
                                                    <td class="gre-bg-td">&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                @endforeach
                                                @else
                                            <h4 >No Record Found</h4>
                                            @endif
                                            </tbody>
                                            <tfoot>
                                            <td colspan="6">
                                                <p class="add-another text-right"><i class="fas fa-plus-circle"></i> Add Line item</p>
                                            </td>
                                            </tfoot>
                                        </table>
                                        <table class="table table-bordered">
                                            <tbody class="">
                                                <tr>
                                                    <td class="" width="300px">
                                                    </td>
                                                    <td >&nbsp;</td>
                                                    <td >&nbsp;</td>
                                                    <td >Subtotal</td>
                                                    <td width="150px" class="gre-bg-td psubtotal" id=""> 
                                                        <input type="text" name="invoice_subtotal" value="$ 0.00" class="form-control input-custom mr-15" id="subtotalValue" readonly>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td class="" width="300px">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td class="d-flex align-items-center">
                                                        <span class="mr-15">Discount </span>
                                                        <div class="common-form d-flex mb-0 align-items-center select-boxes w-100">
                                                            <input type="number"  min="0" max="100"  class="form-control input-custom mr-15" name="invoice_discount_in_percent" id="discountValue" value="{{$SingleInvoiceDetails->invoice_discount_in_percent}}">
                                                            <select class="form-control border-none">
                                                                <option>%</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td width="150px" class="gre-bg-td" id=""> 
                                                        <input type="text" value="$ 0.00" class="form-control input-custom mr-15" name="invoice_discount_in_value" id = "totalDiscountValue" readonly>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td class="" width="300px">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td class="d-flex align-items-center">
                                                        <span class="mr-15">Shipping </span>
                                                        <div class="common-form d-flex mb-0 align-items-center select-boxes">
                                                            <input type="number" min="0" class="form-control input-custom mr-15" id="shippingValue" value="{{$SingleInvoiceDetails->invoice_shipping}}">
                                                        </div>
                                                    </td>
                                                    <td width="150px" class="gre-bg-td" id=""> 
                                                        <input type="text" value="$ 0.00" class="form-control input-custom mr-15" name="invoice_shipping"  id="totalShippingValue" readonly>
                                                    </td>
                                                    
                                                </tr>
                                                <tr class="light-blue-bg">
                                                    <td class="" width="300px">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td class="d-flex align-items-center">
                                                        <span class="mr-15">Total </span>
                                                    </td>
                                                    <td width="150px" class="gre-bg-td ptotal" id=""> 
                                                        <input type="text" value="$ 0.00" name="invoice_grand_total" class="form-control input-custom mr-15" id="grandTotal" readonly>
                                                    </td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                        <section class="last-two-block pb-60">
                                            <div class="row">
                                                <div class="col-md-6 no-flex">
                                                    <h6>Notes to recepient</h6>
                                                    <textarea class="form-control" name="notes_to_recepient">{{$SingleInvoiceDetails->notes_to_recepient}}</textarea>
                                                </div>
                                                <div class="col-md-6 no-flex">
                                                    <h6>Terms and Conditions</h6>
                                                    <textarea class="form-control" name="terms_and_conditions">{{$SingleInvoiceDetails->terms_and_conditions}}</textarea>
                                                </div>
                                                <div class="col-md-6  no-flex mt-20 file_pos pos_rel ">
                                                    <h6>Attach File</h6>                                                
                                                    <div class="form-group file_over_unset">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="input-group input-large">
                                                                <div class="form-control uneditable-input" data-trigger="fileinput">
                                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
                                                                    </span>
                                                                </div>
                                                                <span class="input-group-addon btn default btn-file">
                                                                    <span class="fileinput-new">
                                                                        Select file </span>
                                                                    <span class="fileinput-exists">
                                                                        Change </span>
                                                                    <input type="file" name="invoice_attach_file" id="file-preview-show" multiple="multiple" type="file" />
                                                                </span>
                                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                                                    Remove </a>
                                                                <div id="ind-edit-attach-file">
                                                                    @php
                                                                    if(!empty($SingleInvoiceDetails->attach_file)){
                                                                        $attach = $individualKyc->user_id."/".$SingleInvoiceDetails->attach_file;
                                                                    }else{
                                                                        $attach = '';
                                                                    }
                                                                @endphp 
                                                                @if($attach !='')
                                                                    <img src="{{url('/public/images/')}}/{{$attach}}" class="preview-thumb-image">
                                                                @endif    
                                                            </div>
                                                        </div>
                                                    </div>                                               
                                                </div>
                                                </div>
                                                <div class="col-md-6 no-flex mt-20">
                                                    Add Memo to self
                                                    <textarea class="form-control" name="add_memo_to_self">{{$SingleInvoiceDetails->add_memo_to_self}}</textarea>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="footer-section">
                                            <div class="d-flex align-items-center">                                               
                                                <input type="hidden" name="status_value" value="" id="invoice_status">
                                                <input type="hidden" name="invoiceId" value="{{encrypt($SingleInvoiceDetails->id)}}" id="invoiceId">
                                                <input type="button" form_type="3" class="form_type_status btn round-btn  hvr-sweep-to-top blue-btn" value="Save">
                                            </div>
                                        </section>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</section>
<div class="modal fade invoice-preview" id="preview-modal">
    <div class="modal-dialog modal-xlg" style="max-width: 1000px;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Invoice Preview</h4>
                <button type="button" class="close" data-dismiss="modal">X</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="previewTxt"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="address-book-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Address Book</h4>
                <button type="button" class="close" data-dismiss="modal">X</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <!--<p class="text-center">When you add a currency, any payments you receive in that currency will be credited to that balance. We'll use your primary currency when you send or request payments.</p>-->
                <div class="form-group">
                    <input id="myInput" type="text" class="form-control round-btn" placeholder="Email addresses">
                </div>
                <ul class="account-list currency-list" style="max-height: 270px !important;overflow-y: auto !important;">
                    @if(count($addressBookContacts)>0)
                    @foreach($addressBookContacts as $contacts)
                    <li class="listAB">
                        <div class="img-card">
                            <img src="{{url('/public/images/default.jpg')}}">
                        </div>
                        <div>
                            <label class="l-radio">
                                <span>{{$contacts->email}}</span>
                                <input type="radio" name="contEmail" value="{{$contacts->email}}">
                                <span class="checkmark"></span>
                            </label>                     
                        </div>
                    </li>  
                    @endforeach
                    @endif
                </ul>
                <a id="addEmailBillTo" class="btn dark-btn round-btn btn-block w-100 hvr-sweep-to-top l-btn">Add</a>
            </div>
        </div>
    </div>
</div>


<!--======================== Add Address Modal Start ================================-->

<div class="modal fade show" id="add-address" style="padding-right: 17px; display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Add Address</h4>
                <button type="button" class="close" data-dismiss="modal">X</button>
            </div>
            <form id="AddressBookAdd" action="{{URL('/address-book')}}" method="post">
                {{ csrf_field() }}      
                <!-- Modal body -->            
                <div class="modal-body">                
                    <div class="row">
                        <div class="col-md-6 form-group required no-flex">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fname">
                        </div> 
                        <div class="col-md-6 form-group no-flex">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required no-flex">
                            <label>Recipients email address</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="col-md-6 form-group no-flex">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                    </div>                
                    <div class="margin-auto">
                        <input type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20" value="Submit"> 
                    </div>            
                </div>
            </form>                              
        </div>
    </div>
</div>
<!--======================== Add Address Modal End ================================-->

<link href="{{URL('public/css/bootstrap-datepicker.css')}}" rel="stylesheet"/>
<script src="{{URL('public/js/bootstrap-datepicker.js')}}"></script> 
<link href="{{URL('public/css/bootstrap-tagsinput.css')}}" rel="stylesheet"/>
<script src="{{URL('public/js/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<style>
    .datepicker-dropdown {
        top: 242px;
    }
    
</style>
<script>
var token = '{{csrf_token()}}';
window.FontAwesomeConfig = {
    searchPseudoElements: true
}
</script>
<script>

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        startDate: '-0m'
    }).on('changeDate', function(ev){
        $('#sDate1').text($('.datepicker').data('date'));
        $('#datepicker').datepicker('hide');
    });
    jQuery(document).ready(function () {
        $('.edit-table').attr('contenteditable', 'true');
        jQuery('.more-bus-in').on('click', function (event) {
            jQuery('.bus-det').slideToggle();
            $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
            ;
        });

    });
</script>
<script>
    $(function () {
        $(".add-another").on('click', function () {
            $(this).parent().parent().parent().parent().before().append(
                    '<tr>' +
                    '<td class="edit-table" contenteditable="true"><input type="text" name="item_name[]" class="form-control" value="" placeholder="Item Name"></p></td>' +
                    '<td class=""><input name="item_quantity[]" type="number" min="1" value="1" class="form-control input-custom mr-15 itemQuantity"></td>' +
                    '<td class=""><input name="item_price[]" type="number" min="0" value="0.00" class="form-control input-custom mr-15 itemPrice"></td>' +
                    '<td><select class="form-control border-none itemTax" id="optax" name="item_tax_id[]">' +
                    '<option value="0" tax_rate="0">No Tax</option>' +
                    '</select></td>' +
                    '<td class="gre-bg-td"><input type="text" name="item_amount[]" value="$ 0.00" class="form-control input-custom mr-15 itemAmount" readonly></td> <td class="text-center delete-tbody"><i class="far fa-trash-alt"></i></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="4" class="edit-table" contenteditable="true"><input name="item_desc[]" type="text" class="form-control" value="" placeholder="Enter Description"></td>' +
                    '<td class="gre-bg-td">&nbsp;</td>' +
                    '<td>&nbsp;</td>' +
                    '</tr>');
            calculateTotalInvoice();
        });

        $("#bill-multiple").on('click', function () {
            jQuery('#cc').slideToggle();
        });

        //Sushmita
        $(document).delegate('.itemQuantity,.itemPrice,.itemTax,#discountValue,#shippingValue', 'keyup click', function () {
            calculateTotalInvoice();
        });
        $(document).delegate('.itemTax', 'change', function () {
            calculateTotalInvoice();
        });

        calculateTotalInvoice();

        function calculateTotalInvoice() {

            var selected_currency = $('#selectCurrency :selected').attr('CurrencySymbol');
            var inputLength = $('.itemAmount').length;
            var itemQuantity = 0;
            var itemPrice = 0;
            var itemTax = 0;
            var itemAmount = 0;
            var subtotalValue = 0;
            var shippingValue = 0;
            var discountValue = 0;
            var grandTotal = 0;

            for (var i = 0; i < inputLength; i++) {
                itemQuantity = $('.itemQuantity').eq(i).val().trim();
                itemPrice = $('.itemPrice').eq(i).val().trim();
                itemTax = $('.itemTax :selected').eq(i).attr('tax_rate').trim();
                itemAmount = itemQuantity * itemPrice + (itemQuantity * itemPrice * itemTax / 100);
                subtotalValue += itemAmount;
                $('.itemAmount').eq(i).val(selected_currency + ' ' + parseFloat(itemAmount).toFixed(2));
            }

            $('#subtotalValue').val(selected_currency + ' ' + parseFloat(subtotalValue).toFixed(2));
            grandTotal = parseFloat(subtotalValue);

            discountValue = $('#discountValue').val();
            if (discountValue != '') {
                var totalDiscountValue = (grandTotal * discountValue / 100);
                grandTotal = grandTotal - totalDiscountValue;
                $('#totalDiscountValue').val(selected_currency + ' ' + parseFloat(totalDiscountValue).toFixed(2));
            } else {
                $('#totalDiscountValue').val(selected_currency + ' 0.00');
            }

            shippingValue = $('#shippingValue').val();
            if (shippingValue != '') {
                grandTotal = parseFloat(grandTotal) + parseFloat(shippingValue);
                $('#totalShippingValue').val(selected_currency + ' ' + parseFloat(shippingValue).toFixed(2));
            } else {
                $('#totalShippingValue').val(selected_currency + '  0.00');
            }

            $('#grandTotal').val(selected_currency + ' ' + parseFloat(grandTotal).toFixed(2));
            // console.log(grandTotal);
        }

        $(document).on('click', ".delete-tbody", function () {
            var selftbody = $(this);
            selftbody.parent().next().remove();
            selftbody.parent().remove();
            calculateTotalInvoice();
        });

        $(document).on('click', '#addEmailBillTo', function () {
            var radioValue = $("input[name='contEmail']:checked").val();
            $('#InvoiceBillTo').val(radioValue);
            $('#address-book-modal').modal('toggle');

        });

        $(document).on('change', '#invoice_category_id', function () {
            $('#taxTypeSelect').prop('selectedIndex', 0);
            getBusinessInfoOnCatChange();
            ItemListOnCatChange();
        });

        $('#taxTypeSelect').change(function () {
            var taxObj = $(this).children("option:selected");
            var selTaxVal = taxObj.val();
            var selTaxText = taxObj.text();
            var tax_rate = $('#taxTypeSelect :selected').attr('taxValue');
            $('.itemTax').each(function () {
                $(this).children('option').eq(1).remove();
                if (selTaxVal != 0) {
                    $(this).append('<option value="' + selTaxVal + '" tax_rate="' + tax_rate + '">' + selTaxText + '</option>');
                }
            });
            calculateTotalInvoice();
        });


        function getBusinessInfoOnCatChange() {
            var selected_id = $('#invoice_category_id').val();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: BASE_URL + '/BusinessInfoOnChangeInvoiceCategory',
                type: "POST",
                data: {"selected_id": selected_id},
                success: function (result)
                {
                    obj = JSON.parse(result);
                    if (obj.business_logo != undefined) {
                        var src = IMAGE_URL + obj.user_id + "/" + obj.business_logo;
                    } else {
                        var src = IMAGE_URL + 'logo.png';
                    }
                    $('#business_logo').attr('src', src);
                    $('#business_name').text(obj.business_name);
                    $('#business_name_input').val(obj.business_name);
                    $('#first_name').text(obj.first_name);
                    $('#first_name_input').val(obj.first_name);
                    $('#address').text(obj.address);
                    $('#address_input').val(obj.address);
                    $('#phone').text(obj.phone);
                    $('#phone_input').val(obj.phone);
                    $('#email_id').text(obj.email_id);
                    $('#email_id_input').val(obj.email_id);
                }
            });
        }

        function ItemListOnCatChange() {
            var selected_id = $('#invoice_category_id').val();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: BASE_URL + '/GetItemsOnChangeInvoiceCategory',
                type: "POST",
                data: {"selected_id": selected_id},
                success: function (result)
                {
                    $('#getAjaxItemDetailsDiv').html(result);
                    calculateTotalInvoice();
                }
            });
        }


        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("li.listAB").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                $(".account-list li").css("border-bottom", "none");
            });
        });

        $(document).on('click', '.form_type_status', function (e) {
            var status_val = $(this).attr("form_type");
            $('#invoice_status').val(status_val);
            if ($('#InvoiceForm').valid()){
                $('.loader').show();
            $('#InvoiceForm').submit();
            } else {           
                e.preventDefault();
                $('.loader').hide();
            }            
        });

        $(document).on('change', '#selectCurrency', function () {
            var selectedsymbol = $('option:selected', this).attr('CurrencySymbol');
            $('#hiddenCurrencySymbol').val(selectedsymbol);
            calculateTotalInvoice();
        });


        $(document).on('click', '.preview_btn', function () {
            //var formData = ($('#InvoiceForm').serializeArray());
            var formData = new FormData($('#InvoiceForm')[0]);
            var imageObj = $('input[name="invoice_business_logo"]')[0].files[0];

            if (imageObj != undefined) {
                var imageData = btoa($('input[name="invoice_business_logo"]')[0].files[0].result);
                formData.set('invoice_business_logo', imageData);
            }

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: BASE_URL + '/GetInvoicePreview',
                type: "POST",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (result)
                {
                    $('#preview-modal').modal('show');
                    $('#previewTxt').html(result);
                }
            });
        });


        $("#InvoiceForm").validate({
            errorElement: 'span',
            errorClass: 'invalid-feedback',

            rules: {
                invoice_category_id: {
                    required: true,
                },
                invoice_date: {
                    required: true,
                },
                due_date: {
                    required: true,
                },
                bill_to_email: {
                    required: true,
                },
                invoice_attach_file :{
                    extension: true,
                },
                notes_to_recepient:{
                   maxlength:300,
                },
                terms_and_conditions:{
                    maxlength:300,
                },
                add_memo_to_self:{
                    maxlength:300,
                }
            },

            highlight: function (element) {
                // add a class "has_error" to the element 
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                // remove the class "has_error" from the element 
                $(element).removeClass('is-invalid');
            },
            messages: {
                invoice_category_id: {
                    required: "Category Required",
                },
                invoice_date: {
                    required: "Invoice date Required",
                },
                due_date: {
                    required: "Due Date Required",
                },
                bill_to_email: {
                    required: "Email Id Required",
                },
                invoice_attach_file :{
                    extension:"jpg,png,jpeg Allowed",
                },
                notes_to_recepient:{
                    maxlength:"Maximum 300 character required",
                },
                terms_and_conditions:{
                    maxlength:"Maximum 300 character required",
                },
                add_memo_to_self:{
                    maxlength:"Maximum 300 character required",
                }
            },
        });

    });

    $(document).on('keyup', '#InvoiceBillTo', function () {
        var userEmail = $(this).val();
        if (userEmail !== '') {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: BASE_URL + '/get-all-users-email',
                type: 'POST',
                data: {userEmail: userEmail},
                success: function (result) {
                    var allData = $.trim(result);
                    $('#optionEmail').html(allData);
                }
            });
        } else {
            $('#optionEmail').html('<ul><li class="addItemIcon">Add new customer</li></ul>');
        }
    });

    $(document).on('focus', '#InvoiceBillTo', function () {
        $('#optionEmail').show();
    });
    $(document).on('click', '.emailList', function (e) {
        e.preventDefault();
        var selectedEmail = $(this).text();
        // debugger;
        $('#InvoiceBillTo').val(selectedEmail);
        $('#optionEmail').hide();
        $('#optionEmail').html('<ul><li class="addItemIcon">Add new customer</li></ul>');
    });
    $(document).on('focusout', '#InvoiceBillTo', function(){
        window.setTimeout(function(){  $('#optionEmail').hide(); }, 500);
    });

    $(document).on('click', '.addItemIcon', function (e) {
        e.preventDefault();
        $('#add-address').modal('show');
        $('#optionEmail').html('<ul><li class="addItemIcon">Add new customer</li></ul>');
        $('#InvoiceBillTo').val('');
    });

    //address book validation 

    $.validator.addMethod("alpha", function (value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
    });
    $.validator.addMethod("customEmail", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
    }, "Please enter valid email address!");

    $.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");

    $("#AddressBookAdd").validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',

        rules: {
            fname: {
                required: true,
                alpha: true
            },
            lname: {
                required: true,
                alpha: true
            },
            email: {
                required: true,
                customEmail: true,
                remote: {
                    url: BASE_URL + '/check_addressbook_email',
                    type: 'POST',
                    data: {
                        email: function ()
                        {
                            return $('#AddressBookAdd :input[name="email"]').val();
                        },
                        _token: token,
                    },
                }
            },
            phone: {
                required: true,
                phoneUS: true
            },
        },

        highlight: function (element) {
            // add a class "has_error" to the element 
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            // remove the class "has_error" from the element 
            $(element).removeClass('is-invalid');
        },
        messages: {
            fname: {
                required: "First Name Required",
                alpha: "Only Alphabets allow",
            },
            lname: {
                required: "Last Name Required",
                alpha: "Only Alphabets allow",
            },
            email: {
                required: "Email Address Required",
                customEmail: "Please enter Valid Email",
                remote: "Already in use."
            },
            phone: {
                required: "Phone Number Required",
                phoneUS: "Only 10 Digit Numbers",
            },
        },
    });
</script>
<style>
    table.complicate-table tr:nth-child(even) {
        border-bottom: 2px solid #c1c1c1;
    }    
</style>
<script>
$(document).ready(function() {
        $("#file-preview-show").on('change', function() {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#ind-edit-attach-file");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "preview-thumb-image"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
//            alert("Pls select only images");
          }
        });
      });
</script>
@endsection

