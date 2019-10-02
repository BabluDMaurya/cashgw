<div class="container">
    <!-- Brand -->
    <a class="navbar-brand" href="{{URL('/')}}">
        <img src="{{URL('/public/images/logo.png')}}">
    </a>

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item ">
            <a class="nav-link" href="{{URL('admin/user-verification')}}">Manage Verification </a>
        </li>
    
        <li class="nav-item ">
            <a class="nav-link" href="{{URL('admin')}}">Manage Payment Request</a>
        </li>
        
         <li class="nav-item ">
            <a class="nav-link" href="{{URL('admin/primary-address-approval')}}">Primary Address Approval</a>
        </li>
        
        <li class="nav-item ">
                    <a href="{{ route('logout') }}" class="btn blue-btn round-btn hvr-sweep-to-top"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
    </ul>

</div>