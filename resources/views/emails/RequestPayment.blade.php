<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
    
    @if($user['email'] != 'user')
        <h2>Dear Cashgw Admin </h2>
        <br/>
        {{$user['email']}} has 
        @if($user['request_status'] != 1)
            send
        @else
            requested
        @endif
        you             
            @if($user['currency_requested'] != 1)
                EURO €
            @else
                USD $
            @endif
        {{$user['balance']}} Amount.
    @else
        <h2>Dear Cashgw User </h2>
        <br/>
        @if($user['request_status'] != 1)
            Your request accept of 
        @else
            You are  requeste to admin for 
        @endif
        
            @if($user['currency_requested'] != 1)
                EURO €
            @else
                USD $
            @endif
        {{$user['balance']}} Amount.
    @endif
 <br/>
 <br/>
Thank you.
<br/>
CASHGW Team.
</body>
</html>