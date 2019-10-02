@extends('layouts.userdashboard')
@section('content')
<section id="tabs">
    <div class="">
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

                                                <h5 class="block-title">Tax settings</h5>
                                                

                                            </div>
                                            <div id="message"></div>
                                            <div class="">
                                            
                                                <a href="#!" class="btn  round-btn  hvr-sweep-to-top  blue-btn" id="add-tax" >Add a New Tax</a>


                                            </div>
                                           
                                        </div>
                                         <div class="col-md-12 extra-info">
                                        <p>Enter up to 200 taxes (for example, Tax, GST or VAT) that will be available for specific items and invoices. To edit an existing tax, make your changes then click Save.</p>
                                         </div>
                                         </div>
                                 
                                   
                                   
                                    <table class="table table-bordered my-table" id="example">
                    
                                                    <thead>
                                                        <tr>
                                                          
                                                            <th>Tax name    </th>
                                                            <th>    Tax rate     </th>
                                                            <th>Actions </th>
                                                          
                                                            
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      
                                                        <tr>
                                                          

                                                            <td class="edit-it">lorem ipsum</td>
                                                            <td class="edit-it">25% </td>
                                                            <td>
                                                            <div class="table_btn action-btns">
                            <span class="edit"><a href="#!"   class="btn bg-edit" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a></span>
                            <span class="save"><a href="#!"   class="btn bg-save" data-toggle="tooltip" title="" data-original-title="Save"><i class="fas fa-save"></i> Save</a></span>
                            <span class="remove"><a href="javascript:;" title="" class="btn bg-delete" > <i class="fas fa-trash-alt" aria-hidden="true"></i> Delete </a></span>
                        </div>
                    </td>
                                                            
                                                          

                                                        </tr>
                                                        
                                                       
                                                       
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
       
        var tds = '<tr><td class="edit-it"></td><td class="edit-it"></td><td><div class="table_btn action-btns"><span class="edit"><a href="#!" class="btn bg-edit" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a></span><span class="save"><a href="#!" class="btn bg-save" data-toggle="tooltip" title="" data-original-title="Save"><i class="fas fa-save"></i> Save</a></span><span class="remove"><a href="javascript:;" title="" class="btn bg-delete"> <i class="fas fa-trash-alt" aria-hidden="true"></i> Delete </a></span></div></td></tr>';
        // jQuery.each($('tr:last td', this), function () {
        //     tds += '<td class="edit-it">' + $(this).html() + '</td>';
        // });
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
    });
});

    $(document).on('click','.edit', function(event){
  $(this).hide();
  
   var currentTD = $(this).parents('tr').find('.edit-it');
        $.each(currentTD, function () {
            $(this).attr('contenteditable', 'true'); 
            $(this).addClass('editable'); 
        });
//  $('td').attr('contenteditable', 'true');  
  $(this).parents('tr').find('.save').show();
});
    $(document).on('click','.save', function(event){
    

  $(this).hide();
  $('.box').removeClass('editable');
   var currentTD2 = $(this).parents('tr').find('.edit-it');
        $.each(currentTD2, function () {
            $(this).removeAttr('contenteditable', 'true'); 
            $(this).removeClass('editable'); 
        });
//  $('.text').removeAttr('contenteditable');
//  $('.edit').show();
var currentTD2 = $(this).parents('tr').find('.edit ').show();
$('#message').html('<div class="alert alert-success alert-dismissible" style="margin-bottom:0px;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> New Tax Save</div>');
$(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });
});
$(document).on('click','.remove', function(event){
    $(this).parent().parent().parent().remove();
});

</script>
@endsection
