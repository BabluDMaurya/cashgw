<?php 
if(isset($_POST['submit'])){
    // $to = "sushmita@wdipl.com"; // this is your Email address
    // $from = $_POST['email']; // this is the sender's Email address
    // $subject = "Forgot Password";
    // $message = $from . "Password Reset Link" . "\n\n" . "<a href='#'>Click here</a>";
    
    // $headers  = 'MIME-Version: 1.0' . "\r\n";
    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    // $headers = "From:" . $from;
    // $headers2 = "From:" . $to;
    // mail($to,$subject,$message,$headers);
    // echo "Mail Sent. Thank you " . $from . ", we will contact you shortly.";
    // // You can also use header('Location: thank_you.php'); to redirect to another page.
    // }
    
    $to = 'sushmita@wdipl.com';
    $subject = 'Forgot Password';
    $from = $_POST['email'];
     
    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     
    // Create email headers
    $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
     
    // Compose a simple HTML email message
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi</h1>' . $from;
    $message .= '<p style="color:#080;font-size:18px;">Your Password Reset Link</p>';
    $message = "<a href='http://dev.betadelivery.com/cash-gw/dashboard/reset.php'>Click here</a>";
    $message .= '</body></html>';
     
    // Sending email
    if(mail($to, $subject, $message, $headers)){
        echo 'Your mail has been sent successfully.';
    } else{
        echo 'Unable to send email. Please try again.';
    }
    
}
?>

<!DOCTYPE html>
<head>
<title>Form submission</title>
</head>
<body>
<form action="" method="post">
Email: <input type="text" name="email"><br>
<input type="submit" name="submit" value="Submit">
</form>
</body>
</html> 
