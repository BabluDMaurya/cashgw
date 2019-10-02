<div class="modal fade" id="add-currency">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Add Balance</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body"> 
                <form action="{{URL('/business-summary/'.$user_id.'/edit/')}}" class="myform" method="get" id="addcurrency" name="addcurrency">
                <!--{{ csrf_field() }}-->
                <ul class="account-list currency-list ">
                    <li>
                        <div class="img-card">
                            <img src="{{url('/public/images/flag.jpg')}}">
                        </div>
                        <div>
                            <label class="l-radio"> 
                                <span>USD</span>
                                <input type="radio" checked="checked" name="balance_request" value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="img-card">
                            <img src="{{url('/public/images/eur.jpg')}}">
                        </div>
                        <div>
                            <label class="l-radio">                                
                                <span>EUR</span>
                                <input type="radio" name="balance_request" value="2">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </li>
                </ul>
                <input type="text" class="form-control {{ $errors->has('balance') ? ' is-invalid' : '' }}" name="balance" placeholder="Enter Amount"> 
                @if($errors->has('balance'))                                                
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $errors->first('balance') }}</strong>
                    </span> 
                @endif
                <div class="margin-auto">
              <button type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20">Submit</button>
            </div>
            </form>  
            </div>
              
        </div>
    </div>
</div>
<footer class="foot-nav">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <li><a href="{{URL('/help')}}">Help</a></li>
                    <li><a href="{{URL('/contact')}}">Contact Us</a></li>
                    <li><a href="{{URL('/terms')}}">Terms and Conditions</a></li>
                    <li><a href="{{URL('/privacy')}}">Privacy Policy</a></li>
                   
                </ul>
            </div>
            <div class="col-md-6 text-right">
                Copyright © 2019 cashgw.com All Rights Reserved
            </div>
        </div>        
    </div>    
</footer>
<script src="{{URL('/public/js/setlocalstorage.js')}}" type="text/javascript"></script>
<script>
      $(document).ready(function(){
          $('#addcurrency').validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            balance: {
                required: true,
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        messages: {
            balance: {
                required: "Balance Required",
            }
        }
    });
          setTimeout(function() {
              $('#msg').fadeOut('fast');
          }, 1000);
      });
      function goBack() {
  window.history.back();
}
</script>