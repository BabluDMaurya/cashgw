{{-- Main Footer --}}
  
{{-- REQUIRED JS SCRIPTS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="{{url('/public/js/bootstrap.min.js')}}"></script>
<script src="{{url('/public/js/custom.js')}}"></script> 
<!--<script src="{{url('/js/easydropdown.js')}}"></script>-->
 <script type="text/javascript" src="{{url('/public/js/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
<script src="{{url('/public/js/wow.js')}}"></script>
<script>
//    easydropdown.all();    
    new WOW().init();
</script> 
<script>
    $(document).ready(function () {
            $(".loader").fadeOut("slow");
    });
</script>

