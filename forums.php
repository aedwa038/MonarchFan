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

echo"<h3> Forum List</h3>";
$sql = "SELECT categories.cat_id, categories.cat_name FROM `categories`";
//echo "$sql";
$result = $mysqli->query($sql);

echo"<h1> Forums </h1> ";
if(!$result)
{
	echo 'The categories could not be displayed, please try again later.';
}
else
{
	if($result->num_rows == 0)
	{
		echo 'No categories defined yet.';
		print_r($result);
	}
	else{
	echo '<table width="50%" >
			  <tr>
				<th>Category</th>
				<th></th>
			
			  </tr>';

	while($row = $result -> fetch_assoc())
	{
	echo"<tr>";
	echo'<td>';
	echo $row[cat_name];
	echo'</td>';
	echo'<td><a href="edit.php?id='. strval($row[cat_id]).'">EDIT </a></td>';
	echo"</tr>";
	}
}

}



include("footer.php");

?>