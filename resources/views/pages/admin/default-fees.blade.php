@extends('layouts.admin')
@section('content')
<style>
    .btn-signin{text-transform: capitalize;letter-spacing: 0px;}
    #add-cate{position: static !important;}
</style>
<div class="slim-mainpanel">
    <div class="container-fluid">
        <div class="slim-pageheader">            
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL('/admin')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Default Fees</li>
            </ol>
            <h6 class="slim-pagetitle">Default Fees</h6>
        </div>

        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="text-right">
                        @if (session('status'))
                                <div class=" main_alert alert alert-success alert-dismissible"> 
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('status') }}
                                </div>
                            @endif
                        <a href="{{route('defaultfees.create')}}" class="btn btn-primary btn-signin btn-oblong" id="add-cate" >Add New Fees</a>
                    </div>
                    <ul class="nav nav-tabs custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#percent">Percent Fees</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#flat">Flat Fees</a>
                                </li>
                            </ul> 
                    <!-- Tab panes -->
                    
                    <div class="tab-content custom-content">                        
                        <div id="percent" class="tab-pane  active">
                            <div class="table-responsive">
                                <table class="table table-bordered my-table" id="example">
                                    <thead>
                                        <tr>                  
                                            <th style="width:6%">Sr. No.</th>
                                            <th>For module</th>
                                            <th style="width:15%">Charge</th>
                                            <th style="width:15%">Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($fees)> 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                        @foreach($fees as $fee)
                                        @if($fee->charge_type == 1)
                                        <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>@if($fee->transaction_type == 1){{__('Request Money Fees')}}@elseif($fee->transaction_type == 2){{__('Invoice Fees')}}@else{{__('Currency Conversion Fees')}}@endif</td>
                                            <td>{{$fee->charge}} @if($fee->charge_type == 1){{__('   ( % )')}}@else{{__('   ( Flat )')}}@endif</td>                                                                                        
                                            <td>
                                                
                                                <form action="{{URL('/defaultfees/'.$fee->id.'/edit/')}}" method="get" class="btn btn-primary btn-signin btn-oblong a-btn">
                                                    <input type="submit" class="btn btn-primary btn-signin btn-oblong a-btn" value="Edit">
                                                </form>
                                                <form action="{{URL('/defaultfees/'.$fee->id)}}" method="post" class="btn btn-primary btn-signin btn-oblong a-btn">
                                                     {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="delete">
                                                    <input type="submit" class="btn btn-primary btn-signin btn-oblong a-btn" name="edit" value="Delete">
                                                </form>
                                            </td>
                                        </tr>
                                        @endif
                                        @php $i++; @endphp
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                        <div id="flat" class="tab-pane">
                            <div class="table-responsive">
                                <table class="table table-bordered my-table" id="example">
                                    <thead>
                                        <tr>                  
                                            <th style="width:6%">Sr. No.</th>
                                            <th>For module</th>
                                            <th style="width:15%">Charge</th>
                                            <th style="width:15%">Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($fees)> 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                        @foreach($fees as $fee) 
                                        @if($fee->charge_type == 2)
                                        <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>@if($fee->transaction_type == 1){{__('Request Money Fees')}}@elseif($fee->transaction_type == 2){{__('Invoice Fees')}}@else{{__('Currency Conversion Fees')}}@endif</td>
                                            <td>{{$fee->charge}} @if($fee->charge_type == 1){{__('   ( % )')}}@else{{__('   ( Flat )')}}@endif</td>                                                                                        
                                            <td>
                                                
                                                <form action="{{URL('/defaultfees/'.$fee->id.'/edit/')}}" method="get" class="btn btn-primary btn-signin btn-oblong a-btn">
                                                    <input type="submit" class="btn btn-primary btn-signin btn-oblong a-btn" value="Edit">
                                                </form>
                                                <form action="{{URL('/defaultfees/'.$fee->id)}}" method="post" class="btn btn-primary btn-signin btn-oblong a-btn">
                                                     {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="delete">
                                                    <input type="submit" class="btn btn-primary btn-signin btn-oblong a-btn" name="edit" value="Delete">
                                                </form>
                                            </td>
                                        </tr>
                                         @endif
                                        @php $i++; @endphp
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
