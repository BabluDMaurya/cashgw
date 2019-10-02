<ul class="sidebar-nav">
<!--    <li><a href="{{URL('withdraw')}}">Withdraw money</a></li>-->
    <li><a href="{{URL('/create-invoice/'.$user_id)}}">Create Invoice</a></li>
    <li><a href="{{URL('/individual-request-payment/'.$user_id)}}">Request Money </a></li>
    <li><a href="{{URL('/individual-send-money/'.$user_id)}}">Send Money</a></li>
    <li><a href="{{URL('/individual-recieved-invoice/'.$user_id)}}">Recieved Invoice</a></li>
    <li
        @if(Request::segment(1) == 'business-recived-request-money')
        {{'class=active'}}
        @else
        {{'class='}}
        @endif
        ><a href="{{URL('/individual-recived-request/'.$user_id)}}">Received Request</a>
    </li>
    <li
        @if(Request::segment(1) == 'business-sent-request')
        {{'class=active'}}
        @else
        {{'class='}}
        @endif
        >
        <a href="{{URL('/individual-sent-request/'.$user_id)}}">Sent Request</a>
    </li>
   <li><a href="{{URL('/individual-recived-money/'.$user_id)}}">Recieved Money</a></li>
                        
</ul>