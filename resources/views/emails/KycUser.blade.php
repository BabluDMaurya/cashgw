<!DOCTYPE html>
<html>
<head>
    <title>KYC</title>
</head>

<body>
<h2>Thank you {{ $userfname }} {{ $userlname }}</h2><h3>Your KYC Completed</h3>
<br/>
Your activation Code is <strong>P45454841</strong> , Please click on the below link to activate your cashgw account
<br/>
<a href="{{url('user/kycverify', $verifyUser)}}">Verify KYC</a>
</body>
</html>