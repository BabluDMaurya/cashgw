<!DOCTYPE html>
<html>
<head>
    <title>Account Verification</title>
</head>
<body>
    <h2>Dear Admin</h2>
    <p>{{ $maildata['fname'] }} {{ $maildata['lname'] }} is requested you for 
        @if($maildata['currency'] == 1)
        {{$maildata['balance']}}(USD)
        @else
        {{$maildata['balance']}}(EURO)
        @endif
        Balance.
    </p>
    <p>Reference Code : {{$maildata['refcode']}}</p>
    <p>Bank Name: {{$maildata['bank_name']}}</p>
    <p>A/C No. : {{$maildata['acno']}}</p>
    
    Thank you. 
    <br/>
    CASHGW Team.
    <br/>
<!--    <a href="{{url('admin/userverify', $maildata['userid'])}}">Accept Request</a>-->
</body>
</html>