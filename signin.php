<?php

include("header.php");
require("config.php");

$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

$name = $_POST['username'];
$password = $_POST['password'];

$name = $mysqli->real_escape_string($name);
$password = $mysqli->real_escape_string($password);

$query = "SELECT user_name, user_pass, user_id, user_level FROM `users` WHERE user_name= '".$name. 
"' AND user_pass='"  . $password . "'" ;
   $result = $mysqli ->query($query) or die ("Could not complete query" );
   
   $count = $result->num_rows;
   
   if($count == 1)
   {
   
		echo"welcome " . $name;
		echo"<br>";
		
		$row = $result->fetch_assoc();
		session_start();
		$_SESSION['username'] = $name;
		$_SESSION['id'] = $row['user_id'] ;
		$_SESSION['level'] = $row['user_level'];
		$_SESSION['signed_in'] = "true";
		
		//echo"Redirecting to front page";
		//echo'<a href="index.php">frontpage</a>';
		//echo"Memebership type =" .$_SESSION['level'];
		header("location:index.php");
		
		//print_r($row);
		
		//print_r($result);
   }
   else 
   {
	echo"Wrong Username or Password";
	echo"<br>";
	//print_r($result);
   }
   
   
  include("footer.php");


?>