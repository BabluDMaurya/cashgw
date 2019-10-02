@extends('layouts.default')
@section('content')
<section class="inner-banner">
    <div class="inban-content wow fadeInUp">
        
    </div>
</section>
<section class="sec-contact">
    <div class="container">
        <div class="row justify-content-center"> 
            <div class="col-md-7 text-center">
                <div class="contact-content">
                    <h2 class="in-heading">Contact Us</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard </p>
                    <div class="alert alert-success alert-dismissible" style="display:none">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class="contactmess"></span>
                        </div>
                    <form class="common-form" id="contactform" action="{{URL('/cformsubmit')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Your Name" value="{{ old('name') }}">                            
                            <span class="error name-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Your Email Address" value="{{ old('email') }}">
                            <span class="error email-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" placeholder="Subject" value="{{ old('subject') }}">
                            <span class="error subject-error"></span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="5" name="comment" placeholder="Message">{{ old('comment') }}</textarea>
                            <span class="error comment-error"></span>
                        </div>
                        {{--<input class="btn dark-btn round-btn hvr-sweep-to-top l-btn w-100" id="ajaxSubmit" name="submit" value="Send" type="submit">--}}
                        <a class="btn dark-btn round-btn hvr-sweep-to-top l-btn w-100" id="ajaxSubmit">Send </a>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</section>
<script>
         $(document).ready(function(){
            $('#ajaxSubmit').click(function(e){
               e.preventDefault();               
               $('.loader').show();
              var form = $('#contactform');
              var formData = form.serialize();
              $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});
               $.ajax({
                  url: form.attr('action'),
                  type: form.attr('method'),
                  data: formData,
                  dataType:'json',
                  success: function(result){
                      $('.loader').hide();
                      $("#contactform")[0].reset();
                        clear('error');
                        $('.alert').show();
                        $('.contactmess').html(result.success);
                        $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
                            $(".alert-success").slideUp(500);
                        });
                  },
                  error: function(result){
                        $('.loader').hide();
                      if(result.status === 422) {
                        var errors = result.responseJSON;
                        $('.alert').hide();
                        $('.contactmess').html('');                        
                        $.each(result.responseJSON.errors, function (key, value) {                            
                        $('.'+key+'-error').html(value);
                        });
                      }
                    }
                });
             });               
            });
            
            $(".form-control").keyup(function(){
                if(($(this).next('span').html()) != ''){
                    clear($(this).next('span').attr('class').split(' ')[1]);                
                };
            });            
            function clear(inputclass){
                $('.'+inputclass).html('');
            }
      </script>
@endsection
    