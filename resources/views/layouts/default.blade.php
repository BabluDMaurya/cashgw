<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
      @include('includes.head')
    </head>
    <body>    
        <a href="#" id="scroll" style="display: none;"><i class="fas fa-angle-up"></i></a>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            @include('includes.menu')
        </nav>
            @yield('content')
        <footer>
            @include('includes.footer')
        </footer>
        
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
            
@include('includes.footerscript')
  
<script src="{{URL('/public/js/owl.carousel.js')}}"></script>
 <script src="{{URL('/public/js/bootstrap.min.js')}}"></script>
<!--   <script>
      var owl = $('.owl-carousel');
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
      })
    </script>-->

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

    </body>
</html>