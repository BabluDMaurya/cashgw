<ul class="sidebar-nav">
<!--    <li><a href="{{URL('withdraw')}}">Withdraw money</a></li>-->
    <li><a href="{{URL('/business-create-invoice/'.$user_id)}}">Create Invoice</a></li>
    <li><a href="{{URL('/business-request-payment/'.$user_id)}}">Request Money </a></li>
    <li><a href="{{URL('/business-send-money/'.$user_id)}}">Send Money</a></li>
    <li><a href="{{URL('/business-recieved-invoice/'.$user_id)}}">Recieved Invoice</a></li>
    <li
        @if(Request::segment(1) == 'business-recived-request-money')
        {{'class=active'}}
        @else
        {{'class='}}
        @endif
        ><a href="{{URL('/business-recived-request/'.$user_id)}}">Recived Request</a>
    </li>
    <li
        @if(Request::segment(1) == 'business-sent-request') 
        {{'class=active'}}
        @else
        {{'class='}}
        @endif
        >
        <a href="{{URL('/business-sent-request/'.$user_id)}}">Sent Request</a>
    </li>
    <li><a href="{{URL('/business-recived-money/'.$user_id)}}">Recieved Money</a></li>
                        
</ul>