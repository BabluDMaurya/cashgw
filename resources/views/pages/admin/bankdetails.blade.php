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
                <li class="breadcrumb-item active" aria-current="page">Bank Details</li>
            </ol>
            <h6 class="slim-pagetitle">Bank Details</h6>
        </div>

        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                        <div class="form-group">
                            <label for="bank" class="col-form-label">Bank Name: </label>
                            <strong>{{ $details->bank}}</strong>
	                </div>
                        <div class="form-group">
                            <label for="branch" class="col-form-label">Branch: </label>
                            <strong>{{ $details->branch}}</strong>
                        </div>
                        <div class="form-group">
                            <label for="bankcode" class="col-form-label">Bank Code: </label>                            
                            <strong>{{ $details->bankcode}}</strong>
                        </div>
                        <div class="form-group">
                            <label for="ifsccode" class="col-form-label">IFSC Code: </label>                            
                            <strong>{{ $details->ifsc}}</strong>
                        </div>
                        <div class="form-group">
                            <label for="currency" class="col-form-label">Currency: </label>                               
                            <strong>{{ $details->currency}}</strong>
                        </div>
                        <div class="form-group">
                            <label for="acno" class="col-form-label">A/C No.: </label>         
                            <strong>{{ $details->acno}}</strong>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name: </label>       
                            <strong>{{ $details->name}}</strong>
                        </div>
                        <div class="form-group">
                            <label for="bankaddress" class="col-form-label">Bank Address: </label>	                    
                            <strong>{{ $details->address}}</strong>
	                </div>
                        <div class="form-group">
                            <a href="{{URL('/bank')}}" class="btn btn-primary btn-signin btn-oblong a-btn">Back</a>
	                </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
