
<?php


if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


}


include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

echo"<h3> Member Profile</h3>";




$query = ' SELECT * FROM `users` WHERE user_id ='.$_GET['id'];


$result = $mysqli->query($query);


$row = $result -> fetch_assoc();


	echo '<table width="50%" >
			  <tr>
				<th>Member profile</th>
				<th></th>
			
			  </tr>';

			 echo"<tr>";
				    echo"<td>";
					echo"Username:";
				    echo"</td>";
				    echo"<td>";
					echo $row[user_name];
				    echo"</td>";				
			 echo"</tr>";

			 echo"<tr>";
				echo"<td>Registered:</td>";
				echo"<td>". $row[user_date] . "</td>";
			 echo"</tr>";

			 echo"<tr>";
				echo"<td>Posts:</td>";
				$posts = "SELECT * FROM `posts` WHERE post_by =" .$_GET['id'];
				$post_data = $mysqli->query($posts);
				echo"<td>".$post_data->num_rows ."</td>";

			 echo"</tr>";
			 $level = "SELECT * FROM `admin_level` WHERE id =" . $row[user_level];	
			 //echo $row[user_level];
			 $result1 = $mysqli->query($level);
			 $user_level = $result1->fetch_assoc();
			 echo"<tr>";
			 echo"<td>Member Status:</td>";
			 if($acess < 2)
			 {
			 echo"<td>" .$user_level['level'] ."</td>";
			 }
			 elseif($acess >= 2)
			 {			 
			 echo"<td>";
			 echo '<form method="post" action="level.php">';
$sql3 = "SELECT *
FROM `admin_level` Where 1";
		$result = $mysqli->query($sql3);
		echo '<select name="level">';
					while($row = $result->fetch_assoc())
					{
						if($user_level['level'] == $row['level'] )
						{
						$default = 'selected="selected"';
						}
						else
						{
						  $default= "";
						}
						
						if(( $row[level] != Root))
						{
							echo '<option value="' . $row['id'] . '"'. $default . ' >' . $row['level'] . '</option>';
						}
						
					}
				echo '</select>';
				echo '<input type="hidden" name="member_id" value="'.$_GET[id] . '" >';
				echo'<input type="submit" value="Edit">';
				
			 echo"</td>";
			 }
			 
			 echo"</tr>";

			 echo"<tr>";
				echo"<td> Last active </td>";
				$last = 'SELECT * FROM `posts` WHERE post_by =' .$_GET['id']. ' ORDER BY post_date DESC';
	
				$r = $mysqli->query($last);
				//echo $r->num_rows;
				//echo"$last";
				$last_active = $r->fetch_assoc();
				//echo"test";
				echo"<td>".$last_active['post_date'] ."</td>";
				
			 echo"</tr>";
			 if($row['state'] == 1)
				{	
					
					echo "<tr><td> Status:</td>";
					echo "<td>BANNED</td></tr>";
				}
echo "</table>";
if($acess >=1)
{

if($row['user_level']  == 0)
{
echo '<form action="suspend.php" method="post">';
				echo '<input type="hidden" name="user_id" value= "'.$_GET['id'] . '" >';
				if($row['state'] == 1 )
				{
					echo '<input type="submit" value="Unsuspend" >';
				}
				else
				{	
					echo '<input type="submit" value="Suspend" >';
				}				
				echo'</form>';
}

}
include("footer.php");
?>