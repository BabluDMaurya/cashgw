@extends('layouts.businessdashboard')
@section('content')
<section id="tabs">
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
               @include('includes.business-invoice-menu')
                <div class="main-content">
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="row">
                                        <div class="title-equal-space">
                                            <div class="col-md-6">
                                                <h5 class="block-title ">Manage Invoices </h5>
                                                <div id="msg"></div>
                                            </div>
                                            <div class="m-lr">
                                                <a href="{{URL('business-request-payment/'.$user_id)}}" class="btn light-grey-btn round-btn hvr-sweep-to-top ">Request Payment</a>
                                                <a href="{{URL('business-create-invoice/'.$user_id)}}" class="btn  round-btn  hvr-sweep-to-top  blue-btn" >Create Invoice</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row filter-section">
                                        <form class="common-form select-boxes mb-0 m-lr">
                                            <div>
                                                <select class="form-control" id="archive_status">
                                                    <option value="0" selected>Active</option>   
                                                    <option value="1">Archived</option>                                                                                          
                                                </select>
                                            </div>
                                            <div>
                                                <ul class="filter-list">
                                                    <li><a invoice_status="all" class="InvoiceStatusAjax active">All</a></li>
                                                    <li><a invoice_status="1" class="InvoiceStatusAjax">Draft</a></li>
                                                    <li><a invoice_status="2" class="InvoiceStatusAjax">Scheduled</a></li>                                                         
                                                    <li><a invoice_status="3" class="InvoiceStatusAjax">Unpaid</a></li>
                                                    <li><a invoice_status="4" class="InvoiceStatusAjax">Cancelled</a></li>    
                                                    <li><a invoice_status="5" class="InvoiceStatusAjax">Paid</a></li> 
                                                </ul>
                                            </div>
                                            <div class="search-with-icon">
                                                <input id="search" type="text" class="form-control" placeholder="Search">
                                            </div>
                                        </form>
                                    </div>
                                    <div id="message"></div>
                                    <table class="table table-bordered my-table mb-0">
                                        <td width="50px">
                                            <div class="position-relative">
                                                <label class="l-checkbox">       
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </td>                                     
                                        <td >
                                            <form class="common-form select-boxes mb-0">
                                                <select class="form-control" id="SelectAllActions">
                                                    <option selected="" disabled="" value="">Batch Actions</option>
                                                    <option>Remind</option>
                                                    <option value="4">Cancel</option>
                                                    <option value="1">Archive</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="text-right" >
                                            <div class="download-text manage-inv-download">
                                                <form action="{{URL('/business-manage-invoice-pdfdownload')}}" id="downloaddataform" name="downloaddataform" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="archive_status" value="">
                                                    <input type="hidden" name="invoice_status" value="">
                                                    <input type="hidden" name="role" value="">
                                                    <input class="btn btn-download" type="submit" value="Download">
                                                </form>                                                
                                            </div>
                                        </td>
                                    </table>
                                    <table class="table table-bordered my-table" id="searchTable">
                                        <thead>
                                            <tr>
                                                <th width="50px"></th>
                                                <th>Date</th>
                                                <th width="">Invoice </th>
                                                <th>Recipient </th>
                                                <th>Status  </th>
                                                <th>Actions </th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="replaceAjaxDiv">
                                                
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
    $(document).ready(function () {
        $(document).on('change', '#archive_status', function () {
            InvoiceStatusAjax(); 
        });
        
        $(document).on('click', '.InvoiceStatusAjax', function () {
            $('.InvoiceStatusAjax').removeClass("active");
            $(this).addClass("active");
            InvoiceStatusAjax(); 
        });
        
        InvoiceStatusAjax(); 
        
        function InvoiceStatusAjax() {
            var archive_status = $('#archive_status').val();
            var invoice_status = $('.InvoiceStatusAjax.active').attr('invoice_status');
            var role = '2';
            
            $('#downloaddataform').find('input[name=archive_status]').val(archive_status);
            $('#downloaddataform').find('input[name=invoice_status]').val(invoice_status);     
            $('#downloaddataform').find('input[name=role]').val(role);
            
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $('.loader').show();
            $.ajax({
                url: BASE_URL + '/business-invoice-status-ajax',
                type: "POST",
                data: {"archive_status": archive_status,invoice_status:invoice_status,role:role},
                success: function (result)
                {
                    $('.loader').hide();
                    $('#replaceAjaxDiv').html(result);
                }
            });
        }       
        
        
        $(document).on('change', '#SelectAllActions', function () {
            var batch_action_status = $('#SelectAllActions').val();
            var chkinvoiceid = [];
            $.each($("input[name='chkinvoiceid']:checked"), function(){            
                chkinvoiceid.push($(this).val());
            });           
            // var sendChkInvId = chkinvoiceid.join(", ");
            $.ajax({
                url: BASE_URL + '/ChangeBatchAction',
                type: "POST",
                data: {chkinvoiceid:chkinvoiceid,batch_action_status:batch_action_status},
                success: function ()
                {
                   InvoiceStatusAjax();                    
                }
            });
        });
        
        //edit invoice
        $(document).on('change', '#selectInvoiceOptions', function (){
           var selected_id = $( this ).val(); 
           var link = $('option:selected', this).attr('link');  
           $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
           if(link == 'business-edit-invoice'){
                window.location.href = BASE_URL + '/'+link+'/'+selected_id;
           }else if(link == 'business-copy-invoice'){
                window.location.href = BASE_URL + '/'+link+'/'+selected_id;
           }else if(link == 'business-print-invoice'){
               printInvoice(selected_id);
           }else if(link == 'business-generate-pdf'){
               window.location.href = BASE_URL + '/'+link+'/'+selected_id;
           }else if(link == 'business-delete-draft-invoice' || link == 'business-cancel-invoice'){
               deleteOrCancelInvoice(selected_id,link);
           }           
           $('#selectInvoiceOptions').val('');
        });

        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        
        function printInvoice(selected_id){
            //   alert(selected_id);
               $.ajax({
                url: BASE_URL + '/PrintInvoiceView',
                type: "POST",
                data: {selected_id:selected_id},
                success: function (divToPrint)
                {
            	  var newWin=window.open('','Print-Window');
            
            	  newWin.document.open();
            
            	  newWin.document.write('<html><body onload="window.print()">'+divToPrint+'</body></html>');
            
            	  newWin.document.close();
            
            	  setTimeout(function(){newWin.close();},10);
                }
            });            
        };
        
        function deleteOrCancelInvoice(selected_id,link){            
            $.ajax({
                url: BASE_URL + '/business-delete-cancel-invoice',
                type: "POST",
                data: {selected_id:selected_id,link:link},
                success: function (result)
                {
                  if(result == 1){
                      $('#msg').html('<div class="alert alert-success alert-dismissible">Invoice Deleted.</div>');}
                  else{
                      $('#msg').html('<div class="alert alert-success alert-dismissible">Invoice Cancelled.</div>');
                  }                  
            	  InvoiceStatusAjax();
                }
            });   
        }

    });    
</script>
@endsection

