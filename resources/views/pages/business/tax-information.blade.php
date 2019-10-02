@extends('layouts.businessdashboard')
@section('content')
<section id="tabs">
    <div class="content_height">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                @include('includes.business-invoice-menu')
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space">
                                            <div class="col-md-6">
                                                <h5 class="block-title">Tax settings</h5>
                                            </div>                                           
                                            <div id="message"></div>                                                                                    
                                            <div class="">
                                                <a class="btn  round-btn  hvr-sweep-to-top  blue-btn" id="add-tax" >Add New Tax</a>
                                            </div>
                                        </div>
                                        <div class="col-md-12 extra-info">
                                            <p>Enter up to 200 taxes (for example, Tax, GST or VAT) that will be available for specific items and invoices. To edit an existing tax, make your changes then click Save.</p>
                                        </div>
                                    </div>                                    
                                    <table class="table table-bordered my-table" id="example">
                                        <thead>
                                            <tr>
                                                <th>Tax name</th>
                                                <th>Tax rate(%)</th>
                                                <th>Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($taxInfoList)>0)
                                            @foreach($taxInfoList as $taxlist)
                                            <tr>
                                                <td class="edit-it">{{$taxlist->tax_name}}</td>
                                                <td class="edit-it">{{$taxlist->tax_rate}} </td>
                                                <td>
                                                    <div class="table_btn action-btns">
                                                        <span class="edit"><a id="{{encrypt($taxlist->id)}}" class="btn bg-edit edittax" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a></span>
                                                        <span id="{{$taxlist->id}}" class="save"><a class="btn bg-save" data-toggle="tooltip" title="" data-original-title="Save"><i class="fas fa-save"></i> Save</a></span>
                                                        <span class="remove"><a id="{{$taxlist->id}}" class="btn bg-delete deletetax" > <i class="fas fa-trash-alt" aria-hidden="true"></i> Delete </a></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                                <tr><td colspan="3">{{__('Data Not Available')}}</td></tr>
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
<script>
    window.FontAwesomeConfig = {
        searchPseudoElements: true
    }
</script>
<script>
    $("#add-tax").click(function () {

        $("#example").each(function () {

            var tds = '<tr>\n\
                    <td class="edit-it"></td>\n\
                    <td class="edit-it"></td>\n\
                    <td>\n\
                    <div class="table_btn action-btns">\n\
                    <span class="edit">\n\
                    <a href="#!" class="btn bg-edit" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a>\n\
                    </span>\n\
                    <span id="" class="save">\n\
                    <a class="btn bg-save" data-toggle="tooltip" title="" data-original-title="Save"><i class="fas fa-save"></i> Save</a>\n\
                    </span>\n\
                    <span class="remove">\n\
                    <a id="" class="btn bg-delete deletetax lastaddid"> <i class="fas fa-trash-alt" aria-hidden="true"></i> Delete </a>\n\
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
        var currentTD = $(this).parents('tr').find('.edit-it');
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
        
        var currentTD2 = $(this).parents('tr').find('.edit-it');
        var thisObj = this;

        if(currentTD2.eq(0).text() =='' || currentTD2.eq(0).text() == null){
            $('#message').html('<div class="alert alert-danger">please Enter Tax name</div>');
            $('#message').fadeOut(10000, function(){
                            currentTD2.eq(0).focus();
                        });
        }else{
            var firstTd = currentTD2.eq(0).text();
            var secondTd = currentTD2.eq(1).text();
        }
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});        
        var id = $(this).attr('id');
        
        if (id == ""){
            var actionUrl  = '/tax-information';
            var actionType = 'POST';
            var actionData = {'firstTd': firstTd, 'secondTd': secondTd};
        } else {
            var actionUrl  = '/tax-information/'+id;
            var actionType = 'PUT';
            var actionData = {'firstTd': firstTd, 'secondTd': secondTd,id:id};
                }
        
            $.ajax({               
                url: actionUrl,
                type: actionType,
                data: actionData,
                success: function (result)
                {
                    // console.log('success',result);
                    result = JSON.parse(result);
                    if(result.status == "success"){
                        $('#message').html('<div class="alert alert-success">'+result.message+'</div>').fadeOut(5000);
                        $('.lastaddid').attr('id',result.lastInsertedId);
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
                        $("#message").append('<div class="alert alert-danger">'+result.message+'</div>');
        }
                },
                error: function (reject) {
                    if( reject.status === 422 ) {
                        var obj = $.parseJSON(reject.responseText);

                        $("#message").append('<div class="alert alert-danger"></div>');

                        $.each(obj.errors, function (key, val) {
                            $("#message .alert-danger").append('<div>'+val+'</div>');
    });

                        window.scrollTo({
                          top: 200,
                          left: 0,
                          behavior: 'smooth'
                        });
                        
                        $('#message').fadeOut(10000, function(){
                            currentTD2.eq(0).focus();
                        });
                    }
                }
            });
    });

    $(document).delegate('.deletetax', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var currentTR = $(this).parents('tr');
        
        if(id == '' || id == null){
            currentTR.remove();
        }
        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: '{{url("DeleteTaxInfo")}}',
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
                // location.reload();  
                currentTR.remove();
            },
            error: function () {
                console.log("ajax call went wrong:");
            },
        });
    });


//        $(document).on('click', '.remove', function (event) {
//            $(this).parent().parent().parent().remove();
//        });
</script>
@endsection
