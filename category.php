<?php
session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
	$acess = $_SESSION['level'];
}

?>
<?php

include("header.php");
require("config.php");
require_once("paginator.class.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");
$sql = "SELECT
			cat_id,
			cat_name,
			cat_description,
			paginate
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
	echo'<p><a href="createtopic.php">  Create a topic </a> </p>';
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
			echo "<h2>" . $row['cat_name'] . " category</h2>";
		}
		//do a query for the topics
		$query1 = "  SELECT
					topic_id,
					topic_subject,
					topic_date,
					topic_cat
				FROM
					topics
				WHERE
					topic_cat =  " .$_GET['id'] . " Order by topic_date DESC ";
		$page = $mysqli->query($query1);
		$pages = new Paginator;
	$pages->items_total = $page->num_rows;
	$pages->mid_range = 5;
	$pages->paginate();
	//echo $page->num_rows;
	//echo $pages->limit;
	
	//echo $pages->display_pages();
	
	
	$query = "  SELECT
					topic_id,
					topic_subject,
					topic_date,
					topic_cat
				FROM
					topics
				WHERE
					topic_cat =  " .$_GET['id'] . " Order by topic_date DESC " . $pages->limit;
					
					$result2 = $mysqli->query($query);
	
				
				echo $pages->display_pages();
				
				if( $acess >= 2)
				{
				    echo '<span style="margin-left:25px"> '. $pages->display_jump_menu()   . $pages->display_items_per_page() . '</span>';  
				}
				//echo "Page $pages->current_page of $pages->num_pages"; 
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
						<th></th>
						<th>Topic</th>
						<th>Author </th>
						<th> Replies</th>
						<th> Last Post:</th>
						<th>Created Date</th>
					  </tr>';
				while($row2 = $result2->fetch_assoc())
				{
					echo '<tr>';
					echo'<td><img src="imgs/web_layout_32.png" alt="icon" ></td>';
						echo '<td class="leftpart" width="40%" >';
							echo '<strong><a href="topic.php?id=' . $row2['topic_id'] . '">' . $row2['topic_subject'] . '</a></strong>';
						echo '</td>';
						//$posts = "Select post_by FROM `posts` Where post_topic ='". $row2[$topic_id] . "' Order by post_date";

						$posts = "SELECT post_by
						FROM `posts`
						WHERE post_topic =" . strval( $row2[topic_id]) ." Order by post_date" ;
						

						
						$result3 = $mysqli->query($posts);
						$row4 = $result3->fetch_assoc();
						$post_by = $row4[post_by];
						
						$names = "SELECT user_name, user_id
						FROM `users`
						WHERE user_id = ".$post_by  ;
						//echo"$names";
					

						$result4 = $mysqli->query($names);
						$row5 = $result4->fetch_assoc();
					
						$user_id = $row5['user_name'];
						echo'<td><a href=members.php?id="'.$row5['user_id'] .'">'. $user_id .'<a></td>';
						

						$rep = "SELECT post_by
						FROM `posts`
						WHERE post_topic =" . strval( $row2[topic_id]) ." Order by post_date" ;
						//echo $rep;
						$result5 = $mysqli->query($rep);
							
						
						$replies = $result5->num_rows - 1;

						echo"<td class='centered-cell' > $replies</td>";
						
						$last = "SELECT post_by, post_date
						FROM `posts`
						WHERE post_topic =" . strval( $row2[topic_id]) ." Order by post_date DESC" ;
						$result6 = $mysqli->query($last); 
						
						$row6 = $result6->fetch_assoc();
						$last_post = $row6['post_by'];
						//echo"$last_post";

						$names2 = "SELECT user_name, user_id
						FROM `users`
						WHERE user_id = ".$last_post  ;
						//echo $names2;
						$result6 = $mysqli->query($names2);
						$row7 = $result6->fetch_assoc();
					
						$last_date = $row6['post_date'];
						$last_user = $row7['user_name'];
						echo'<td><a href=members.php?id="'. $row7['user_id']  . '" >' .$last_user .'</a><br>'. $last_date . '</td>';
						
						echo '<td class="rightpart" width="10%">';
							echo date('d-m-Y', strtotime($row2['topic_date']));
						echo '</td>';
					echo '</tr>';
				}
			}
		}

	}
}
echo "</table>";
echo"<br>";
echo $pages->display_pages();
echo"<br>";
echo "Page $pages->current_page of $pages->num_pages"; 
echo "</div>";
echo '	<div id="aside">';
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
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
	<input type="submit" value="signin">
	</form>
		 ';
	
}
echo"</div>";

include ("footer.php");
?>

