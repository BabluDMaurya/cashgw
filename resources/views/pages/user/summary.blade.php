@extends('layouts.userdashboard')
@section('content')
@php 
    if($role == 2){
       $module = 'business';
    }else if($role == 1){
       $module = 'individual';
    }
@endphp
<section class="top-section">
    <div class="container">
        <div class="name-det d-flex">
            @if(!empty($user_id))
            <div class="img-side">  
                {{ csrf_field() }}                                            
                <img src="{{url('/public/images/')}}/{{decrypt($user_id)}}/{{$individualkyc->photo}}" id="myImg">                                             
                <input type="file" accept="image/png, image/jpeg,img/jpg" class="custom-file-input upload_pro_image {{ $errors->has('myphoto') ? ' is-invalid' : '' }}" id="upload_image" img_id="myImg" img_height="224" img_width="325" imagefolder="images" required="" aria-required="true">  
                <input type="hidden" id="myphoto" name="myphoto">                                                                                                                                
                @if($errors->has('myphoto'))                                                
                <span class="invalid-feedback" role="alert" style="display: block">
                    <strong>{{ $errors->first('myphoto') }}</strong>
                </span> 
                @endif
            </div>                                         
            @else
            <div class="img-side">                                           
                <img src="{{url('/public/images/about.png')}}" id="myImg">
                <input type="file" class="custom-file-input upload_img">
            </div>                                         
            @endif
            <div class="summary_client_details">

                <ul>
                    <li>{{$individualkyc->fname}} {{$individualkyc->mname}} {{$individualkyc->lname}}</li>
                    <li>@if(!empty($individual->primary_email))
                            {{$individual->primary_email}}
                        @endif
                    </li>
                    @if(!empty($individual->primary_phone))
                        {{$individual->primary_phone}}
                    @else
                        <li><a href="#!" data-toggle="modal" data-target="#add-phone" class="add-number"><i class="fas fa-plus"></i> Add Number</a></li>
                    @endif
                </ul>
            </div>
            <ul class="list-unstyled d-flex balance_nav right-nav">
                <li>Available Balance</li>
                <img src="{{url('/public/images/wallet.png')}}" class="wallet_img">
                <li>
                    <div class="d-flex">
                        <div class="img-card">
                            <img src="{{url('/public/images/flag.jpg')}}">
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <span>$ @if($balance['USD'] > 0){{$balance['USD']}} @else 0.00 @endif USD</span>
                    </div>
                </li>

                <li>
                    <div class="d-flex">
                        <div class="img-card">
                            <img src="{{url('/public/images/eur.jpg')}}">
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <span>&euro; @if($balance['EUR'] > 0){{$balance['EUR']}} @else 0.00 @endif EUR</span>
                    </div>
                </li>  
            </ul>
        </div>
    </div>
</section>                        
<section class="main-content">
    <div class="container-fluid">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible" id="msg"> 
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('status') }}
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="text-right mb-3 button_summary">
                    <a href="withdraw.php" class="btn btn-dark round-btn hvr-sweep-to-top mr-2">Withdraw Money</a>
                    <a href="#!" data-toggle="modal" data-target="#add-currency" class="btn btn-dark round-btn hvr-sweep-to-top">Add Balance</a>
                    <a href="{{URL('/individual-payment-history/'.$user_id)}}" class="btn btn-dark round-btn hvr-sweep-to-top mr-2">Payment History</a>
                </div>
                <div class="block-item shadow-block">
                    <div class="d-flex justify-content-between view_all_button">
                        <h5 class="block-title mb-4">Recent Activity</h5>
                        <!--                        <a href="{{URL('/individual-activity/'.$user_id)}}">View All</a>-->
                    </div>
                    <!---tab---->
                    <div class="container-fluid summary_tab">
                        <div class="row">
                            <div class="col-md-12">
                                @include('includes.summary-table-content')
                                    </div>
                                    </div>
                        </div>
                </div>
            </div>
        </div>
</section>
<div id="uploadimageModal2" class="modal" role="dialog">
    <div class="modal-dialog ad_modal modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload & Crop Image</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 myacont-popup text-center">
                        <div class="image_demo" style="width:100%;overflow: hidden"></div>
                    </div>
                    <div class="col-md-12 myacont-popup text-center">
                        <button class="btn btn-custom waves-effect btn-rounded btn-success crop_image2" user_id="{{$user_id}}">Crop & Upload Image</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                        <div class="modal fade " id="add-phone">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title text-center">Phone Number</h4>
                                        <button type="button" class="close" data-dismiss="modal">x</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="{{URL('/individual-account/')}}" class="common-form myform" method="post" id="AddPhoneNumber">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12 form-group required">
                                                    <input type="text" class="form-control {{ $errors->has('phonenumber') ? ' is-invalid' : '' }}" placeholder="Add phone number" name="phonenumber" id="phonenumber" value="{{ old('phonenumber') }}">

                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                                    </span>

                                                </div>                            
                                            </div>  
                                            @if(empty($business->primary_phone))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">
                                                            <p>Make this your primary Phone Number</p>
                                                            <input type="checkbox" id="phonenumbervalue" name="phonenumbervalue" value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>  
                                            @endif
                                            <div class="col-lg-10 margin-auto">
                                                <input name="submitaddnumber" type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20" value="Save Number">
                                            </div>             
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script src="{{url('/public/js/croppie.js')}}"></script>
<script src="{{URL('public/js/bootstrap-datepicker.js')}}"></script> 
<script src="{{URL('public/js/common-summary.js')}}"></script> 
<script>
    $(document).on('click', '.clickarchive', function () {
        var id = $(this).attr('id');
        var archieve = $(this).attr('data-archivetype');
        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url :'{{URL("individual-activity/".$user_id)}}',
                type :"PUT",
                data: {id:id,archieve:archieve},
                success: function(response){
                    if(response == 'updated'){
                        location.reload();
                    }
                }
        }); 
    });
$('.crop_image2').click(function (event) {
    $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (response) {
        $(".loader").show();
        $('#uploadimageModal2').modal('hide');
        response = window.btoa(response);
        $.ajax({
            url: '/addprofilepic',
            type: "POST",
                data: {"myphoto": response, "_token": "{{csrf_token()}}"},
            success: function (result)
            {
                console.log(result);
                var imageUrl = $.trim(result);
                var src = BASE_URL + imageUrl;
                $('#myImg').attr('src', src);
                $(".loader").fadeOut(1000);
                location.reload(true);
            }
        });
    });
});
</script>
@endsection

