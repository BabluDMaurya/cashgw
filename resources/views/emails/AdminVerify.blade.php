<!DOCTYPE html>
<html>
<head>
    <title>Account Verification</title>
</head>
<body>
    <h2>Dear Admin</h2><h3>{{ $userfname }} {{ $userlname }}</h3> 
    is newly joined cashgw payment portal . Please check details and verify user.
    <br/>
    Thank you. 
    <br/>
    <a href="{{url('admin/userverify', $id)}}">Verify User</a>
</body>
</html>