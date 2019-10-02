<?php 
$DB = "cashbnxh_wdipl";
$US = "cashbnxh_cashgw";
$PS = "?ylV?=AMVY@4";
$HT = "localhost";

// Create connection
$conn = mysqli_connect($HT, $US, $PS, $DB);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO testimonials (name, description, image, is_deleted)
VALUES ('Bablu', 'Hello bablu hoppe your are doing well.', 'c1.png',0)";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
//-------/usr/local/bin/php /home/cashbnxh/public_html/cronjonschedule.php
mysqli_close($conn);
?>