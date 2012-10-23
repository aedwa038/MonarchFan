
<?php

session_start();
$name = '';
include("header.php");
require("config.php");

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











$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

echo"<h3> Administration Panel</h3>";

echo '<table width="100%">
     <tr>
	<th>Forums</th>
	<th>Members</th>
     </tr>';
echo'<td>';
	echo'<a href="creatcat.php"> Add Forum</a> <br>';
	echo'<a href="forums.php">View Forums </a> <br>';
	echo'<a href="delete.php">Delete Forums </a>';
echo'</td>';

echo'<td>';

	echo'<a href="memberlist.php">Members List</a>';
	
echo'</td>';

echo '</table>';

}
else
echo "Your not suppose to be here";

include("footer.php");
?>

