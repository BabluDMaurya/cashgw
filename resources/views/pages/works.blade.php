@extends('layouts.default')
@section('content')
<section class="inner-banner">
    <div class="inban-content ">
        <div class="container">
            <h1>How It Works</h1>
        </div>
    </div>
</section>
<section class="sec-works">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center">
                <div class="works-item">
                    <img class="img-fluid" src="{{URL('/public/images/icon-works.png')}}" />
                    <h5>Lorem Ipsum is simply </h5>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="works-item">
                    <img class="img-fluid" src="{{URL('/public/images/icon-works.png')}}" />
                    <h5>Lorem Ipsum is simply </h5>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="works-item">
                    <img class="img-fluid" src="{{URL('/public/images/icon-works.png')}}" />
                    <h5>Lorem Ipsum is simply </h5>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="works-item">
                    <img class="img-fluid" src="{{URL('/public/images/icon-works.png')}}" />
                    <h5>Lorem Ipsum is simply </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt100">
        <div class="row">        
            <div class="col-md-5 vid-content">
                <h4 class="in-heading">Lorem Ipsum is simply</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesettting, remaining essentially unchanged.</p>
            </div>
            <div class="col-md-7">
                <div class="video-img wow fadeInLeft" style="visibility: visible; animation-name: fadeInLeft;">
                    <img src="{{URL('/public/images/video.png')}}">
                     <div class="play-icon  video-btn2" data-toggle="modal" data-src="https://www.youtube.com/embed/Jfrjeg26Cwk" data-target="#myModal">
               <i class="fas fa-play"></i>
                </div>
<!--                    <div class="play-icon ">
                   <i class="fas fa-play"></i>
                    </div>-->
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
          <span aria-hidden="true">&times;</span>
        </button>        
        <!-- 16:9 aspect ratio -->
<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always">></iframe>
</div>
        
        
      </div>

    </div>
  </div>
</div> 
@endsection
   <script>
      var owl = $('.clients-logo');
      owl.owlCarousel({
        margin: 50,
        loop: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 2
          },
          1000: {
            items: 5
          }
        }
      });
      jQuery(document).ready(function($) {
          $('.center-carousel').owlCarousel({
            center: true,
            items: 2,
            loop: true,
            margin: 10,
            responsive: {
              600: {
                items: 3
              }
            }
          });
        });
    </script>
     <script>
 $(document).ready(function() {

// Gets the video src from the data-src on each button

var $videoSrc;  
$('.video-btn2').click(function() {
    $videoSrc = $(this).data( "src" );
});
console.log($videoSrc);

  
  
// when the modal is opened autoplay it  
$('#myModal').on('shown.bs.modal', function (e) {
    
// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
$("#video").attr('src',$videoSrc + "?rel=0&amp;showinfo=0&amp;modestbranding=1&amp;autoplay=1" ); 
})
  
  
// stop playing the youtube video when I close the modal
$('#myModal').on('hide.bs.modal', function (e) {
    // a poor man's stop video
    $("#video").attr('src',$videoSrc); 
}) 
    
    


  
  
// document ready  
});




</script>