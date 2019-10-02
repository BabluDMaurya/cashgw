<ul class="nav">
    <li class="nav-item @if(Request::segment(1) == 'admin') active @endif">
        <a class="nav-link" href="{{URL('/admin')}}">
            <i class="icon ion-ios-home-outline"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item with-sub @if(Request::segment(1) == 'individual-user-verification') active @endif">
        <a class="nav-link" href="{{url('/individual-user-verification')}}">
            <i class="icon ion-ios-paper-outline"></i>
            <span>Approval Requests</span>
        </a>
        <div class="sub-item">
            <ul>
                <li><a href="{{url('/individual-user-verification')}}">KYC Individual</a></li>
                <li><a href="{{url('/business-user-verification')}}">KYC Business</a></li>
                <li><a href="{{url('/primary-address-approval')}}">Primary Address Approval</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if(Request::segment(1) == 'manage-payment-request') active @endif">
        <a class="nav-link" href="{{URL('/manage-payment-request')}}">
            <i class="icon ion-ios-cloud-upload-outline"></i>
            <span>Request Money</span>
        </a>
    </li>
    <li class="nav-item @if(Request::segment(1) == 'category') active @endif">
        <a class="nav-link" href="{{URL('/category')}}">
            <i class="icon ion-ios-gear-outline"></i>
            <span>Category</span>
        </a>
    </li>
    <li class="nav-item @if(Request::segment(1) == 'manage-accounts') active @endif">
        <a class="nav-link" href="{{URL('/manage-accounts')}}">
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
    <li class="nav-item @if(Request::segment(1) == 'contact-management') active @endif">
        <a class="nav-link" href="{{URL('/contact-management')}}">
            <i class="icon ion-ios-telephone-outline"></i>
            <span>Contact Management</span>
        </a>
    </li>
</ul>