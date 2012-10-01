<?php

session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title> Monarch Forums</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
  <link rel="stylesheet" type="text/css" href="style.css" >

</head>

<body>
<div id="container">
	<div id="header">
		<h1>Monarch Forums</h1>
	</div>
	<div id="navigation">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Contact Us</a></li>
		</ul>
	</div>
	<div id="content-container">
		<div id="content">

<?php

require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

//create_cat.php
$sql = "SELECT categories.cat_id, categories.cat_name, categories.cat_description FROM `categories`";
$result = $mysqli->query($sql);
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
?>

		<div id="footer">
			<p>Copyright © MonarchFan, 2012</p>
		</div>
	</div>
</div>
</body>

</html>
