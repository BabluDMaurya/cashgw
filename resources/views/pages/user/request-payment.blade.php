@extends('layouts.userdashboard')
@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    @if (session('status') && (session('status')!= 'addbalance'))
                    <div class="alert alert-success alert-dismissible"> 
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('status') }}
                    </div>
                    @endif
                    <h4 class="mb-20">Request Money</h4>
                    <p class="mb-20">Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br> Lorem Ipsum has been the industry's standard </p>
                    <div class="col-md-4 margin-auto">
                        <form class="common-form myform" method="GET" action="{{URL('/individual-request-payment/'.$user_id.'/edit')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" name="search_text" class="putemailfromAB form-control bg-white {{ $errors->has('search_text') ? ' is-invalid' : '' }}" id="search_text" value="{{old('search_text')}}" placeholder="Enter Email address">
                                @if($errors->has('search_text'))                                                
                                <span class="invalid-feedback" role="alert" style="display: block">
                                    <strong>{{ $errors->first('search_text') }}</strong>
                                </span> 
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="hiddenUserId" name="user_id" class="form-control bg-white {{ $errors->has('user_id') ? ' is-invalid' : '' }}" value="{{old('user_id')}}">
                                @if($errors->has('user_id'))                                                
                                <span class="invalid-feedback" role="alert" style="display: block">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span> 
                                @endif
                            </div>
                            <div class="actionclass">
                                <button  type="submit" class=" showloader btn dark-btn round-btn btn-block w-100 hvr-sweep-to-top l-btn">{{ $errors->has("amount") ? "Send" : "Next" }}</button>
                            </div>
                        </form>
                       <div>
                            <a href="#!" data-toggle="modal" data-target="#edit-contact" class="edit-link"><i class="far fa-address-book"></i> Address Book</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade " id="edit-contact">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Email Address</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <p class="text-center">Let's make it even easier to send and request money! Quickly add contacts by  them, or remove contacts that you no longer need.</p>
                <div class="form-group">
                    <input id="myInput" type="text" class="form-control round-btn" placeholder="Email addresses">
                </div>
                <div id="displayerror"></div>
                <ul class="account-list currency-list" style="max-height: 270px !important;overflow-y: auto !important;">
                    @if(count($addressBookContacts)>0)
                    @foreach($addressBookContacts as $contacts)
                    <li class="listAB">
                                                <div class="img-card">
                                                    <img src="{{url('/public/images/default.jpg')}}">
                                                </div>
                        <div class="list-group">
                            <label class="l-radio">
                                <span>{{$contacts->email}}</span>
                                <input type="radio" name="contEmail" value="{{$contacts->email}}" hiddenid="{{$contacts->id}}">
                                <span class="checkmark"></span>
                            </label>                     
                        </div>
                    </li>  
                    @endforeach
                    @endif
                </ul>   
                <a id="addEmailToSearch" class="btn dark-btn round-btn btn-block w-100 hvr-sweep-to-top l-btn">Add</a>
            </div>
        </div>
    </div>
</div>            



<div class="modal fade " id="addbalance">
    <div class="modal-dialog modal-md">
        <div class="modal-content">     
            <div class="modal-header">
                <h4 class="modal-title text-center">Add Balance</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body text-center">
                <p class="text-center">You don't have enough balance.</p>
            </div>
            <div class="modal-body text-center">
                <a href="{{URL('/individual-balance/'.$user_id)}}" class="btn btn-primary round-btn text-center">Add Balance</a>
            </div>
        </div>
    </div>
</div>
<link href="{{url('/public/css/jquery.ui.autocomplete.css')}}"/>
<script src="{{url('/public/js/jquery.js')}}"></script>
<script src="{{url('/public/js/jquery-ui.min.js')}}"></script>
<script src="{{url('/public/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script>
$('.modal').on('hidden.bs.modal', function (e) {
         var modalId = $(this).attr('id');           
        $(this)
          .find("#myInput")
             .val('')
             .end()
          .find('#displayerror').html('')
             .end() 
          .find("input[name=contEmail]")
             .prop("checked", "")
             .end()
          .find('#displayerror').html('')
             .end();           
      });    
$(document).on('click','.showloader',function(){
    if ($('.myform').valid()) {
            $('.loader').show();
        } else {           
            e.preventDefault();
            $('.loader').hide();
        }
});
$(document).ready(function () {   
    $(".alert-success").fadeTo(5000, 500).slideUp(500, function () {
        $(".alert-success").slideUp(500);
    });
    src = "{{ route('searchajax') }}";
    $("#search_text").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 3,
        select: function (event, ui) {
            $('input[name=user_id]').val(ui.item.id); // display the selected text
            $("#search_text").val(ui.item.value); // save selected id to hidden input
            $('#search_text').trigger('change'); //to open hidden fields on select of email
        },
        change: function (event, ui) {
            $('input[name=user_id]').val(ui.item ? ui.item.id : 0);
        }
    });
    
    
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("li.listAB").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $(document).on('click', '#addEmailToSearch', function () {
        var radioValue = $("input[name='contEmail']:checked").val();
        var hiddenId = $("input[name='contEmail']:checked").attr("hiddenid");   
        if((typeof radioValue === "undefined") && (radioValue == null || radioValue == '')){
            $('#displayerror').html('<span class="">please select one of email.</span>');
            return false;
        }else{
            $('#displayerror').html('');
        }
        $('.putemailfromAB').val(radioValue);
        $('#hiddenUserId').val(hiddenId);
        $('#edit-contact').modal('toggle');
        $('#search_text').trigger('keyup');
        $('#search_text').trigger('change');
        $("input[name='contEmail']").attr('checked', false);
    });

    $('.myform').each(function(){
    $(this).validate({
    errorElement: 'span',
            errorClass: 'invalid-feedback',
            rules: {
            search_text: {
                required: true,
                email:true,
            },
                    amount: {
                    required: true,
                            digits: true,
                    },
                    note:{
                    required: true,
                            maxlength: 40,
                    },
            },
            highlight: function (element) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
            $(element).removeClass('is-invalid');
            },
            messages: {
            search_text: {
                required: "Email Address Required",
                email:"Enter valide Email Address (example@gmail.com)",
            },
                    amount: {
                    required: "Amount Required",
                            digits: "Please enter valid amount.",
                    },
                    note:{
                    required: "Note Required",
                            maxlength: "Note not more then 40 charecters",
                    },
            }
    });
    });
            @if (session('status'))
            @if (session('status') == 'addbalance')
    $('#addbalance').modal('show');
    @endif
    @endif
});
</script>

<script>
$('#edit-contact').on({'mousewheel': function(e) 
    {
    if (e.target.id == 'el') return;
    e.preventDefault();
    e.stopPropagation();
   }
});

</script>
@endsection