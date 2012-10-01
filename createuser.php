<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<title> Creation</title>
</head>
<body>

<h3> User Creation </h3>
<?php

require("config.php");

$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");


 $name = $_POST['username'];
 $email = $_POST['email'];
 $password = $_POST['password'];
 
 if ($name == '' && $email == '')
 {
	echo "<p> oops you made a mistake </p>";
 
 }
 
 if ($password == '')
 {
	echo"<p> oops you fo0rgot the password </p>";
 
 }
 else
 {
 
 echo "<p>";
echo "Hello". $name;
echo "</p>";

echo "<p>";
echo " Your email address is ". $email;
echo"</p>";

$query = "Insert into users (user_name,user_pass,user_email,user_date,user_level)
 VALUES 
 ('". $name . "','"
  . $password . "','"
  . $email . "', CURDATE(), 0)";
  
  #echo $query;
  
  $mysqli ->query($query) or die ("could not insert query");
  
  
  echo"<p> SUCESS !!!!</p>";
}
?>

</body>

</html>