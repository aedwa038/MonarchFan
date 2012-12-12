<?php

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];

		if($acess < 1)
	{

		echo"Your not suppose to be here";
		exit();
	}

}



include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");




$sql = "SELECT * FROM `users` WHERE user_id=" . $_POST[user_id];

$result = $mysqli->query($sql);

$row = $result->fetch_assoc();

//print_r($row);
if($row['state'] == 0 )
{
	//UPDATE `aedwards`.`users` SET `status` = 'frozen' WHERE `users`.`user_id` =1;
	$sql2 = "UPDATE `aedwards`.`users` SET `state` = '1' WHERE `users`.`user_id` = " . $_POST[user_id];
	$mysqli->query($sql2) or die ("could not complete query");
	
	
	if ($acess == 2)
	{
	     $sql3 = "SELECT user_email FROM users WHERE `users`.`user_id` = " . $_POST[user_id];
	     $result = $mysqli ->query($sql3);
	     $row1 = $result->fetch_assoc();
	      $to      = $row1['user_email'];
		  $subject = "Mail of Suspension";  
          $message = "Your account has been Suspended\r\rPlease contact our customer Service for more details!!! .";
          $header = 'From: Monarch Forums' . "\r\n" .

          'Reply-To: noreply@ YOURWEBSITE.com' . "\r\n" .

            'X-Mailer: PHP/' . phpversion();    
            		
     
           mail($to, $subject, $message, $header);
            echo '<a href="memberlist.php">Successfully banned user </a>';
	}
	else
	{
		echo '<a href="index.php">Successfully banned user </a>';
		
	}
	exit();
}

else
{
	
	$sql2= "UPDATE `aedwards`.`users` SET `state` = '0' WHERE `users`.`user_id` = " . $_POST[user_id];
	$mysqli->query($sql2) or die ("could not complete query");
	if($acess == 2)
	{
		 $sql3 = "SELECT user_email FROM users WHERE `users`.`user_id` = " . $_POST[user_id];
	     $result = $mysqli ->query($sql3);
	     $row1 = $result->fetch_assoc();
	      $to      = $row1['user_email'];
		  $subject = "Mail of Unsuspension";  
          $message = "Your suspension has been lifted\r\rplease try using our features again!! .";
          $header = 'From: Monarch Forums' . "\r\n" .

          'Reply-To: noreply@ YOURWEBSITE.com' . "\r\n" .

            'X-Mailer: PHP/' . phpversion();    
            		
     
           mail($to, $subject, $message, $header);
            echo '<a href="memberlist.php">Successfully unbanned user </a>';
	}
	else
	 {
	 echo '<a href="index.php">Successfully unbanned user </a>';
	 }
	exit();
}


?>