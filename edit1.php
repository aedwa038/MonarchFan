<?php

$name = '';

?>

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

if($_POST['cat_name'] == '' || $_POST[cat_description] == '' || $_POST['cat_id'] == '')
{
	echo"Incorrect Data sent ";
	exit();

}


$sql = "UPDATE `aedwards`.`categories` SET `cat_name` = '". $_POST['cat_name']   ."',
`cat_description` = '".$_POST[cat_description]  ."' WHERE `categories`.`cat_id` =" . $_POST['cat_id'];



//echo $sql;

echo"<br>";

$mysqli->query($sql) or die ("could not complete query");

echo '<a href="panel.php">Successfully Edited Forum </a>';
}
?>