<nav>
    <div class="container pd0">
        <div class="nav nav-tabs " id="nav-tab" role="tablist">
            <a class="nav-item nav-link" href="{{URL('/manage-invoice/'.$user_id)}}" >Manage invoices</a>
            <a class="nav-item nav-link active" href="{{URL('/create-invoice/'.$user_id)}}">Create invoice</a>
            <a class="nav-item nav-link" href="{{URL('manage-item/'.$user_id)}}">Items</a>
            <div class="nav-item nav-link dropdown" >
                <a  class="dropdown-toggle" data-toggle="dropdown">
                    Settings <i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{URL('/address-book/'.$user_id)}}">Address Book</a>
                    <a class="dropdown-item" href="{{URL('/business-information/'.$user_id)}}">Business Information</a>
                    <a class="dropdown-item" href="{{URL('/tax-information/'.$user_id)}}">Tax Information</a>
                    <!--<a class="dropdown-item" href="{{URL('templates')}}">Templates</a>-->
                </div>
            </div>                            
            <a class="nav-item nav-link" href="{{URL('help')}}">Help</a>                         
        </div>
    </div>
</nav>