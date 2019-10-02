@extends('layouts.default')
@section('content')
<section class="banner">
    <div class="ban-content wow fadeInUp">
        <div class="container">
            <h3>{{$pageData[0]['title']}}</h3>
            <p>{{$pageData[0]['description']}}</p>
            <a href="{{URL('/login')}}" class="btn blue-btn round-btn hvr-sweep-to-top">Send Money Now</a>
        </div>
    </div>
</section>
<section class="half-up">  
    <div class="container">
      <div class=" half-top-items d-flex ">
          @php
          $title =  unserialize($pageData[1]['title']);
          $description =  unserialize($pageData[1]['description']);
          $media =  unserialize($pageData[1]['media']);
          $count = count($title);
          @endphp
          @for($i = 0; $i < $count; $i++)
            <div class=" items-top wow fadeInUp" >
                <div class="ico">
                    <img src="{{url('/public/images')}}/{{$media[$i]}}">
                </div>
                <h4>{{$title[$i] }}</h4>
                <p>{{$description[$i]}}</p>          
            </div>
          @endfor
        </div>
    </div>
</section>
<section class="abt-sec">
    <div class="container">
        <div class="row">        
            <div class="col-md-6 wow fadeInLeft">
                <h4>{{$pageData[2]['title']}}</h4>                
                <p>{{$pageData[2]['description']}}</p>
            </div>
        </div>
    </div>
</section>
<section class="blue-section">
    <div class="container">
        <div class="blue-flex">
        @php
          $title =  unserialize($pageData[3]['title']);
          $description =  unserialize($pageData[3]['description']);
          $count = count($title);
        @endphp
        @for($i = 0; $i < $count; $i++)
        <div class="blue-item wow fadeInUp">
            <h4>{{$title[$i]}}</h4>
            <p>{{$description[$i]}}</p>
        </div>
       @endfor
        </div>
    </div>    
</section>
<section class="video-sec">
    <div class="container">
        <div class="row">
        <div class="col-md-7">
            <div class="video-img wow fadeInLeft">
                <img src="{{url('/public/images/video.png')}}">
                <div class="play-icon  video-btn2" data-toggle="modal" data-src="https://www.youtube.com/embed/Jfrjeg26Cwk" data-target="#myModal">
               <i class="fas fa-play"></i>
                </div>
            </div>
        </div>
        <div class="col-md-5 vid-content">
            <h4>{{$pageData[4]['title']}}</h4>
            <p>{{$pageData[4]['description']}}</p>
        </div>
        </div>
    </div>
</section>
<section class="cta">
    <img src="{{url('/public/images/cta-sec.png')}}">
    <div class="container wow fadeInUp">
    <h4>{{$pageData[5]['title']}}</h4>
    <a href="sign-in.php" class="btn dark-btn round-btn hvr-sweep-to-top">Send Money Now</a>
    </div>
</section>
<section class="divide-section text-center">
    <div class="container">
        <h4 class="">Lorem Ipsum is simply dummy text <br>
of the printing </h4>
        <div class="icon-section">
          @php
            $title =  unserialize($pageData[6]['title']);
            $description =  unserialize($pageData[6]['description']);
            $media =  unserialize($pageData[6]['media']);
            $count = count($title);
          @endphp
          @for($i = 0; $i < $count; $i++)
            <div class="icon-item wow fadeInLeft">
                <img src="{{url('/public/images')}}/{{$media[$i]}}">
                <h5>{{$title[$i]}} </h5>
                <p>
                  {{$description[$i]}}
                </p>
            </div>
          @endfor
        </div>
    </div>
    
</section>
<section class="client-section">
    <div class="container">
     <div class="owl-carousel">
           @if(count($partnersImages) > 0)
            @foreach($partnersImages as $details)
            <div class="item">
               <img src="{{URL('/public/images')}}/{{$details['name']}}">
            </div>
           @endforeach
         @endif
           
          </div>
    </div>
</section>

@endsection
