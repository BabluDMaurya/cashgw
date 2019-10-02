<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
<h2>Dear User,</h2>
<br/>
Please check invoice detail's, Your invoice has been generated. Please pay.
Followings are the customer invoice details:-
<p>Email: {{$userEmail}}</p> 
<p>Invoice Number: {{$invoiceNumber}}</p> 
<p>Invoice Date: {{$invoiceDate}}</p> 
<p>Due Date: {{$dueDate}}</p> 
<p>Grand Total: {{$invoiceTotal}}</p> 

<a href="{{url($url)}}/{{$invoiceId}}">Pay Now</a>
<br>
Thank You.
</body>
</html>
