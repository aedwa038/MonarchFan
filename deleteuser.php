<?php

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];

		if($acess < 2)
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

	//UPDATE `aedwards`.`users` SET `status` = 'frozen' WHERE `users`.`user_id` =1;
	$sql2 = "UPDATE `aedwards`.`users` SET `state` = '2' WHERE `users`.`user_id` = " . $_POST[user_id];
	$mysqli ->query($sql2) or die("could not complete query");
	 $sql3 = "SELECT user_email FROM users WHERE `users`.`user_id` = " . $_POST[user_id];
	     $result = $mysqli ->query($sql3);
	     $row1 = $result->fetch_assoc();
	      $to      = $row1['user_email'];
		  $subject = "Mail of Deletion";  
          $message = "Your Account has been deleted\r\rMainly because of two reasons\r\r1.Usage of abusive language in the posts\r2.Ignoring the warnings\r\rYou cannot use our features  .";
          $header = 'From: Monarch Forums' . "\r\n" .

          'Reply-To: noreply@ YOURWEBSITE.com' . "\r\n" .

            'X-Mailer: PHP/' . phpversion();    
            		
     
           mail($to, $subject, $message, $header);
            
	        echo '<a href="memberlist.php">Successfully Deleted user </a>';
	exit();


?>