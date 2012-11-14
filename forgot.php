<?php

session_start();

include("header.php");
require("config.php");

$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");
$email = $_POST['email'] ; 
$query = "SELECT user_name, user_pass FROM users where user_email = '$email'" ; 

$result = $mysqli->query($query);
$row = $result->fetch_array();
$rownum = $result->num_rows;

if($rownum == 1)
{
 $to = $_POST['email']; 
$subject = "Your password";  
$message   .= "Name:" . $row['user_name']. "\n\n";

$message   .= "Your password is:" . $row['user_pass']. "\n\n";
      
 $header = 'From: Monarch Forums' . "\r\n" .

    'Reply-To: noreply@ YOURWEBSITE.com' . "\r\n" .

    'X-Mailer: PHP/' . phpversion();     
     
$sent = mail($to,$subject,$message,$header);

print "Your password has been sent to your e mail address" ;
}
else
{
print "Invalid Email address.";
}



?>