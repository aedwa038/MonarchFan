<?php

session_start();
$name = '';


if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];

		if($acess < 2)
	{

		echo"Your not suppose to be here";
		exit();
	}

}

?>

<?php


if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];

		if($acess < 2)
	{

		echo"Your not suppose to be here";
		exit();
	}

}



include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

echo"<h3> Administration Panel</h3>";

$query = ' SELECT * FROM `users` WHERE 1';

$result = $mysqli->query($query);


	echo '<table width="80%" >

			  <tr>
				<th>Members</th>
				<th width = "20%"></th>
				<th></th>
				<th></th>
			    <th width="50%">USER RANK</th>
			  </tr>';
			  while($row = $result -> fetch_assoc())
			  {
			  
			  if($row['state'] == 2 )
			  {
			  
			  }
			  
			  else
			{
			  	echo"<tr>";
				echo'<td>';
				echo $row[user_name];
				echo'</td>';
				echo'<td><a href="members.php?id=' . strval($row[user_id]) .'">EDIT</a></td>';
			
			echo '<td align="center">';
				echo '<form action="suspend.php" method="post">';
				echo '<input type="hidden" name="user_id" value="'.$row[user_id] . '" >';
				if($row['state'] == 1 )
				{
					echo '<input type="submit" value="Unsuspend" >';
				}
				else
				{	
					echo '<input type="submit" value="Suspend" >';
				}				
				echo'</form>';
			
			echo"</td>";
			
			
			
			echo '<td align="center">';
				echo '<form action="deleteuser.php" method="post">';
				echo '<input type="hidden" name="user_id" value="'.$row[user_id] . '" >';
					echo '<input type="submit" value="Delete" >';		
				echo'</form>';
			
			echo"</td>";
			//User rank display
			$sql = "SELECT count( * ) post_topic FROM posts WHERE post_by = ". $row[user_id] ;

         	$results = $mysqli->query($sql);
	        $count=$results->num_rows;
	//echo $count;
	while($row1 = $results->fetch_assoc())
	{
	
	$tcount=$row1['post_topic'];
	//echo $tcount;
	
	if($tcount>0 && $tcount<=5)
	{
	$userrank = "Newbie";
	}
	if($tcount>5 && $tcount<=16)
	{
	$userrank = "user";
	}
	if($tcount>16 && $tcount<=30)
	{
	$userrank = "Intermediate user";

	}
	if($tcount>30)
	{
	$userrank = " Veteran";
	}
}	
			echo '<td align="center">';
			echo $userrank;
			        
				echo"</tr>";
			}
			  }




?>

</div>
</div>
</html>