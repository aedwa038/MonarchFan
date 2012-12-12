<?php

$name = '';

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];

}

?>


<?php

include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");




if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


}

//create_cat.php
$sql = "SELECT categories.cat_id, categories.cat_name, categories.cat_description FROM `categories`";
//echo "$sql";


$result = $mysqli->query($sql);





echo"<h1> Forums </h1> ";
include ("search.php");
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

		$topics = "SELECT * FROM `topics` WHERE topic_cat =". $row[cat_id];
		$tops = $mysqli->query($topics);
		echo '<td class="centered-cell">'. $tops->num_rows. '</td>';
			echo '</tr>';
		}

		echo"</table>";
	}
}

echo "</div>";
echo '	<div id="aside">';
//echo '<div id="formContainer">';

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

			
	echo "Welcome ";
	echo $name;
	echo"<br>";
	echo '  <a href="uploads/' . $name . '" target="_blank"> 
 	         <object data="uploads/'. $name .'.jpeg" width="100" height="100">
		   <a href="uploads/img02.png" target="_blank">
		 <img src="uploads/img02.png" width="100" height="100" ></object></a>'
	      ;
	
	echo"<br>";
	$query2 = "SELECT level FROM `admin_level` WHERE id ="  .$acess ;
	//echo"$query2";

      $result2 = $mysqli->query($query2);
      $row3 = $result2->fetch_assoc();
      $level = $row3[level];

     
	echo"$level";
	
	$sql = "SELECT count( * ) post_topic FROM posts WHERE post_by = '$id'" ;

	$results = $mysqli->query($sql);
	$count=$results->num_rows;
	//echo $count;
	while($row1 = $results->fetch_assoc())
	{
	$tcount=$row1['post_topic'];
	}
	if($tcount<1)
	{
	 $userrank="No User Rank Yet";
	 }
	if($tcount>0 && $tcount<=5)
	{
	$userrank="you are Newbie";
	}
	if($tcount>5 && $tcount<=16)
	{
	$userrank = "you are a user";
	}
	if($tcount>16 && $tcount<=30)
	{
	$userrank = "you are an intermediate user";

	}
	if($tcount>30)
	{
	$userrank = "you are a Veteran";
	}	
	
	
	echo'<td><a href="members.php?id='. $id  . '" >  User Profile</a><br>';
     
	echo'<form action="logout.php" method="post" >';
	echo'<input type="submit" value="logout">';
	echo '</form>';
	
	echo '<form action="upload.php" method="post">';
		echo '<input type="hidden" name="member_id" value="'.$name . '" >';
		echo '<br>Image Upload : <input type="file" name="image"/>';
		echo'<input type="submit" value="Upload" >';
	echo '</form>';



echo "user rank : "; echo $userrank;
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
		 
		 <a href="forgotlink.html" target="">Forgot password?</a>                     
		          &nbsp &nbsp &nbsp<a href="register.php" target="">Sign up here</a> 
		 ';
	
}


	/*echo '
	<form id="login" method="post" action="./">
		<a href="#" id="flipToRecover" class="flipLink">Forgot?</a>
		<input type="text" name="loginEmail" id="loginEmail" placeholder="Email" />
		<input type="password" name="loginPass" id="loginPass" placeholder="Password" />
		<input type="submit" name="submit" value="Login" />
	</form>
	<form id="recover" method="post" action="./">
		<a href="#" id="flipToLogin" class="flipLink">Forgot?</a>
		<input type="text" name="recoverEmail" id="recoverEmail" placeholder="Your Email" />
		<input type="submit" name="submit" value="Recover" />
	</form>';

}
echo'</div>';*/
echo'<div>';

//include("footer.php");
?>

	