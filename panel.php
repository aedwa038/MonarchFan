
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

include("header.php");
require("config.php");
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
	echo'<a href="forums.php">Veiw Forums </a>';
echo'</td>';

echo'<td>';

	echo'<a href="memberlist.php">Members List</a>';
	
echo'</td>';

echo '</table>';

include("footer.php");
?>
