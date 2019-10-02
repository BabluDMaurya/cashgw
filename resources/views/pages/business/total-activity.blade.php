@extends('layouts.businessdashboard')
@section('content')
@php 
    if($role == 2){
       $module = 'business';
    }else if($role == 1){
       $module = 'individual';
    }
@endphp
<!-- Tabs -->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="block-item shadow-block">
                    <div class="container-fluid summary_tab">
                        <div class="row">
                            <div class="col-md-12">
                                @include('includes.activity-table-content')
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ./Tabs -->
<link href="{{URL('public/css/bootstrap-datepicker.css')}}" rel="stylesheet"/>
<script src="{{url('/public/js/additional-methods.min.js')}}"></script>
<script src="{{URL('public/js/bootstrap-datepicker.js')}}"></script> 
<script src="{{URL('/public/js/active_tab.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function(){
  $("#show-down").click(function(){
    $(".show1").fadeToggle();
    $(this).parent().parent().parent().toggleClass('bg-lightblue');
    $(this).parent().toggleClass('bg-darkblue');
    $(".show1").toggleClass('bg-lightblue');
    $(this).find('i').toggleClass('fa-angle-down fa-angle-up');;
  });
  $.fn.datepicker.defaults.format = "dd-mm-yyyy";
    $('.datepicker').datepicker(); 
    $(document).on('click','.clickarchive',function(){
        var Obj = $(this);
        var id = $(this).attr('id');
        var archieve = $(this).attr('data-archivetype');
        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url :'{{URL("business-activity/".$user_id)}}',
                type :"PUT",
                data: {id:id,archieve:archieve},
                success: function(response){
                    if(response == 'updated'){
                        if(archieve == 1){
                            $(Obj).text('Archieve');
                            $(Obj).attr('data-archivetype',2);
                        }else{
                            $(Obj).text('Unarchieve');
                            $(Obj).attr('data-archivetype',1);
                        }                        
                    }
                }
        }); 
    });
     $.validator.addMethod("firstname", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
      }, "Letters and space only");
      
    $.validator.addMethod("transactionid", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9 ]+$/i.test(value);
      }, "(a-zA-Z0-9_-) and space only");  
    $.validator.addMethod("australianDate",function(value, element) {
            return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
        },"Please enter a date in the format dd-mm-yyyy.");
    $(document).on('change','.changeform',function(){
        var formId = $(this).closest('form').attr('id');
        var seloption = $(this).closest('form').find('.seloption').children("option:selected").val();
        var tbodyId = $(this).closest('form').siblings('table').children('tbody').attr('id');
            formvalidation(formId,seloption);
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url :$(this).closest('form').attr('action'),
                type :$(this).closest('form').attr('method'),
                data: $(this).closest('form').serialize(),
                success: function(response){
                    $('#'+tbodyId).html(response);
                }
        });    
    });
    $(document).on('click','.searchdata',function(){
        var formId = $(this).closest('form').attr('id');
        var seloption = $(this).closest('form').find('.seloption').children("option:selected").val();
        var tbodyId = $(this).closest('form').siblings('table').children('tbody').attr('id');
        formvalidation(formId,seloption);
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url :$(this).closest('form').attr('action'),
                type :$(this).closest('form').attr('method'),
                data: $(this).closest('form').serialize(),
                success: function(response){
                    $('#'+tbodyId).html(response);
                }
        });    
    });
    function formvalidation(formId,seloption){
        $('#'+formId).validate({
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        rules: {
            seloption: {
                required: true,
            },
            stran:{
                transactionid:{
                    depends:function(element){
                        if(seloption ==2){
                            return true;
                        }else {
                            return false;
                        }
                    },
                },
                firstname:{
                    depends:function(element){
                        if(seloption ==3){
                            return true;
                        }else {
                            return false;
                        }
                    },  
                },
                email: {
                    depends:function(element){
                        if(seloption ==1){
                            return true;
                        }else {
                            return false;
                        }
                    },  
                },
            },
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        messages: {
            seloption: {
                required: "Select search Option",
            },
            stran:{
                email:"Please Enter Email",  
                firstname:"Letters and space only",
                transactionid:"(a-zA-Z0-9_-) and space only",
            },
        }
    });
    }
});
  window.FontAwesomeConfig = {
    searchPseudoElements: true
  }
</script>
@endsection