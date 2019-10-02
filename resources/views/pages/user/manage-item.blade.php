    @extends('layouts.userdashboard')
@section('content')
<!-- Tabs -->
<section id="tabs">
    <div class="content_height">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                @include('includes.invoice-menu')
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space">
                                            <div class="col-md-6">
                                                <h5 class="block-title">Manage Items</h5>
                                            </div>
                                            <div id="message"></div>  
                                            @if(session('status'))                                                
                                            <div class="alert alert-success alert-dismissible" id="msg"> 
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ session('status') }}
                                            </div>
                                            @endif
                                            <div class="">
                                                <a href="#!" class="btn  round-btn  hvr-sweep-to-top  blue-btn" data-toggle="modal" data-target="#add-item">Add New Item</a>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>                                                
                                                <th class="width_100">Item name</th>
                                                <th class="width_300">Description</th>                                                
                                                <th class="width_80">Price </th> 
                                                <th class="width_100">Tax Name</th> 
                                                <th class="width_120">Tax Rate</th>  
                                                <th class="width_150">Actions</th>    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($ItemList)>0)
                                            @foreach($ItemList as $Itemlist)
                                            <tr>                                                
                                                <td>{{$Itemlist->item_name}}</td>
                                                <td>{{$Itemlist->description}}</td>                                                
                                                <td>{{$Itemlist->price}} {{$Itemlist->currency}}</td>
                                                <td>@if($Itemlist->tax_name != ''){{$Itemlist->tax_name}}@else{{__('-')}}@endif</td>  
                                                <td>@if($Itemlist->rate != ''){{$Itemlist->rate}}@else{{__('-')}}@endif</td>
                                                <td>
                                                    <a id="{{encrypt($Itemlist->id)}}" class="btn bg-edit editmodalView" style="margin-left: -65px;" data-toggle="modal" data-target="#edit-item">Edit</a>
                                                    <a class="btn bg-delete deleteitem" id="{{encrypt($Itemlist->id)}}" style="position: absolute;">Delete</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr><td colspan="6">{{__('Data Not Available')}}</td></tr>
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
</section>
<!-- ./Tabs -->
<div class="modal fade " id="add-item">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Add new item</h4>
                <button type="button" class="close" data-dismiss="modal">X</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form class="common-form myform" id="itemsManage" action="{{url('/manage-item')}}" method="post">
                    {{ csrf_field() }}        
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <label>Item name</label>
                            <input type="text" class="form-control {{ $errors->has('item_name') ? ' is-invalid' : '' }}" name="item_name">
                            @if($errors->has('item_name'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('item_name') }}</strong>
                            </span> 
                            @endif
                        </div>                           
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <label>Description</label>
                            <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description"></textarea>
                            @if($errors->has('description'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span> 
                            @endif
                        </div>                            
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required">
                            <label>Price</label>
                            <input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" name="price">
                            @if($errors->has('price'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span> 
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Category</label>
                            <select class="form-control  {{ $errors->has('category') ? ' is-invalid' : '' }}" name="category" id="category">
                                <option value="">Please select category</option>      
                                @foreach($allCategory as $cat)                                                                                                                            
                                <option value="{{$cat->id}}">{{$cat->category_name}}</option>                                
                                @endforeach
                            </select>
                            @if($errors->has('category'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span> 
                            @endif
                        </div>
<!--                        <div class="col-md-6 form-group">
                            <label>Currency</label>
                            <select class="form-control {{ $errors->has('currency') ? ' is-invalid' : '' }}" name="currency">
                                <option value="" selected="">Please Select Currency</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>                                                      
                            </select>
                            @if($errors->has('currency'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('currency') }}</strong>
                            </span> 
                            @endif
                        </div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required">
                            <label>Tax</label>
                            <select class="notclear form-control tax-select" name="tax">
                                <option value="no-tax" selected="">No Tax</option>
                                <option value="add-tax">Add Tax</option>      
                            </select>                            
                        </div>

                        <div class="col-md-3 form-group required tax-visible" style="display: none">
                            <label>Tax Name</label>
                            <select class="tax_name form-control {{ $errors->has('tax_name') ? ' is-invalid' : '' }}" name="tax_name"> 
                                <option value="" selected="">Please Select Tax</option>
                                @if(count($taxInfoList)> 0)
                                @foreach($taxInfoList as $taxlist)  
                                    <option value="{{$taxlist->tax_name}}">{{$taxlist->tax_name}}</option>                                
                                @endforeach
                                @endif
                            </select>
                            @if($errors->has('tax_name'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('tax_name') }}</strong>
                            </span> 
                            @endif
                            <!--<input type="text" class="form-control" placeholder="" value="">-->
                        </div>
                        <div class="col-md-3 form-group required tax-visible" style="display: none">
                            <label>Rate</label>
                            <input type="text" class="rateValue form-control {{ $errors->has('rate') ? ' is-invalid' : '' }}" name="rate" value="" readonly="">
                            @if($errors->has('tax_rate'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('rate') }}</strong>
                            </span> 
                            @endif
                        </div>                            
                    </div>                    
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="notclear  showloader btn btn-dark btn-block round-btn mt-20 mb-20" value="Save">
                        <!--<button type="button" class="btn btn-dark btn-block round-btn mt-20 mb-20" data-dismiss="modal">Save</button>-->
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="edit-item">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Edit item</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form class="common-form myform" id="editManage" action="{{URL('/manage-item/'.$user_id)}}" method="post">
                    <input type="hidden" name="id" id="editid">
                    <input type="hidden" name="_method" value="PUT" />
                    {{ csrf_field() }}        
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <label>Item name</label>
                            <input type="text" class="form-control {{ $errors->has('item_name') ? ' is-invalid' : '' }}" name="item_name" id="item_name">
                            @if($errors->has('item_name'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('item_name') }}</strong>
                            </span> 
                            @endif
                        </div>                           
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group required">
                            <label>Description</label>
                            <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="description"></textarea>
                            @if($errors->has('description'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span> 
                            @endif
                        </div>                            
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group required">
                            <label>Price</label>
                            <input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" name="price"  id="price">
                            @if($errors->has('price'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span> 
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Category</label>
                            <select class="form-control notclear  {{ $errors->has('category') ? ' is-invalid' : '' }}" name="category" id="category">                                
                                @foreach($allCategory as $cat)                                                                                                                            
                                <option value="{{$cat->id}}">{{$cat->category_name}}</option>                                
                                @endforeach
                            </select>
                            @if($errors->has('category'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span> 
                            @endif  
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-6 form-group required tax-visible">
                            <label>Tax Name</label>
                            <select id="tax_name" class="tax_name_edit form-control {{ $errors->has('tax_name') ? ' is-invalid' : '' }}" name="tax_name">    
                                <option value="" selected="">Please Select Tax</option>
                                @foreach($taxInfoList as $taxlist)                                                                                                                            
                                <option value="{{$taxlist->tax_name}}">{{$taxlist->tax_name}}</option>                                
                                @endforeach
                            </select>
                            @if($errors->has('tax_name'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('tax_name') }}</strong>
                            </span> 
                            @endif
                            <!--<input type="text" class="form-control" placeholder="" value="">-->
                        </div>
                        <div class="col-md-6 form-group required tax-visible">
                            <label>Rate</label>
                            <input id="rate" type="text" class="rateValueEdit form-control {{ $errors->has('rate') ? ' is-invalid' : '' }}" name="rate" value="" readonly="">
                            @if($errors->has('tax_rate'))                                                
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $errors->first('tax_rate') }}</strong>
                            </span> 
                            @endif
                        </div>                            
                    </div>                    
                    <div class="col-lg-10 margin-auto">
                        <input type="submit" class="notclear showloader btn btn-dark btn-block round-btn mt-20 mb-20" value="Save">
                        <!--<button type="button" class="btn btn-dark btn-block round-btn mt-20 mb-20" data-dismiss="modal">Save</button>-->
                    </div>  
                </form>
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
    $('.modal').on('hidden.bs.modal', function (e) {
        $(this)
          .find("input,textarea,select")
          .not('.notclear ').val('')
             .end()
          .find('.invalid-feedback').removeClass('error').text('')
             .end() 
          .find("input[type=checkbox], input[type=radio]")
             .prop("checked", "")
             .end()
          .find('.invalid-feedback').removeClass('error').text('')
             .end();
      });

    $(document).ready(function () {
        $(".tax-select").change(function () {
            if ($(this).val() == "add-tax") {
                $(".tax-visible").show();
            }
            if ($(this).val() == "no-tax") {
                $(".tax-visible").hide();
            }
        });


            $('#editManage').validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                rules: {
                    item_name: {
                        required: true,
                        maxlength : 50,
                    },
                    description: {
                        required: true,
                        maxlength : 110
                    },
                    currency: {
                        required: true,
                    },
                    price: {
                        required: true,
                        number: true,
                    },                   
                    category: {
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
                    item_name: {
                        required: "Item Name Required",
                         maxlength : "Maximum 50 characters allowed",
                    },
                    description: {
                        required: "Description Required",
                        maxlength : "Description Maximum 110 characters allowed",
                    },
                    currency: {
                        required: "Currency Required",
                    },
                    price: {
                        required: "Price Required",
                        number: "Allow Number Only",
                    },                   
                    category: {
                        required: "Category Required",
                    }
                }
            });

        
            $('#itemsManage').validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                rules: {                    
                    tax_name: {
                        required: true,
                    },
                    rate: {
                        required: true,
                    },
                    item_name: {
                        required: true,
                         maxlength : 50
                    },
                    description: {
                        required: true,
                        maxlength : 110
                    },
                    currency: {
                        required: true,
                    },
                    price: {
                        required: true,
                        number: true,
                    },                   
                    category: {
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
                    
                    tax_name: {
                        required: "Tax Name Required",
                    },
                    rate: {
                        required: "Rate Required",
                    },item_name: {
                        required: "Item Name Required",
                        maxlength : "Maximum 50 characters allowed",
                    },
                    description: {
                        required: "Description Required",
                        maxlength : "Description Maximum 110 characters allowed",
                    },
                    currency: {
                        required: "Currency Required",
                    },
                    price: {
                        required: "Price Required",
                        number: "Allow Number Only",
                    },                   
                    category: {
                        required: "Category Required",
                    }
                }
            });
        

        $(document).on('click', '.editmodalView', function (e) {            
            e.preventDefault();
            var id = $(this).attr('id');
            //alert(id);
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: '/edit-view-item',
                method: 'POST',
                data: {id: id},
                success: function (result) {
                    //console.log(result);                    
                    obj = JSON.parse(result);                    
                    $('#editid').val(obj.id);
                    $('#item_name').val(obj.item_name);
                    $('#description').val(obj.description);
                    $('#price').val(obj.price);
                    //$('#currency option[value=' + obj.currency + ']').attr("selected", "selected");
                    
                        $('#tax_name option[value=' + obj.tax_name + ']').attr("selected", "selected");
                   
                        $('select#category option[value=' + obj.invoice_cat_id + ']').attr("selected", "selected");
                   
                        $('#rate').val(obj.rate);
                                      
                    
                },
                error: function () {
                    console.log("ajax call went wrong:");
                },
            });
        });

        $(document).on('change', '.tax_name', function () {
            var tax_name = $('.tax_name').val();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: '{{url("getTaxRateOnChange")}}',
                type: 'post',
                data: {tax_name: tax_name},
                success: function (result) {
                    $('.rateValue').val(result);
                },
                error: function () {
                    console.log("ajax call went wrong:");
                },
            });
        });
        $(document).on('change', '.tax_name_edit', function () {
            var tax_name = $('.tax_name_edit').val();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: '{{url("getTaxRateOnChange")}}',
                type: 'post',
                data: {tax_name: tax_name},
                success: function (result) {
                    $('.rateValueEdit').val(result);
                },
                error: function () {
                    console.log("ajax call went wrong:");
                },
            });
        });

        $(document).on('click', '.deleteitem', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
//            alert(id);
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: '{{url("DeleteItem")}}',
                type: 'post',
                data: {id: id},
                success: function () {
                    $('#message').fadeIn();
                    $('#message').html('<div class="alert alert-success">Successfully Deleted</div>').fadeOut(5000);
                    location.reload();
                },
                error: function () {
                    console.log("ajax call went wrong:");
                },
            });
        });

    });
</script>
@endsection