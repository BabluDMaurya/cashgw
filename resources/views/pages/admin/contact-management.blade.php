@extends('layouts.admin')
@section('content')
    <div class="slim-mainpanel">
      	<div class="container-fluid">
	        <div class="slim-pageheader">
	          <ol class="breadcrumb slim-breadcrumb">
	            <li class="breadcrumb-item"><a href="{{URL('/admin')}}">Home</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Contact Management</li>
	          </ol>
	          <h6 class="slim-pagetitle">Contact Management</h6>
	        </div>
            <div class="alert alert-success" style="width: 50%;margin: 0 auto;display: none;"></div>

            <div class="alert alert-danger" style="width: 50%;margin: 0 auto;display: none;"></div>
	        <div class="section-wrapper">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="tab-content">
                                <div id="contact-info" class="tab-pane active">
                                    <div class="table-responsive">
                                        <table class="table table-hover mg-b-0 table-primary text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Name</th>
                                                    <th>Email</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Reply</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($datas))
                                                @foreach($datas as $value)
                                                <tr>
                                                    <th class="text-left" scope="row">{{ucfirst($value->name)}}</th>
                                                    <td>{{$value->email}}</td>
                                                    <td>{{ucfirst($value->subject)}}</td>
                                                    <td>{{ucfirst($value->message)}}</td>
                                                    <td class="action-btns text-center">
                                                    <span id="{{ Crypt::encrypt($value->id) }}" email="{{ $value->email }}" class="btn btn-success btn-icon message_replay">
                                                            <div>
                                                                <i class="icon ion-reply"></i>
                                                            </div>
                                                    </span>
                                                    </td>
                                                    <td><a href="#" class="delmess" id="{{$value->id}}">Delete</a></td>
                                                </tr>  
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
       	 	</div>
      	</div>
    </div>    
    @include('pages.admin.modal')
    <script src="{{ url('/public/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click','.closemodal',function(){
           $('#message-text').val(''); 
        });
         $('.modal').on('hidden.bs.modal', function(e){
               $(this)
                  .find("textarea")
                     .val('')
                     .end()
                  .find('.invalid-feedback').removeClass('error').text('')
                     .end();
        });
        $(document).on('click','.delmess',function(){
           var delid = $(this).attr('id');           
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
           $.ajax({
                    url: "{{URL('contact-delete')}}",
                    type: 'post',
                    async : false,
                    data: {id:delid},
                    processData: true,
                    beforeSend: function() {
                        $('.loader').show();                        
                    },
                    success: function( res ){
                        let get_response = res ; 
                        if (get_response.status) {
                            $('.alert-success').text(get_response.message);
                            $('.alert-success').show();
                            location.reload();
                        } else if (!get_response.status) {
                            $('.alert-danger').text(get_response.message);
                            $('.alert-danger').show();
                        } else {
                            $('.alert-danger').text('Something went wrong..!!!');
                            $('.alert-danger').show();
                        }
                        $('.loader').hide();
                        setTimeout(function(){ $('.alert').hide('slow') }, 3000);
                    }
                });
        });
        $(document).on("click",".message_replay",function() {
            $('#recipient-email').val($(this).attr('email'));
            $('#message_id').val($(this).attr('id'));
            $('#admin_replay_modal').modal('show');
        });
        $('#admin_replay_form').validate({
            rules: {
                 message: {
                     required: true,
                     maxlength: 500,
                 },
                 email: {
                     required: true,
                      email: true,
                 }
            },
            message : {
                message: {
                    required:'Message required',
                    maxlength: 'Maxmimum 500 character allowed',
                },
                 email: {
                     required: 'Eamil Required',
                      email: 'Enter valid Email Id',
                 }
            },
            submitHandler: function(form) {
                let data = $("#admin_replay_form").serializeArray();
                let ajax_url = base_url('contact_admin');
                $('.loader').show();
                $('#admin_replay_modal').modal('hide');                
                $.ajax({
                    url: ajax_url,
                    type: 'post',
                    async : false,
                    data: data,
                    processData: true,
                    success: function( res ){
                        let get_response = res ; 
                        if (get_response.status) {
                            $('#message-text').val(''); 
                            $('.alert-success').text(get_response.message);
                            $('.alert-success').show();
                        } else if (!get_response.status) {
                            $('.alert-danger').text(get_response.message);
                            $('.alert-danger').show();
                        } else {
                            $('.alert-danger').text('Something went wrong..!!!');
                            $('.alert-danger').show();
                        }
                        $('.loader').hide();
                        setTimeout(function(){ $('.alert').hide('slow') }, 3000);
                    }
                });
            }
        });       
        function base_url(segemnt = '') {
            if(segemnt) {
                return "{{ URL::to('') }}/"+segemnt;    
            } else {
                return "{{ URL::to('') }}";    
            }
        }
    </script>
@endsection