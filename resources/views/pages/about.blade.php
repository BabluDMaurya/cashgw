@extends('layouts.default')
@section('content')
<section class="inner-banner">
    <div class="inban-content ">
        <div class="container">
            <h1>About Us</h1>
        </div>
    </div>
</section>
<section class="abt-sec">
    <div class="container">
        <div class="row">        
            <div class="col-md-6 wow fadeInLeft">
                <h4>Lorem Ipsum is simply dummy text of the printing </h4>                
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
        </div>
    </div>
</section>
<section class="sec-clients">
    <h2 class="in-heading text-center">Client Says</h2>
    <div class="container">
        <div class="center-carousel owl-carousel owl-theme">
            <div class="item">
                <div class="item-details">
                    <div class="item-img">
                        <img class="img-fluid" src="{{URL('/public/images/c1.png')}}" />
                    </div>
                    <div class="item-content">
                        <h5>Adrew James</h5>
                        <p>“Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown”</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-details">
                    <div class="item-img">
                        <img class="img-fluid" src="{{URL('/public/images/c1.png')}}" />
                    </div>
                    <div class="item-content">
                        <h5>Adrew James</h5>
                        <p>“Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown”</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-details">
                    <div class="item-img">
                        <img class="img-fluid" src="{{URL('/public/images/c1.png')}}" />
                    </div>
                    <div class="item-content">
                        <h5>Adrew James</h5>
                        <p>“Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown”</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-details">
                    <div class="item-img">
                        <img class="img-fluid" src="{{URL('/public/images/c1.png')}}" />
                    </div>
                    <div class="item-content">
                        <h5>Adrew James</h5>
                        <p>“Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown”</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-details">
                    <div class="item-img">
                        <img class="img-fluid" src="{{URL('/public/images/c1.png')}}" />
                    </div>
                    <div class="item-content">
                        <h5>Adrew James</h5>
                        <p>“Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown”</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-details">
                    <div class="item-img">
                        <img class="img-fluid" src="{{URL('/public/images/c1.png')}}" />
                    </div>
                    <div class="item-content">
                        <h5>Adrew James</h5>
                        <p>“Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown”</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-details">
                    <div class="item-img">
                        <img class="img-fluid" src="{{URL('/public/images/c1.png')}}" />
                    </div>
                    <div class="item-content">
                        <h5>Adrew James</h5>
                        <p>“Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown”</p>
                    </div>
                </div>
            </div>
          </div>
    </div>    
</section>

<section class="cta">
    <img src="{{URL('/public/images/cta-sec.png')}}">
    <div class="container wow fadeInUp">
    <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>
    <button type="button" class="btn dark-btn round-btn hvr-sweep-to-top">Send Money Now</button>
    </div>
</section>
<section class="client-section">
    <div class="container">
     <div class="clients-logo owl-carousel">
            <div class="item">
                <img src="{{URL('/public/images/client1.png')}}">
            </div>
            <div class="item">
               <img src="{{URL('/public/images/client2.png')}}">
            </div>
            <div class="item">
                <img src="{{URL('/public/images/client1.png')}}">
            </div>
            <div class="item">
               <img src="{{URL('/public/images/client2.png')}}">
            </div>
         <div class="item">
                <img src="{{URL('/public/images/client1.png')}}">
            </div>
            <div class="item">
               <img src="{{URL('/public/images/client2.png')}}">
            </div>
         <div class="item">
                <img src="{{URL('/public/images/client1.png')}}">
            </div>
            <div class="item">
               <img src="{{URL('/public/images/client2.png')}}">
            </div>
           
          </div>
    </div>
</section>
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