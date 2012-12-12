<?php
include ("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");


if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//the form hasn't been posted yet, display it
	echo " No search submited";
	exit();
}

if ($_POST['search'] == '' || $_POST['option'] == '')
{
	echo "No search data submited";
		exit();
}



//echo $_POST['search'];
//echo $_POST['cat'];
//echo $_POST['option'];


$search = $mysqli->real_escape_string($_POST['search']);
//$cat = $_POST['cat'];
$option = $_POST['option'];


echo "<h3> Search Results </h3>";

if($option == 'post')
{
	$sql = "SELECT posts.post_content, posts.post_date, users.user_name, topics.topic_subject, topics.topic_id, users.user_id
FROM posts
LEFT JOIN users ON users.user_id = posts.post_by
LEFT JOIN topics ON posts.post_topic = topics.topic_id
WHERE MATCH (
post_content
)
AGAINST (
+ '$search'
IN BOOLEAN
MODE
)
LIMIT 0 , 30";

//echo "here";


$results = $mysqli->query($sql) or die ("could not complete query");


//echo "here";


if ($results->num_rows == 0)
{
	echo 'no results found';

}

else
{
echo '<table width="100%">
					  <tr>
						<th>Author</th>
						<th>Post </th>
						<th> Thread</th>
						<th> Date</th>';
						
						while($row2 = $results->fetch_assoc())
				{
					echo '<tr>';
					//echo'<td><a href="members.php?id='. $row7['user_id']  . '" >' .$last_user .'</a><br>'. $last_date . '</td>';
					echo '<td><a href="members.php?id='. $row2['user_id']  . '" >';
							echo $row2['user_name'];
					echo'</a></td>';
					
					echo '<td>';
							echo $row2['post_content'];
					echo'</td>';
					
					echo '<td><strong><a href="topic.php?id=' . $row2['topic_id'] . '">';
							echo $row2['topic_subject'];
					echo'</a></strong></td>';
					
					echo '<td>';
							echo $row2['post_date'];
					echo'</td>';
					echo '</tr>';
				}
						
echo "</table>";
}

}

else if($option == 'user')
{
	$sql = " SELECT posts.post_content, posts.post_date, users.user_name, topics.topic_subject, topics.topic_id, users.user_id
FROM posts
LEFT JOIN users ON users.user_id = posts.post_by
LEFT JOIN topics ON posts.post_topic = topics.topic_id
WHERE MATCH (
post_content
)
AGAINST (
+'$search'
IN BOOLEAN
MODE
)
AND users.user_id = " . $_POST['user_id'];

//echo "here";


$results = $mysqli->query($sql) or die ("could not complete query  $sql");

//echo $sql;
//echo "here";


if ($results->num_rows == 0)
{
	echo 'no results found';

}

else
{
echo '<table width="100%">
					  <tr>
						<th>Author</th>
						<th>Post </th>
						<th> Thread</th>
						<th> Date</th>';
						
						while($row2 = $results->fetch_assoc())
				{
					echo '<tr>';
					//echo'<td><a href="members.php?id='. $row7['user_id']  . '" >' .$last_user .'</a><br>'. $last_date . '</td>';
					echo '<td><a href="members.php?id='. $row2['user_id']  . '" >';
							echo $row2['user_name'];
					echo'</a></td>';
					
					echo '<td>';
							echo $row2['post_content'];
					echo'</td>';
					
					echo '<td><strong><a href="topic.php?id=' . $row2['topic_id'] . '">';
							echo $row2['topic_subject'];
					echo'</a></strong></td>';
					
					echo '<td>';
							echo $row2['post_date'];
					echo'</td>';
					echo '</tr>';
				}
						
echo "</table>";
}

}
else
{
	$sql = "SELECT topics.topic_subject, topics.topic_date, topics.topic_by, topics.topic_id, users.user_name, users.user_id
FROM `topics`
LEFT JOIN users ON users.user_id = topics.topic_by
WHERE MATCH (
topic_subject
)
AGAINST (
+ '$search'
IN BOOLEAN
MODE
)";


$results = $mysqli->query($sql) or die ("could not complete query " . $sql );


//echo "here";


if ($results->num_rows == 0)
{
	echo 'no results found';

}

else
{
echo '<table width="100%">
					  <tr>
						<th>Author </th>
						<th> Thread</th>
						<th> Date</th>';
						
						while($row2 = $results->fetch_assoc())
				{
					echo '<tr>';
					
					echo '<td><a href="members.php?id='. $row2['user_id']  . '" >';
							echo $row2['user_name'];
					echo'</a></td>';
					
					echo '<td><strong><a href="topic.php?id=' . $row2['topic_id'] . '">';
							echo $row2['topic_subject'];
					echo'</a></strong></td>';
					
					echo '<td>';
							echo $row2['topic_date'];
					echo'</td>';
					
					echo '</tr>';
				}
						
echo "</table>";
}

}




//echo $search;

//$sql = "SELECT * FROM posts WHERE MATCH ($search) AGAINST ('$search');"


//echo $sql;


 //$results = $mysqli->querry($sql);
 
 
 
 
 

?>