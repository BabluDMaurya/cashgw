<!DOCTYPE html>
<html>
<head>
    <title>Cancel Sent Request</title>
</head>
<body>
    
    @if($data['role'] != 'self')
        <h2>Dear Cashgw {{ $data['name'] == 'user' ? 'User' : 'Admin' }} </h2>
        <br/>
        Request of the 
        {{$data['currency_requested']}} {{$data['balance']}} amount cancel by user.
    @else
        <h2>Dear User </h2>
        <br/>
        You have cancel your request of
        {{$data['currency_requested']}} {{$data['balance']}} Amount.
    @endif
 <br/>
 <br/>
Thank you.
<br/>
CASHGW Team.
</body>
</html>