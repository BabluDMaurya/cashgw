@extends('layouts.userdashboard')
@section('content')
<!-- Tabs -->
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                <nav>
                    <div class="container pd0">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <a class="nav-item nav-link " href="{{URL('/invoice-manage')}}" >Manage invoices</a>
                            <a class="nav-item nav-link" href="{{URL('/create-invoice')}}">Create invoice</a>
                            <a class="nav-item nav-link " href="{{URL('/manage-item')}}">Items</a>
                            <div class="nav-item nav-link dropdown" >
                                <a  class="dropdown-toggle" data-toggle="dropdown">
                                    Settings <i class="fas fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{URL('/address-book')}}">Address Book</a>
                                    <a class="dropdown-item" href="{{URL('/business-information')}}">Business Information</a>
                                    <a class="dropdown-item" href="{{URL('/tax-information')}}">Tax Information</a>
                                    <a class="dropdown-item" href="{{URL('/templates')}}">Templates</a>
                                </div>
                            </div>
                            <a class="nav-item nav-link active" href="{{URL('/help')}}">Help</a>
                        </div>
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space">
                                            <div class="col-md-6">
                                                <h5 class="block-title">Invoicing Help</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a  class="btn  btn  round-btn  hvr-sweep-to-top video-btn" data-toggle="modal" data-src="https://www.youtube.com/embed/Jfrjeg26Cwk" data-target="#myModal">
                                                <i class="fas fa-play-circle"></i> How to Send Invoices
                                            </a>
                                        </div>
                                    </div>
                                    <div class="help-sec">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4><a href="#invoice1">Creating invoices</a></h4>
                                                <ul>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <h4><a href="#invoice1">Creating invoices</a></h4>
                                                <ul>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <h4><a href="#invoice1">Creating invoices</a></h4>
                                                <ul>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4><a href="#invoice1">Creating invoices</a></h4>
                                                <ul>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <h4><a href="#invoice1">Creating invoices</a></h4>
                                                <ul>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                    <li><a href="#sub-head">lorem ipsum dolor smit</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="help-content">
                                        <div class="content-item" id="invoice1">
                                            <h4>Creating invoices</h4>
                                            <h6 id="sub-head">lorem ipsum dolor smit</h6>
                                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                        </div>
                                        <div class="content-item">
                                            <h4>Creating invoices</h4>
                                            <h6>lorem ipsum dolor smit</h6>
                                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                        </div>
                                        <div class="content-item">
                                            <h4>Creating invoices</h4>
                                            <h6>lorem ipsum dolor smit</h6>
                                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>        
                <!-- 16:9 aspect ratio -->
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always">></iframe>
                </div>
            </div>
        </div>
    </div>
</div> 
<!-- ./Tabs -->
<script>
    $(document).ready(function () {
// Gets the video src from the data-src on each button
        var $videoSrc;
        $('.video-btn').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);
        
// when the modal is opened autoplay it  
        $('#myModal').on('shown.bs.modal', function (e) {
// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
            $("#video").attr('src', $videoSrc + "?rel=0&amp;showinfo=0&amp;modestbranding=1&amp;autoplay=1");
        })

// stop playing the youtube video when I close the modal
        $('#myModal').on('hide.bs.modal', function (e) {
            // a poor man's stop video
            $("#video").attr('src', $videoSrc);
        })
// document ready  
    });
</script>
@endsection
