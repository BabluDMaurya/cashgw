<!DOCTYPE html>
<html>
<head>
    <title>KYC</title>
</head>
    <body>
    <h2>Thank you {{ $userfname }} {{ $userlname }}</h2><h3>Your KYC Completed</h3>
    <br/>
    Please click on the below link to activate your cashgw account
    <br/>
    <a href="{{url('user/bukycverify', $verifyUser)}}">Verify KYC</a>
    </body>
</html>