<?php


if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];
	
	if($acess < 0)
	{

		echo"Your not suppose to be here";
		exit();
	}	
}

require("config.php");
include("header.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//the form hasn't been posted yet, display it
	//echo " No Category submited";
	
	



	$sql = "SELECT *
FROM `posts`
WHERE post_id =". $_GET['id'];


$result = $mysqli->query($sql);
$row = $result->fetch_assoc();


if( $row['frozen'] == 1)
{
	echo "You cannot edit a deleted post";
	echo '<a href="topic.php?id='.$row['post_topic'] .'"> Back to forums</a>';
	exit();
}
echo'<form method="post" action="editpost.php">';

echo' <label id="element">  Loggin in user: </label> ';
echo "<p> $name </p>";
echo'<br>';

echo '<label id="element">Post:</label> <textarea name="post_content" rows="10" cols="50">'.$row[post_content] . '</textarea>';
echo"<br><br>";
echo '<input type="hidden" name="post_id" value="'.$_GET[id] . '" >';
echo '<input type="submit" value="Edit" >';

echo'</form>';

	
}


else
{

if($_POST['post_content'] == '')
{

echo "Incorrect Data sent";
     exit();
}


//UPDATE `aedwards`.`posts` SET `post_content` = 'Any body got the recent odu game scores ??' WHERE `posts`.`post_id` =1;

//UPDATE `aedwards`.`posts` SET `Edit_date` = '2012-11-13',`Edit_id` = '1' WHERE `posts`.`post_id` =1;




$update = $_POST['post_content'];



//$sql ="UPDATE `aedwards`.`posts` SET `post_content` = '". $update ."' WHERE `posts`.`post_id` = ". $_POST[post_id];
$sql = "UPDATE `aedwards`.`posts` SET `post_content` = '".$update  ."',`Edit_date` = 'NOW()',`Edit_id` = '".$id."' WHERE `posts`.`post_id` =". $_POST[post_id];


//echo $sql;

$mysqli->query($sql) or die ("could not complete query");

$sql2 = "SELECT *
FROM `posts`
WHERE post_id =". $_POST['post_id'];

$result = $mysqli->query($sql2);
$row = $result->fetch_assoc();

echo '<a href="topic.php?id='.$row['post_topic'] .'">Successfully Edited Post </a>';

}

?>