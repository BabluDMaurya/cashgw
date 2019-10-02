<?php $pgname = "kyc-approval";
include 'header.php';
?>
    <div class="slim-mainpanel">
      	<div class="container-fluid">
	        <div class="slim-pageheader">
	          <ol class="breadcrumb slim-breadcrumb">
	            <li class="breadcrumb-item"><a href="#">Home</a></li>
	            <li class="breadcrumb-item active" aria-current="page">KYC Approval Request</li>
	          </ol>
	          <h6 class="slim-pagetitle">KYC Approval Request</h6>
	        </div>
	        <div class="section-wrapper">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <ul class="nav nav-tabs custom-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#all">All</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#pending">Pending</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#approved">Approved</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#rejected">Rejected</a>
                                        </li>
                                    </ul>
                            <!-- Tab panes -->
                            <div class="tab-content custom-content">
                                <div id="all" class="tab-pane active">
                                    <div class="table-responsive">
                                        <table class="table table-hover mg-b-0 table-primary text-center">
                                          <thead>
                                            <tr>
                                              <th class="text-left">Business Name</th>
                                              <th>Business Type</th>
                                              <th>DOB</th>
                                              <th>Date</th>
                                              <th>Country</th>
                                              <th>Email</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                              <th class="text-left" scope="row">ABC</th>
                                              <td>Business Type</td>
                                              <td>09/01/2019</td>
                                              <td>09/01/2019</td>
                                              <td>US</td>
                                              <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                              <th class="text-left" scope="row">ABC</th>
                                              <td>Business Type</td>
                                              <td>09/01/2019</td>
                                              <td>09/01/2019</td>
                                              <td>US</td>
                                              <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                              <th class="text-left" scope="row">ABC</th>
                                              <td>Business Type</td>
                                              <td>09/01/2019</td>
                                              <td>09/01/2019</td>
                                              <td>US</td>
                                              <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                              <th class="text-left" scope="row">ABC</th>
                                              <td>Business Type</td>
                                              <td>09/01/2019</td>
                                              <td>09/01/2019</td>
                                              <td>US</td>
                                              <td>abc@gmail.com</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="pending" class="tab-pane">
                                    <div class="table-responsive">
                                        <table class="table table-hover mg-b-0 table-primary text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Name</th>
                                                    <td>Business Type</td>
                                                    <th>DOB</th>
                                                    <th>Date</th>
                                                    <th>Country</th>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="text-left" scope="row">ABC</th>
                                                    <td>Business Type</td>
                                                    <td>09/01/2019</td>
                                                    <td>09/01/2019</td>
                                                    <td>US</td>
                                                    <td>abc@gmail.com</td>
                                                    <td class="action-btns text-center">
                                                        <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Approved">
                                                            <div>
                                                                <i class="icon ion-checkmark"></i>
                                                            </div>
                                                        </a> 
                                                        <a href="#" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Reject">
                                                            <div>
                                                                <i class="icon ion-close"></i>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left" scope="row">ABC</th>
                                                    <td>Business Type</td>
                                                    <td>09/01/2019</td>
                                                    <td>09/01/2019</td>
                                                    <td>US</td>
                                                    <td>abc@gmail.com</td>
                                                    <td class="action-btns text-center">
                                                        <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Approved">
                                                            <div>
                                                                <i class="icon ion-checkmark"></i>
                                                            </div>
                                                        </a> 
                                                        <a href="#" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Reject">
                                                            <div>
                                                                <i class="icon ion-close"></i>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left" scope="row">ABC</th>
                                                    <td>Business Type</td>
                                                    <td>09/01/2019</td>
                                                    <td>09/01/2019</td>
                                                    <td>US</td>
                                                    <td>abc@gmail.com</td>
                                                    <td class="action-btns text-center">
                                                        <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Approved">
                                                            <div>
                                                                <i class="icon ion-checkmark"></i>
                                                            </div>
                                                        </a> 
                                                        <a href="#" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Reject">
                                                            <div>
                                                                <i class="icon ion-close"></i>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left" scope="row">ABC</th>
                                                    <td>Business Type</td>
                                                    <td>09/01/2019</td>
                                                    <td>09/01/2019</td>
                                                    <td>US</td>
                                                    <td>abc@gmail.com</td>
                                                    <td class="action-btns text-center">
                                                        <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Approved">
                                                            <div>
                                                                <i class="icon ion-checkmark"></i>
                                                            </div>
                                                        </a> 
                                                        <a href="#" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Reject">
                                                            <div>
                                                                <i class="icon ion-close"></i>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left" scope="row">ABC</th>
                                                    <td>Business Type</td>
                                                    <td>09/01/2019</td>
                                                    <td>09/01/2019</td>
                                                    <td>US</td>
                                                    <td>abc@gmail.com</td>
                                                    <td class="action-btns text-center">
                                                        <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Approved">
                                                            <div>
                                                                <i class="icon ion-checkmark"></i>
                                                            </div>
                                                        </a> 
                                                        <a href="#" class="btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Reject">
                                                            <div>
                                                                <i class="icon ion-close"></i>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="approved" class="tab-pane">
                                    <div class="table-responsive">
                                        <table class="table table-hover mg-b-0 table-primary text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Name</th>
                                                    <th>Business Type</th>
                                                    <th>DOB</th>
                                                    <th>Date</th>
                                                    <th>Country</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                          <tbody>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="rejected" class="tab-pane">
                                    <div class="table-responsive">
                                        <table class="table table-hover mg-b-0 table-primary text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Name</th>
                                                    <th>Business Type</th>
                                                    <th>DOB</th>
                                                    <th>Date</th>
                                                    <th>Country</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                          <tbody>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                              <th class="text-left" scope="row">ABC</th>
                                              <td>Business Type</td>
                                               <td>09/01/2019</td>
                                              <td>09/01/2019</td>
                                              <td>US</td>
                                              <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" scope="row">ABC</th>
                                                <td>Business Type</td>
                                                <td>09/01/2019</td>
                                                <td>09/01/2019</td>
                                                <td>US</td>
                                                <td>abc@gmail.com</td>
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
<?php include 'footer.php'; ?>