
<?php
session_start();
$name = '';

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


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
			<li><a href="index.php">Home</a></li>
			<?php
			
			if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];
	}

			if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
			   {
			       if($acess == 2)
			         {
			             echo'<li><a href="panel.php"> Admin Page</a></li>';
			         }
			   
			   }
			   
			   ?>
			<li><a href="#">Contact Us</a></li>
		</ul>
	</div>
	<div id="content-container">
		<div id="content">




<?php


if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


}

function mysql_real_unescape_string($input,$checkbr) {

$output = $input;
$output = str_replace("\\\\", "\\", $output);
$output = str_replace("\'", "'", $output);
$output = str_replace('\"', '"', $output);

if ($checkbr==1) {

$output = str_replace('\n\r', '\n', $output);
$output = str_replace('\r\n', '\n', $output);
$output = str_replace('\r', '\n', $output);
$output = str_replace('\n', ' ', $output);

} else if ($checkbr==2) {

$output = str_replace('\n\r', '\n', $output);
$output = str_replace('\r\n', '\n', $output);
$output = str_replace('\r', '\n', $output);
$output = str_replace("\n", "<br>", $output);

}

return $output;

}



require("config.php");
require_once("paginator.class.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or die ("could not connect to database.");

$sql= "SELECT
    topic_id,
    topic_subject
FROM
    topics
WHERE
    topics.topic_id =" .$mysqli->real_escape_string($_GET['id']);

	$result = $mysqli->query($sql) or die("could not retrieve topic");
	
	$row = $result->fetch_assoc();
	echo "<h2>" . $row['topic_subject'] . " Disscussion </h2>" ;
	
	
	
	$query1 = "SELECT
	posts.post_topic,
	posts.post_content,
	posts.post_date,
	posts.post_by,
	users.user_id,
	users.user_name,
	users.user_level
FROM
	posts
LEFT JOIN
	users
ON
	posts.post_by = users.user_id
WHERE
	posts.post_topic = " . $mysqli->real_escape_string($_GET['id']);
	


	$page = $mysqli->query($query1) or die ("Could not complete query");
	
	$pages = new Paginator;
	

	$pages->items_total = $page->num_rows;
	$pages->mid_range = 5;
	$pages->paginate();

	
	$query = "SELECT
	posts.post_topic,
	posts.post_content,
	posts.post_date,
	posts.post_by,
	users.user_id,
	users.user_name,
	users.user_level
FROM
	posts
LEFT JOIN
	users
ON
	posts.post_by = users.user_id
WHERE
	posts.post_topic = " .$_GET['id'] . " $pages->limit" ;
	//echo $query;
	$result2 = $mysqli->query($query) or die ("could not complete query");
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
				echo $pages->display_pages();
				
					if( $acess >= 2)
				{
				    echo '<span style="margin-left:25px"> '. $pages->display_jump_menu()   . $pages->display_items_per_page() . '</span>';  
				}
				//prepare the table
				echo '<table border="1" cellspacing="3px" cellpadding="5px"width="100%" >
					  <tr>
						<th>Author:</th>
						<th>Post</th>
					  </tr>';
				while($row2 = $result2->fetch_assoc())
				{
					echo '<tr>';
						echo '<td class="leftpart" width="15% height="100%" rowspan="2">';
							echo '<strong> <a href="members.php?id='. $row2['user_id'].'">' . $row2['user_name'] .'</a> </strong>';
							echo"<br>";
							echo"<br>";

							echo'<img src="imgs/img02.png" default="avatar pic" width="80" height="70" >';
								  echo"<br>";
								  echo"<br>";

								$query3 = "SELECT level FROM `admin_level` WHERE id ="  .$row2['user_level'] ;

							$result3 = $mysqli->query($query3);
      							$row4 = $result3->fetch_assoc();
								
      							$level = $row4[level];
							echo $level;
						echo '</td>';
						echo '<td class="rightpart" height="10%">';
					
						     
							echo strval($row2['post_date']);
							echo'</td>';
							echo"</tr>";
							echo"<tr>";
							echo '<td class="rightpart">';
							//echo "<hr>";
							echo nl2br(mysql_real_unescape_string($row2['post_content']), 2);
							//echo $row2['post_content'];
						echo '</td>';
					echo '</tr>';
				}
			}
		
		}
		
	echo"</table>";		
	echo $pages->display_pages();


		echo "<br>";
		echo "<hr>";
		if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
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
if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{
	echo "Welcome ". $name;
	echo"<br>";

	echo'<img src="imgs/img02.png" default="avatar pic" width="25%" height="15%" >';
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

      if($level != "user")
      {
	echo"$level";
      }	

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
	<input type="checkbox" name="remember" value="YES"> Remember Me
	<div id="butt"><input type="submit" value="signin" ></div>
	</form>
		 ';
	
}

echo'</div>';	

//include ("footer.php");	
		
		
?>


