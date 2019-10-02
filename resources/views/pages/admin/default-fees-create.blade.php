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
                <li class="breadcrumb-item active" aria-current="page"><a href="{{URL('/defaultfees')}}">Default Fees</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Fees</li>
            </ol>
            <h6 class="slim-pagetitle">Add Fees</h6>
        </div>

        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <form action="@if(!empty($details)){{URL('/defaultfees/'.$details->id)}}@else{{URL('/defaultfees')}}@endif" name="addfees" method="post" class="from-group">
                        {{ csrf_field() }}
                        @if(!empty($details))
                        <input type="hidden" name="_method" value="put"/>
                        @endif
                        
                        <div class="form-group">
	                    <label for="charge_type" class="col-form-label">Fees Type:</label>
                            <select name="charge_type" class="form-control {{ $errors->has('charge_type') ? ' is-invalid' : '' }}">
                                <option value="1" @if(!empty($details->charge_type) && ($details->charge_type == 1)){{__('selected')}}@else {{__('selected')}}@endif> Percent Fees </option>                                
                                <option value="2" @if(!empty($details->charge_type) && ($details->charge_type == 2)){{__('selected')}}@endif> Flat Fees </option>                                
                            </select>
                         @if ($errors->has('charge_type'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('charge_type') }}</strong>
                             </span>
                         @endif
	                </div>
                        <div class="form-group">
	                    <label for="transaction_type" class="col-form-label">Transaction Type:</label>
                            <select name="transaction_type" class="form-control {{ $errors->has('transaction_type') ? ' is-invalid' : '' }}">
                                <option value="1" @if(!empty($details->transaction_type) && ($details->transaction_type == 1)){{__('selected')}}@else {{__('selected')}}@endif> Request Money Fees </option>                                
                                <option value="2" @if(!empty($details->transaction_type) && ($details->transaction_type == 2)){{__('selected')}}@endif> Invoice Fees </option>                                
                                <option value="3" @if(!empty($details->transaction_type) && ($details->transaction_type == 3)){{__('selected')}}@endif> Currency Conversion Fees </option>                                
                            </select>
                         @if ($errors->has('transaction_type'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('transaction_type') }}</strong>
                             </span>
                         @endif
	                </div>                        
                        <div class="form-group">
                            <label for="charge" class="col-form-label">Charge:</label>
                            <input type="text" name="charge" class="form-control {{ $errors->has('charge') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->charge)){{$details->charge}}@else{{ old('charge') }}@endif">
                            @if ($errors->has('charge'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('charge') }}</strong>
                             </span>
                         @endif
                        </div>                        
                        <div class="form-group">
                            <input type="submit" class="from-group btn btn-primary btn-signin btn-oblong" value="@if(!empty($details)){{__('Save')}}@else {{__('Add Fees')}}@endif">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
