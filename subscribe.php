<?php
	
	
	
	if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$user_id_by = $_GET['id_by'] ;
	$user_id_to = $_GET['id_to'];
	$acess = $_COOKIE['level'];

		
include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

	
	
	
	if($_POST['flag']=="subscribe") // 1 = insert and 0 = delete
	{echo $_POST['flag'];
	    
		$sql = "insert into subscribe(sub_by,sub_to) values($user_id_by,$user_id_to)";
		$result = $mysqli->query($sql);
	}
	else
	{
		echo $_POST['flag'];
		$sql = "delete from subscribe where sub_by = $user_id_by and sub_to = $user_id_to";
		$result = $mysqli->query($sql);
	}
}

	else
	{
	
	
	   echo 'You are not suppose to be here<br>
	         Please login with your credentials</br>';
			 
     }
	 
	header ("Location: members.php?id=$user_id_to")
	
	
	
	
	?>
