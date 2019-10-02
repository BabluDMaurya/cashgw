<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CASHGW</title>
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="lib/chartist/css/chartist.css" rel="stylesheet">
    <link href="lib/rickshaw/css/rickshaw.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/slim.css">
  </head>
  <body>
    <div class="slim-header">
      	<div class="container-fluid">
        	<div class="slim-header-left">
                    <h2 class="slim-logo">
                        <a href="index.php">
                            <img class="img-fluid" src="img/logo.png" />
                        </a>
                    </h2>
        	</div><!-- slim-header-left -->
	        <div class="slim-header-right">
		      	<div class="dropdown dropdown-c">
		            <a href="#" class="logged-user" data-toggle="dropdown">
		              	<img src="img/person.jpg" alt="">
		              	<span>Admin</span>
		              	<i class="fa fa-angle-down"></i>
		            </a>
		            <div class="dropdown-menu dropdown-menu-right">
		              	<nav class="nav">
                                    <a href="#!" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
                                    <a href="#!" class="nav-link"><i class="icon ion-compose"></i> Edit Profile</a>
                                    <a href="login.php" class="nav-link"><i class="icon ion-forward"></i> Sign Out</a>
		              	</nav>
		            </div><!-- dropdown-menu -->
		      	</div><!-- dropdown -->
	        </div><!-- header-right -->
      	</div><!-- container-fluid -->
    </div><!-- slim-header -->

    <div class="slim-navbar">
      	<div class="container-fluid">
        	<ul class="nav">
          		<li class="nav-item <?php if($pgname =='dashboard'){echo 'active';}?>">
            		<a class="nav-link" href="index.php">
              			<i class="icon ion-ios-home-outline"></i>
              			<span>Dashboard</span>
            		</a>
          		</li>
	          	<li class="nav-item with-sub <?php if($pgname =='kyc-approval'){echo 'active';}?>">
		            <a class="nav-link" href="kyc-approval.php">
		              	<i class="icon ion-ios-paper-outline"></i>
		              	<span>KYC Approval</span>
		            </a>
		            <div class="sub-item">
		              	<ul>
			                <li><a href="kyc-approval.php">Individual</a></li>
			                <li><a href="kyc-approval-business.php">Business</a></li>
		              	</ul>
	              	</div>
	          	</li>
		      	<li class="nav-item <?php if($pgname =='request-money'){echo 'active';}?>">
		            <a class="nav-link" href="request-money.php">
		              	<i class="icon ion-ios-cloud-upload-outline"></i>
		              	<span>Request Money</span>
		            </a>
		      	</li>
	         	<li class="nav-item <?php if($pgname =='category'){echo 'active';}?>">
		            <a class="nav-link" href="category.php">
		              	<i class="icon ion-ios-gear-outline"></i>
		              	<span>Category</span>
		            </a>
		        </li>
		        <li class="nav-item <?php if($pgname =='manage-accounts'){echo 'active';}?>">
		            <a class="nav-link" href="manage-accounts.php">
		              	<i class="icon ion-ios-person-outline"></i>
		              	<span>Manage Accounts</span>
		            </a>
<!--		            <div class="sub-item">
		              	<ul>
                                    <li><a href="manage-accounts.php">Manage Individual</a></li>
                                    <li><a href="manage-accounts.php">Manage Business</a></li>
		              	</ul>
                            </div>-->
		        </li>
		        <li class="nav-item <?php if($pgname =='contact-management'){echo 'active';}?>">
		            <a class="nav-link" href="contact-management.php">
		              <i class="icon ion-ios-telephone-outline"></i>
		              <span>Contact Management</span>
		            </a>
		        </li>
        	</ul>
      	</div><!-- container-fluid -->
    </div><!-- slim-navbar -->