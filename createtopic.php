
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


if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


}


$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");
echo '<h3> Topic Creation </h3>';

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{
echo '<form method="post" action="creattopic.php">';

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


echo '	<label id="element">Topic Name:</label> <input type="text" name="topic_subject" >
	<br>
	<br>
 	<label id="element">Topic Post:</label> <textarea name="post" rows="10" cols="50"></textarea>
	<br>
	<br>
	<input type="submit" value="Create Topic" >
 </form>';
}
else
{
 echo"Please sign in to create a topic. ";
}

echo "</div>";
echo '	<div id="aside">';
if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{
	echo "Welcome ". $name;
	echo"<br>";

$query = "SELECT user_level FROM `users` WHERE user_name = '" .$name ."'" ;
	//echo "$query";
	$result1 = $mysqli->query($query); 

	$row2 = $result1->fetch_assoc();
	
	$level = $row2[user_level];	
	
	//echo "level $level  $result1->num_rows";
	$query2 = "SELECT level FROM `admin_level` WHERE id ="  .$level ;
	//echo"$query2";

      $result2 = $mysqli->query($query2);
      $row3 = $result2->fetch_assoc();
      $level = $row3[level];

      
	echo"$level";
     
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
	<input type="hidden" name="topic_id" value="'.$_GET[id] . '" >
	<input type="submit" value="signin">
	</form>
		 ';
	
}

echo"</div>";

include("footer.php");

?>
 


