@extends('layouts.admin')
@section('content')
<style>
    .btn-signin{text-transform: capitalize;letter-spacing: 0px;}
    #add-cate{position: static !important;}
</style>
<div class="slim-mainpanel">
    <div class="container-fluid">
        <div class="slim-pageheader">            
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL('admin')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category</li>
            </ol>
            <h6 class="slim-pagetitle">Category</h6>
        </div>        
        <!--<div class="alert alert-success statusmsg" style="display:none;width: 40%;margin: 0 auto;top: -49px;margin-bottom: -40px;">Updated Successfully.</div>-->
        <div class="section-wrapper">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="text-right">
                        <a class="btn btn-primary btn-signin btn-oblong" id="add-cate" >Add a New Category</a>
                    </div>
                    <div id="message" style="position: absolute; top: 0;"></div>       
                    <!-- Tab panes -->
                    <div class="tab-content custom-content">                        
                        <div class="tab-pane  active">
                            <div class="table-responsive">
                                <table class="table table-bordered my-table" id="example">
                                    <thead>
                                        <tr>                                            
                                            <th>Category Name</th>
                                            <th>Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($allCategory)>0)
                                        @foreach($allCategory as $cat)
                                        <tr>                                            
                                            <td class="edit-it">{{$cat->category_name}}</td>
                                            <td>
                                                <span class="edit"><a class="tabledit-edit-button btn btn-success btn-icon active" style="float: none;"><div><i class="icon ion-edit"></i></div></a></span>
                                                <span id="{{encrypt($cat->id)}}" class="save"><a class="tabledit-save-button btn btn-primary btn-icon" style="float: none;"><div>
                                                            <!--<i class="icon ion-folder"></i>-->
                                                            <i class="icon ion-checkmark"></i>
                                                        </div></a></span>
                                                <span class="remove"><a id="{{$cat->id}}" class="tabledit-delete-button btn btn-danger btn-icon deletecat" style="float: none;"><div><i class="icon ion-trash-b"></i></div></a></span>
                                            </td>
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

    <script>
        window.FontAwesomeConfig = {
            searchPseudoElements: true
        }
    </script>
    <script>
        $(document).ready(function () {
            $("#add-cate").click(function () {

                $("#example").each(function () {

                    var tds = '<tr>\n\
                            <td class="edit-it"></td>\n\
                            <td>\n\
                            <div class="table_btn action-btns">\n\
                            <span class="edit">\n\
                            <a class="tabledit-edit-button btn btn-success btn-icon active" style="float: none;">\n\
                            <div><i class="icon ion-edit"></i></div>\n\
                            </a>\n\
                            </span>\n\
                            <span id="" class="save">\n\
                            <a class="tabledit-save-button btn btn-primary btn-icon" style="float: none;">\n\
                            <div><i class="icon ion-checkmark"></i></div>\n\
                            </a>\n\
                            </span>\n\
                            <span class="remove">\n\
                            <a id="" class="tabledit-delete-button btn btn-danger btn-icon deletecat lastaddid" style="float: none;">\n\
                            <div><i class="icon ion-trash-b"></i></div>\n\
                            </a>\n\
                            </span>\n\
                            </div>\n\
                            </td>\n\
                            </tr>';

                    tds += '</tr>';
                    if ($('tbody', this).length > 0) {
                        $('tbody', this).append(tds);
                    } else {
                        $(this).append(tds);
                    }
                });
                $(".edit").last().trigger("click");
            });

            $(document).on('click', '.edit', function (event) {
                $(this).hide();
                var currentTD = $(this).parents('tr').find('.edit-it ');
                $.each(currentTD, function () {
                    $(this).attr('contenteditable', 'true');
                    $(this).addClass('editable');
                });
                currentTD.eq(0).focus();
                $(this).parents('tr').find('.save').show();
            });


            $(document).on('click', '.save', function (event) {
                $("#message").html('');
                $('#message').stop( true, true ).fadeOut()
                $('#message').fadeIn();

                var currentTD2 = $(this).parents('tr').find('.edit-it ');
                var thisObj = this;

//                var firstTd = currentTD2.eq(0).text();
                
                if(currentTD2.eq(0).text() != ''){
                    var firstTd = currentTD2.eq(0).text();
                }else{
                    $("#message").append('<div class="alert alert-danger">Please Enter Category Name</div>');                   

                            $('#message').fadeOut(10000, function () {
                                currentTD2.eq(0).focus();
                            }).end();
                }
                
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

                var id = $(this).attr('id');
                
                if (id == "") {
                    var actionUrl = '/category';
                    var actionType = 'POST';
                    var actionData = {'firstTd': firstTd};
                } else {
                    var actionUrl = '/category/' + id;
                    var actionType = 'PUT';
                    var actionData = {'firstTd': firstTd, id: id};
                }
                $.ajax({
                    url: actionUrl,
                    type: actionType,
                    data: actionData,
                    success: function (result)
                    {
                        // console.log('success',result);
                        result = JSON.parse(result);
                        if (result.status == "success") {
                            $('#message').html('<div class="alert alert-success">' + result.message + '</div>').fadeOut(5000);
                            $('.lastaddid').attr('id', result.lastInsertedId);
                            window.scrollTo({
                                top: 200,
                                left: 0,
                                behavior: 'smooth'
                            });

                            $(thisObj).hide();
                            $.each(currentTD2, function () {
                                $(this).removeAttr('contenteditable', 'true');
                                $(this).removeClass('editable');
                            });
                            $(thisObj).parents('tr').find('.edit ').show();
                        } else {
                            //if query failed
                            $("#message").append('<div class="alert alert-danger">' + result.message + '</div>');
                        }
                    },
                    error: function (reject) {
                        if (reject.status === 422) {
                            var obj = $.parseJSON(reject.responseText);

                            $("#message").append('<div class="alert alert-danger"></div>');

                            $.each(obj.errors, function (key, val) {
                                $("#message .alert-danger").append('<div>' + val + '</div>');
                            });

                            window.scrollTo({
                                top: 200,
                                left: 0,
                                behavior: 'smooth'
                            });

                            $('#message').fadeOut(10000, function () {
                                currentTD2.eq(0).focus();
                            });
                        }
                    }
                });




            });
            $(document).on('click', '.deletecat', function (e) {
                e.preventDefault();
                var currentTR = $(this).parents('tr');
                if($(this).attr('id') != ''){
                    var id = $(this).attr('id');
                }else{
                    currentTR.remove();
                }
                //alert(id);
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    url: '{{url("DeleteCat")}}',
                    type: 'post',
                    data: {id: id},
                    success: function () {
                        $('#message').fadeIn();
                        $('#message').html('<div class="alert alert-success">Successfully Deleted</div>').fadeOut(2000);
                         window.scrollTo({
                            top: 200,
                            left: 0,
                            behavior: 'smooth'
                        });
                        //location.reload();
                        currentTR.remove();
                    },
                    error: function () {
                        console.log("ajax call went wrong:");
                    },
                });
            });


        });

//        $(document).on('click', '.remove', function (event) {
//            $(this).parent().parent().parent().remove();
//        });
    </script>
    @endsection
