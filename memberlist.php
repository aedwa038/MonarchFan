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

$query = ' SELECT * FROM `users` WHERE 1';

$result = $mysqli->query($query);


	echo '<table width="50%" >
			  <tr>
				<th>Members</th>
				<th></th>
			
			  </tr>';
			  while($row = $result -> fetch_assoc())
			  {
			  	echo"<tr>";
				echo'<td>';
				echo $row[user_name];
				echo'</td>';
				echo'<td><a href="members.php?id=' . strval($row[user_id]) .'">EDIT</a></td>';
				echo"</tr>";
			  }




?>

</div>
</div>
</html>