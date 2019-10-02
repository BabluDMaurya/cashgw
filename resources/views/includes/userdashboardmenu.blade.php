<div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{URL('/')}}">
                <img src="{{URL('/public/images/logo.png')}}">
            </a>
           
            <!-- Links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="{{URL('/individual-summary/'.$user_id)}}">Summary </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{URL('individual-activity/'.$user_id)}}">Activity</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{URL('/individual-balance/'.$user_id)}}">Balance</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{URL('/individual-send-request-money/'.$user_id)}}">Send And Request </a>
                </li>
<!--                <li class="nav-item ">
                    <a class="nav-link" href="{{URL('payment-preferences')}}">Payment Methods</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{URL('withdraw')}}">Widthdraw</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{URL('deposit')}}">Deposit</a>
                </li>-->
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <i class="fas fa-bell"></i>
                            @if(auth()->user()->unreadNotifications->count())
                            <span class="badge badge-light">{{auth()->user()->unreadNotifications->count()}}</span>
                            @endif
                        </a>
                         @if(auth()->user()->unreadNotifications->count())
                            <ul class="dropdown-menu">                           
                                @foreach(auth()->user()->unreadNotifications as $notification)                                    
                                    @switch($notification->type)
                                        @case('App\Notifications\SendMoney')
                                            <li>
                                                <a class="dropdown-item activetab" data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-recived-money/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                            </li>
                                            @break
                                        @case('App\Notifications\Invoice')                                            
                                            <li>
                                                <a class="dropdown-item activetab" data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-recieved-invoice/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                            </li>                                           
                                            @break  
                                        @case('App\Notifications\AdminNotify')
                                            @if($notification->data['type'] == 'PaymentRequestAdmin')
                                                <li>
                                                    <a class="dropdown-item activetab" data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-recived-money/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                                </li>
                                            @elseif($notification->data['type'] == 'SentRequest')
                                                <li>
                                                    <a class="dropdown-item activetab" data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-sent-request/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                                </li>
                                            @elseif($notification->data['type'] == 'accountUpdate')
                                                <li>
                                                    <a class="dropdown-item activetab"  data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-account/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                                </li>                                            
                                            @endif
                                        @break 
                                        @case('App\Notifications\RequestPayment')
                                                @if($notification->data['process'] == 1)
                                                    <li>
                                                        <a class="dropdown-item activetab" data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-recived-request/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                                    </li>
                                                @elseif($notification->data['process'] == 2)
                                                    @if($notification->data['action'] == 'accept')
                                                        <li>
                                                            <a class="dropdown-item activetab" data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-recived-money/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a class="dropdown-item activetab" data-currenttabchild="{{$notification->data['tab']}}" href="{{URL('/individual-sent-request/'.$user_id)}}">{{$notification->data['message']}}</a>                                                                                                                 
                                                        </li>
                                                    @endif
                                                    
                                                @endif
                                            @break
                                            @case('App\Notifications\UpdateApproval')
                                            @if($notification->data['type'] == 'UpdateApproval')
                                                    <li>
                                                        <a class="dropdown-item activetab" data-currenttabchild='{{$notification->data['tab']}}' href="{{URL('/individual-account/'.$user_id)}}">{{$notification->data['message']}}</a>                            
                                                    </li>                                            
                                                @endif
                                         @break
                                        @default
                                            <li>
                                                <span>Something went wrong, please try again</span>
                                            </li>
                                            
                                    @endswitch                                
                                @endforeach        
                            </ul>
                        @endif                  
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class=" dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{URL('/individual-summary/'.$user_id)}}">Profile</a>
                            <a class="dropdown-item" href="{{URL('/individual-account/'.$user_id)}}">Account</a>
                            <a class="dropdown-item" href="{{URL('/individual-security/'.$user_id)}}">Security</a>
                            <a class="dropdown-item" href="{{URL('/individual-payment-history/'.$user_id)}}">Payment History</a>
                        </div>
                    </div>
<!--                    <a  class="nav-link" href="#"><i class="fas fa-cog"></i></a>-->
                </li>
             
                

                <!-- Dropdown -->
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