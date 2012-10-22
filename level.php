<?php
session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
	$acess = $_SESSION['level'];
}
?>
<?php
//create_cat.php


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

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//the form hasn't been posted yet, display it
	echo " No Update submited";
}

$member_id = $_POST['member_id'];

$new_level = $_POST['level'];

//echo $member_id;
//echo $new_level;
//echo"done";


$sql = "UPDATE `aedwards`.`users` SET `user_level` = ". $new_level . " WHERE `users`.`user_id` =" . $member_id;


$mysqli->query($sql);

echo '<a href="members.php?id=' .$member_id.'">Successfully changed role </a>';
//header("location:members.php?id=". $member_id );

?>

</div>
</div>
</body>
</html>