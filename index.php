<?php

session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
}

?>


<?php
include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

//create_cat.php
$sql = "SELECT categories.cat_id, categories.cat_name, categories.cat_description FROM `categories`";
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
	else
	{
		//prepare the table
		echo '<table width="100%" >
			  <tr>
				<th></th>
				<th>Category</th>
				<th>Topics</th>
			
			  </tr>';
		while($row = $result->fetch_assoc())
		{
			echo '<tr>';
			     
			     echo'<td><img src="imgs/web_layout_32.png" alt="icon" ></td>';
				echo '<td class="leftpart">';
				echo '<strong><a href="category.php?id='. strval($row[cat_id]) . '">' . $row['cat_name'] . '</a></strong><br> ';
		echo ''. $row['cat_description'];
		echo '</td>';
		echo '<td></td>';
			echo '</tr>';
		}

		echo"</table>";
	}
}


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

echo'</div>';

include("footer.php");
?>

	