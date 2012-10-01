<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >

<title> Topic Creation</title>
<style type="text/css">

		
       #element
       {
       	width:150px;
       	padding:4px;
       	float:left;
       }
       
       #options
       {
       		width: 30px;
       }
       
       

</style>


</head>
<body>

<h3> Topic Creation </h3>

<form method="post" action="creattopic.php">

<?php

require("config.php");



$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

echo '<label id="element"> Category: </label> ';
$sql = "SELECT
					cat_id,
					cat_name,
					cat_description
				FROM
					categories";
		$result = $mysqli->query($sql);
		echo '<select name="topic_cat">';
					while($row = $result->fetch_assoc())
					{
						echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
					}
				echo '</select>';
				
				echo"<br>";
				echo"<br>";

?>
 	<label id="element">Topic Name:</label> <input type="text" name="topic_subject" >
	<br>
	<br>
 	<label id="element">Topic Post:</label> <textarea name="post" rows="10" cols="50"></textarea>
	<br>
	<br>
	<input type="submit" value="Create Topic" >
 </form>

</body>

</html>