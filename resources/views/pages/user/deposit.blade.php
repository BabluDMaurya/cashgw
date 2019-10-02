@extends('layouts.userdashboard')
@section('content')
<section class="top-section">
    <div class="container">
        <div class="name-det d-flex">
            <div class="img-side"> 
                <img src="{{url('/public/images/default.jpg')}}" id="myImg">
                <!--<input type="file" class="custom-file-input upload_img">-->
            </div>
            <div>
                <p class="block-name">Rush N Parekh</p>   
            </div>

        </div>
    </div>
</section>
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-6 margin-auto">
                <div class="block-item shadow-block">
                    <h5 class="block-title text-center">Deposit Money</h5>
                    <div class="detail-det">
                        <form class="common-form ">
                            <div class="row">
                                <div class="col-md-12 form-group required">
                                    <label>Amount  </label>
                                    <select class="form-control" >
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group required">
                                    <label>Choose the Bank  </label>
                                    <select class="form-control" >
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group required">
                                    <label>Write a note  <span class="asterik">*</span></label>
                                    <textarea class="form-control"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <a href="#!" class="btn btn-dark round-btn hvr-sweep-to-top w-100">Submit </a>
                                </div>
                            </div>
                        </form>                                                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $("#get-more").click(function () {
            $(".get-more-sec").slideToggle();
        });
    });
</script>
@endsection