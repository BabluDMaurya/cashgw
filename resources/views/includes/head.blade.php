<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'CASHGW') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ url('/public') }}/images/favicon.png" type="image/png" sizes="32x32">
<link rel="stylesheet" href="{{url('/public/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{url('/public/css/style.css')}}">
<link href="{{url('/public/css/flax.css')}}" rel="stylesheet"/>
<link href="{{url('/public/css/hover.css')}}" rel="stylesheet"/>
<link href="{{url('/public/css/animate.css')}}" rel="stylesheet"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
{{-- Owl Stylesheets --}}
<link rel="stylesheet" href="{{url('/public/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{url('/public/css/owl.theme.default.css')}}"> 
<link rel="stylesheet" href="{{url('/public/css/croppie.css')}}">
<link rel="stylesheet" href="{{url('/public/js/bootstrap-fileinput/bootstrap-fileinput.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
        const BASE_URL = "https://cashgw.website";    
        const IMAGE_URL = "https://cashgw.website/public/images/";
</script>
<div class="loader"></div>