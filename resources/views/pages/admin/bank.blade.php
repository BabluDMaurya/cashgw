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
                <li class="breadcrumb-item active" aria-current="page">Bank</li>
            </ol>
            <h6 class="slim-pagetitle">Bank</h6>
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
                        <a href="{{route('bank.create')}}" class="btn btn-primary btn-signin btn-oblong" id="add-cate" >Add New Bank Account</a>
                    </div>
                    <div id="message"></div>       
                    <!-- Tab panes -->
                    <div class="tab-content custom-content">                        
                        <div class="tab-pane  active">
                            <div class="table-responsive">
                                <table class="table table-bordered my-table" id="example">
                                    <thead>
                                        <tr>                  
                                            <th style="width:6%">Sr. No.</th>
                                            <th>Name</th>
                                            <th style="width:25%">Address</th>
                                            <th style="width:15%">Branch</th>
                                            <th style="width:24%">Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($bankaccs)> 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                        @foreach($bankaccs as $bankacc) 
                                        <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>{{$bankacc->bank}}</td>
                                            <td>{{$bankacc->address}}</td>
                                            <td>{{$bankacc->branch}}</td>
                                            <td><a href="{{URL('/bank/'.$bankacc->id)}}" id="{{$bankacc->id}}" class="btn btn-primary btn-signin btn-oblong a-btn">View Details</a> 
                                                <form action="{{URL('/bank/'.$bankacc->id.'/edit/')}}" method="get" class="btn btn-primary btn-signin btn-oblong a-btn">
                                                    <input type="submit" class="btn btn-primary btn-signin btn-oblong a-btn" value="Edit">
                                                </form>
                                                <form action="{{URL('/bank/'.$bankacc->id)}}" method="post" class="btn btn-primary btn-signin btn-oblong a-btn">
                                                     {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="delete">
                                                    <input type="submit" class="btn btn-primary btn-signin btn-oblong a-btn" name="edit" value="Delete">
                                                </form>
                                            </td>
                                        </tr>
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
