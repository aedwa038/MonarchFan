
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

<style type="text/css">

		
       #elements
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

$sql= "SELECT
    topic_id,
    topic_subject
FROM
    topics
WHERE
    topics.topic_id =" .$mysqli->real_escape_string($_GET['id']);

	$result = $mysqli->query($sql) or die("could not retrieve topic");
	
	$row = $result->fetch_assoc();
	echo "<h2>" . $row['topic_subject'] . "Disscussion </h2>" ;
	
	$query = "SELECT
	posts.post_topic,
	posts.post_content,
	posts.post_date,
	posts.post_by,
	users.user_id,
	users.user_name
FROM
	posts
LEFT JOIN
	users
ON
	posts.post_by = users.user_id
WHERE
	posts.post_topic = " . $mysqli->real_escape_string($_GET['id']);
	
	$result2 = $mysqli->query($query);
	if(!$result2)
		{
			
			echo 'The posts could not be displayed, please try again later.';
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
				echo '<table border="1" cellspacing="3px" cellpadding="5px"width="100%" >
					  <tr>
						<th>Author:</th>
						<th>Post</th>
					  </tr>';
				while($row2 = $result2->fetch_assoc())
				{
					echo '<tr>';
						echo '<td class="leftpart">';
							echo $row2['user_name'] ;
						echo '</td>';
						echo '<td class="rightpart">';
							echo nl2br($row2['post_content']);
						echo '</td>';
					echo '</tr>';
				}
			}
		
		}
		
	echo"</table>";		


		echo "<br>";
		echo "<hr>";
		if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	echo "<h4>Quick Reply</h4>";
	
	echo '<form method="post" action="reply.php">';
	echo '<input type="hidden" name="topic_id" value="'.$_GET[id] . '" >';
	echo'<label id="elements">Reply:</label> <textarea name="reply" rows="10" cols="50"></textarea>';
	echo '<input type="submit" value="Reply" >';
	echo'</form>';
		
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