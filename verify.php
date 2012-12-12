<?php
include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

if ($_POST['form_submitted'] == '1') {
##User is registering, insert data until we can activate it

$activationKey =  mt_rand(). mt_rand() ;
$name = $mysqli->real_escape_string($_POST['username']);
$password = $mysqli->real_escape_string($_POST['password']);
$email = $mysqli->real_escape_string($_POST['email']);

$query = "SELECT user_name, user_pass FROM users where user_email = '$email' or user_name = '$name'" ; 
$result = $mysqli->query($query);
$row = $result->fetch_array();
$rownum = $result->num_rows;
if($rownum >= 1)
{
echo "User Name or email already exists so please try forgot password"; 
return;
}


$sql="INSERT INTO users (user_name, user_pass, user_email,user_date, activationkey, status) VALUES ('$name', '$password', '$email',NOW(), '$activationKey', 'verify')";

if (!$mysqli->query($sql))
  {

  die('Error: ' . $mysqli->error());

  }


##Send activation Email
else
{
echo "An email has been sent to $_POST[email] with an activation key. Please check your mail to complete registration.";
$to      = $_POST[email];

$subject = " Monarch Forum Registration";

$message = "Welcome to our Forum!\r\rYou, or someone using your email address, has completed registration at this forum . You can complete registration by clicking the following link:\rhttps://mweigle418.cs.odu.edu/~stirumer/MonarchFan/verify.php?$activationKey\r\rIf this is an error, ignore this email and you will be removed from our mailing list.\r\rRegards,\ Monarch Forum Team";

$headers = 'From: Monarch Forums' . "\r\n" .

    'Reply-To: noreply@ YOURWEBSITE.com' . "\r\n" .

    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

} }else {

##User isn't registering, check verify code and change activation code to null, status to activated on success

$queryString = $_SERVER['QUERY_STRING'];

$query = "SELECT * FROM users"; 

$result = $mysqli->query($query) or die($mysqli->error());

echo "Congratulations! your account has been created.";


  while($row = $result->fetch_array()){

    if ($queryString == $row["activationkey"]){

      // echo "Congratulations!" . $row["user_name"] . " your account has been created.";

       $sql="UPDATE users SET activationkey = '', status='activated' WHERE user_id = $row[user_id]";

       if (!$mysqli->query($sql))

  {

        die('Error: ' . $mysqli->error());

  }

    }

  }

}
?>