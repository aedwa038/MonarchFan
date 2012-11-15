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
if($row['state'] == 0 )
{
	//UPDATE `aedwards`.`users` SET `status` = 'frozen' WHERE `users`.`user_id` =1;
	$sql2 = "UPDATE `aedwards`.`users` SET `state` = '1' WHERE `users`.`user_id` = " . $_POST[user_id];
	$mysqli ->query($sql2) or die("could not complete query");
	echo '<a href="memberlist.php">Successfully banned user </a>';
	exit();
}

else
{
	
	$sql2= "UPDATE `aedwards`.`users` SET `state` = '0' WHERE `users`.`user_id` = " . $_POST[user_id];
	$mysqli->query($sql2) or die ("could not complete query");
	echo '<a href="memberlist.php?id">Successfully unbanned user </a>';
	exit();
}


?>