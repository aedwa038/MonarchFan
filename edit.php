<?php

session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{

	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
	$acess = $_SESSION['level'];
	
	if($acess < 2)
	{

		echo"Your not suppose to be here";
		exit();
	}
}

?>

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



$sql = "SELECT * FROM `categories` Where categories.cat_id=" .$_GET['id'];
//echo "$sql";
$result = $mysqli->query($sql);

$row = $result -> fetch_assoc();

echo'<form method="post" action="edit1.php">';
echo '	<label id="element">Category name:</label> <input type="text" name="cat_name" value="'.$row[cat_name] .'" >';
echo "<br> <br>";
echo '<label id="element">Category description:</label> <textarea name="cat_description" rows="10" cols="50">'.$row[cat_description] . '</textarea>';
echo"<br><br>";
echo '<input type="hidden" name="cat_id" value="'.$_GET[id] . '" >';
echo '<input type="submit" value="Edit category" >';
echo'</form>';




?>