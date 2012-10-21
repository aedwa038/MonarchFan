<?php
//create_cat.php
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//the form hasn't been posted yet, display it
	echo " No Category submited";
}
else
{

if($_POST['cat_name'] == '' || $_POST[catdescription] == '')
{
	echo"Incorrect Data sent ";
	exit();

}	
	
		
	//the form has been posted, so save it
	//$sql = "INSERT INTO categories(cat_name, cat_description)
 	  // VALUES('' . mysql_real_escape_string($_POST['cat_name']),
 	//		 '' . mysql_real_escape_string($_POST['cat_description']))";
			 
	$sql = "INSERT INTO categories (cat_name, cat_description) VALUES ('" . $_POST['cat_name'] 
	. "','" .$_POST['cat_description'] ."')";
	
	$result = $mysqli->query($sql);
	if(!$result)
	{
		//something went wrong, display the error
		echo 'Error' . mysql_error();
	}
	else
	{
		echo 'New category successfully added.';
	}	echo $sql;
		echo "<br>";	
}
?>