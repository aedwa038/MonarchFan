<?php
session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	$name = $_SESSION['username'];
}

?>




<?php

include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

$sql = "SELECT
			cat_id,
			cat_name,
			cat_description
		FROM
			categories
		WHERE
			cat_id =" . $_GET['id'];
			
			
	$result = $mysqli->query($sql);
	
	if(!$result)
{
	echo 'The category could not be displayed, please try again later.' . mysql_error();
}
else
{

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	echo'<a href="createtopic.php">  Create a topic </a>';
}
	if($result->num_rows == 0)
	{
		echo 'This category does not exist.';
	}
	
	else
	{
		//display category data
		while($row = $result->fetch_assoc())
		{
			echo "<h2>Topics in " . $row['cat_name'] . " category</h2>";
		}
		//do a query for the topics
		$query = "SELECT
					topic_id,
					topic_subject,
					topic_date,
					topic_cat
				FROM
					topics
				WHERE
					topic_cat = " .$_GET['id'];
		$result2 = $mysqli->query($query);
		if(!$result2)
		{
			
			echo 'The topics could not be displayed, please try again later.';
			echo "<br>";
			print_r($result2);
		}
		else
		{
			if($result2->num_rows == 0)
			{
				echo 'There are no topics in this category yet.';
			}
			else
			{
				//prepare the table
				echo '<table width="100%">
					  <tr>
						<th>Topic</th>
						<th>Created at</th>
					  </tr>';
				while($row2 = $result2->fetch_assoc())
				{
					echo '<tr>';
						echo '<td class="leftpart" width="80%" >';
							echo '<strong><a href="topic.php?id=' . $row2['topic_id'] . '">' . $row2['topic_subject'] . '</a></strong>';
						echo '</td>';
						echo '<td class="rightpart" width="20%">';
							echo date('d-m-Y', strtotime($row2['topic_date']));
						echo '</td>';
					echo '</tr>';
				}
			}
		}

	}
}
echo "</table>";
echo "</div>";
echo '	<div id="aside">';
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	echo "Welcome ". $name;
	echo"<br>";

	echo'<form action="logout.php" method="post" >';
	echo'<input type="submit" value="logout">';
	echo '</form>';
}
else
{

echo '  	
			<h3>Please sign in</h3>

<form action="signin.php" method="post">
	<label class="element">Username:</label><br>
	<input type="text" name="username">
	<br>
	<label class="element">Password:</label><br>
	<input type="password" name="password">
	<br>
	<input type="submit" value="signin">
	</form>
		 ';
	
}
echo"</div>";

include ("footer.php");
?>

