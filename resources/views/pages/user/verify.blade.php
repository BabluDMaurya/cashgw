@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-6 margin-auto">
                <div class="block-item shadow-block">
                    <h5 class="block-title text-center">Please Verify Code from mobile number</h5>
                    <div class="detail-det">
                        <form class="common-form " method="post" action="{{route('verify')}}">
                             {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12 form-group required">                                    
                                    <input type="text" class="form-control" placeholder="Code" name="code">
                                </div>                                
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 form-group">
                                    <button type="submit" class="btn btn-dark round-btn hvr-sweep-to-top w-100">Verify</button> 
                                </div>
                                <div class="col-md-12">                                    
                                    <a href="#">Request New Code</a>
                                    <input type="hidden" name="req_code" value="{{request()->req_code}}">
                                </div>
                            </div>
                        </form>                                                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection