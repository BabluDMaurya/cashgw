<section class="breadcrumb-sec">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 ">
                <ul>
                    <li><a href="{{URL('/business-summary/'.$user_id)}}">Home</a>  <i class="fas fa-angle-right"></i></li>
                    <li>{{ ucwords(str_replace('-',' ',Request::segment(1))) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section> 