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
                <li class="breadcrumb-item active" aria-current="page"><a href="{{URL('/bank')}}">Bank</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Bank Account</li>
            </ol>
            <h6 class="slim-pagetitle">Add Bank Account</h6>
        </div>

        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <form action="@if(!empty($details)){{URL('/bank/'.$details->id)}}@else{{URL('/bank')}}@endif" name="addbank" method="post" class="from-group">
                        {{ csrf_field() }}
                        @if(!empty($details))
                        <input type="hidden" name="_method" value="put"/>
                        @endif
                        
                        <div class="form-group">
	                    <label for="bank" class="col-form-label">Bank Name:</label>
                            <input type="text" name="bank" class="form-control {{ $errors->has('bank') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->bank)){{$details->bank}}@else{{ old('bank') }}@endif">
                         @if ($errors->has('bank'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('bank') }}</strong>
                             </span>
                         @endif
	                </div>
                        <div class="form-group">
                            <label for="branch" class="col-form-label">Branch:</label>
                            <input type="text" name="branch" class="form-control {{ $errors->has('branch') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->branch)){{$details->branch}}@else{{ old('branch') }}@endif">
                            @if ($errors->has('branch'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('branch') }}</strong>
                             </span>
                         @endif
                        </div>
                        <div class="form-group">
                            <label for="bankcode" class="col-form-label">Bank Code:</label>
                            <input type="text" name="bankcode" class="form-control {{ $errors->has('bankcode') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->bankcode)){{$details->bankcode}}@else{{ old('bankcode') }}@endif">
                            @if ($errors->has('bankcode'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('bankcode') }}</strong>
                             </span>
                         @endif
                        </div>
                        <div class="form-group">
                            <label for="ifsccode" class="col-form-label">IFSC Code:</label>
                            <input type="text" name="ifsccode" class="form-control {{ $errors->has('ifsccode') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->ifsc)){{$details->ifsc}}@else{{ old('ifsccode') }}@endif">
                            @if ($errors->has('ifsccode'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('ifsccode') }}</strong>
                             </span>
                         @endif
                        </div>
                        <div class="form-group">
                               <label for="currency" class="col-form-label">Currency:</label>
                               <select name="currency" class="form-control">
                                 @if(count($currency) > 0)  
                                 @foreach($currency as $value)  
                                 <option value="{{$value->code}}">{{$value->code}}</option>
                                 @endforeach
                                 @endif
                               </select>
                               <!--<input type="text" name="currency" class="form-control {{ $errors->has('currency') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->currency)){{$details->currency}}@else{{ old('currency') }}@endif">-->
                               @if ($errors->has('currency'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('currency') }}</strong>
                             </span>
                         @endif
                        </div>
                        <div class="form-group">
                               <label for="acno" class="col-form-label">A/C No.:</label>
                               <input type="text" name="acno" class="form-control {{ $errors->has('acno') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->acno)){{$details->acno}}@else{{ old('acno') }}@endif">
                               @if ($errors->has('acno'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('acno') }}</strong>
                             </span>
                         @endif
                        </div>
                        <div class="form-group">
                               <label for="name" class="col-form-label">Name:</label>
                               <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" aria-invalid="false" value="@if(!empty($details->name)){{$details->name}}@else{{ old('name') }}@endif">
                               @if ($errors->has('name'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('name') }}</strong>
                             </span>
                         @endif
                        </div>
                        <div class="form-group">
	                    <label for="bankaddress" class="col-form-label">Bank Address:</label>
	                    <textarea class="form-control {{ $errors->has('bankaddress') ? ' is-invalid' : '' }}" name="bankaddress" spellcheck="false">@if(!empty($details->address)){{$details->address}}@else{{ old('bankaddress') }}@endif</textarea>
                            @if ($errors->has('bankaddress'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('bankaddress') }}</strong>
                             </span>
                         @endif
	                </div>
                        <div class="form-group">
                            <input type="submit" class="from-group btn btn-primary btn-signin btn-oblong" value="@if(!empty($details)){{__('Save')}}@else {{__('Add Account')}}@endif">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
