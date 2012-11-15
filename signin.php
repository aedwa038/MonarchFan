<?php

include("header.php");
require("config.php");

$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

$name = $_POST['username'];
$password = $_POST['password'];

$name = $mysqli->real_escape_string($name);
$password = $mysqli->real_escape_string($password);

$query = "SELECT user_name, user_pass, user_id, user_level, status, state FROM `users` WHERE user_name= '".$name. 
"' AND user_pass='"  . $password . "'" ;
   $result = $mysqli ->query($query) or die ("Could not complete query" );
   
  
   $count = $result->num_rows;
   
   if($count == 1)
   {
	
		
			
		
		
		$row = $result->fetch_assoc();
		
		if($row['state'] == 2)
		{
			echo "User was Deleted from this forum!!!!!";
			exit();
		}
		
			if($row['status'] != verify)
			{
		//session_start();
		//$_SESSION['username'] = $name;
		//$_SESSION['id'] = $row['user_id'] ;
		//$_SESSION['level'] = $row['user_level'];
		//$_SESSION['signed_in'] = "true";
		if( $_POST['remember'] == 'YES' )
		{
			setcookie("username", $name, time() + 31536000);
			setcookie("id", $row['user_id'], time() + 31536000);
			setcookie("level", $row['user_level'], time() + 31536000);
			setcookie("signed_in", "true", time () + 31536000);
			setcookie("state", $row['state'], time () + 31536000);
		}
		else
		{
			setcookie("username", $name);
			setcookie("id", $row['user_id']);
			setcookie("level", $row['user_level']);
			setcookie("signed_in", "true");
			setcookie("state", $row['state'] );
		}
		//echo"Redirecting to front page";
		//echo $_POST['remember'];
		//echo'<a href="index.php">frontpage</a>';
		//echo"Memebership type =" .$_SESSION['level'];
		header("location:index.php");
		}
		
		else
		{
			echo "You are not an user on this site please activate your account!!!";
		}
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