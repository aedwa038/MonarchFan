<?php

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


}


include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");
$sql = "DELETE FROM `categories` WHERE categories.cat_id=" .$_GET['id'];
echo '<a href="panel.php">Successfully Deleted Forum </a>';
$result = $mysqli->query($sql);
$row = $result -> fetch_assoc(); 
?>
