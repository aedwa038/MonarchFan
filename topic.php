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
	$state = $_COOKIE['state'];


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
	frozen,
    topic_subject
FROM
    topics
WHERE
    topics.topic_id =" .$mysqli->real_escape_string($_GET['id']);

	$result = $mysqli->query($sql) or die("could not retrieve topic");
	
	$row = $result->fetch_assoc();
	echo "<h2>" . $row['topic_subject'] . " Disscussion </h2>" ;
	if($row['frozen'] != 0)
	{
		echo '<td><img src="imgs/lock.png" alt="icon" ></td>';
	}
	
	
	$query1 = "SELECT
	posts.post_topic,
	posts.post_content,
	posts.post_date,
	posts.post_by,
	posts.frozen,
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
	posts.post_id,
	posts.frozen,
	posts.Edit_id,
	posts.image_path,
	users.user_id,
	users.user_name,
	users.state,
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
	$sql4 = 'SELECT count( * ) post_topic  `posts` WHERE post_by = ' .$_GET['id'];


																
													 
                                                                
																
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
					
						echo '<td class="leftpart" width="35%" height="100%" rowspan="2">';
							if ( $row2['state'] == 2) {
							echo "Deleted User";
							}
							else
							{
								echo '<strong> <a href="members.php?id='. $row2['user_id'].'">' . $row2['user_name'] .'</a> </strong>';
							}
							echo"<br>";
							echo"<br>";
							if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
							{
							echo '<a href="uploads/' . $row2['user_name'].'"  target="_blank"> 
							<object data="uploads/'. $row2['user_name'].'.jpeg" width="100" height="100"></a>
							<a href="uploads/img02.png" target="_blank">
								<img src="uploads/img02.png" width="100" height="100" >
								</object>
								</a>';
								  echo"<br>";
								                               
																
							  echo"<br>";
							}
							else
							{
							echo '<a href="index.php"> 
							<object data="uploads/'. $row2['user_name'].'.jpeg" width="100" height="100">
							
								<img src="uploads/img02.png" width="100" height="100" >
								</object>
								</a>';
								  echo"<br>";
								                               
																
							  echo"<br>";
							  }
								$query3 = "SELECT level FROM `admin_level` WHERE id ="  .$row2['user_level'] ;

							$result3 = $mysqli->query($query3);
      							$row4 = $result3->fetch_assoc();
								
      							$level = $row4[level];
							echo $level;
							{
							$sql3 = "SELECT count( * ) post_topic FROM posts WHERE post_by =" .$row2['user_id'] ;

	$results = $mysqli->query($sql3);
	$count=$results->num_rows;
	//echo $count;
	while($row3 = $results->fetch_assoc())
	{
	$tcount=$row3['post_topic'];
	

	
	if($tcount>0 && $tcount<=5)
	{
	$userrank=" Newbie";
	$uplimit=1;
	}
	if($tcount>5 && $tcount<=16)
	{
	$userrank = " user";
	$uplimit=1;
	}
	if($tcount>16 && $tcount<=30)
	{
	$userrank = "Intermediate user";
    $uplimit=2;
	}
	if($tcount>30)
	{
	$userrank = "Veteran";
	$uplimit=3;
	}
	echo '<hr>';
	echo '<br>';	
echo "<span class='usrrank'>";echo "USER RANK:  ";echo $userrank;echo "</span>";	
echo '</br>';

}
}
	echo '</td>';
						echo '<td class="rightpart" height="10%">';
					
						     
							echo strval($row2['post_date']);

							if($row2['user_name'] == $name)
						     {
							 if($row2['frozen'] != 1 && $row['frozen'] != 1 && $row['state'] != 1 )
							 {
							
								echo '<a href="editpost.php?id='. $row2[post_id]. '" class="Edit" style="float:right;"> Edit</a>';
								echo '<a href="deletepost.php?id='. $row2[post_id]. '" class="Edit" style="float:right;"> Delete</a>';
							 }
						     }
							 else if ( $acess >= 1)
							 {
								if($row2['frozen'] != 1 && $row['frozen'] != 1)
								{
									echo '<a href="editpost.php?id='. $row2[post_id]. '" class="Edit" style="float:right;"> Edit</a>';
									echo '<a href="deletepost.php?id='. $row2[post_id]. '" class="Edit" style="float:right;"> Delete</a>';
								}
							 }
							echo'</td>';
							echo"</tr>";
							echo"<tr>";
							echo '<td class="rightpart">';
							//echo "<hr>";
							echo nl2br(mysql_real_unescape_string($row2['post_content']),2);
							
							$pieces = explode(",",$row2['image_path']);
							if($row2['image_path']!="")
							{
							
							$count = count($pieces);
							while($count)
							{
							echo '<img src="multiple/'.$pieces[--$count].' " alt="postimage" width="150" height="150"/>';
							}
							}
							if($row2['Edit_id'] !=  0)
							{
								
									$names = "SELECT user_name, user_id, state
						FROM `users`
						WHERE user_id = " . $row2['Edit_id'];
						
						$edit_results = $mysqli->query($names);
						$editor = $edit_results->fetch_assoc();
								echo "<br> <br>";
								
								if($editor['state'] == 2)
								{
								
								}
								else
								{
									echo "edited by <strong> " . $editor['user_name'] . "<strong>";
								}	
							}
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
		if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true && $row['frozen'] == 0 && $state == 0 )
{
	//Reply
	
	echo "<h4>Quick Reply</h4>";
	
	echo '<form method="post" action="reply.php" enctype="multipart/form-data">';
	echo '<input type="hidden" name="topic_id" value="'.$_GET[id] . '" >';
	echo'<label id="elements">Reply:</label> <textarea name="reply" rows="10" cols="50"></textarea>';
	//echo '<input type="submit" value="Reply" >';
	//echo'</form>';
	
	//Multiple Image upload
	$sql3 = "SELECT count( * ) post_topic FROM posts WHERE post_by =" .$id ;

	$results = $mysqli->query($sql3);
	$count=$results->num_rows;
	//echo $count;
	while($row3 = $results->fetch_assoc())
	{
	$tcount=$row3['post_topic'];
	

	
	if($tcount>0 && $tcount<=5)
	{
	$userrank=" Newbie";
	$uplimit=1;
	}
	if($tcount>5 && $tcount<=16)
	{
	$userrank = " user";
	$uplimit=1;
	}
	if($tcount>16 && $tcount<=30)
	{
	$userrank = "Intermediate user";
    $uplimit=2;
	}
	if($tcount>30)
	{
	$userrank = "Veteran";
	$uplimit=3;
	}
	}
//	echo $uplimit;
	//echo $userrank;
//echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
 for($i=1;$i<=$uplimit;$i++){
 
 echo '<p>Image'.$i.' :<input name="image[]" type="file" /></p>';
 }
 //echo ' <p>Image2 :<input name="image[]" type="file" /></p>';
  //echo '<p>Image3 :<input name="image[]" type="file" /></p>';
  echo '<input type="submit" name="submit" value="reply" />';
echo '</form>';

   /* define ("MAX_SIZE","5000"); 
function getExtension($str)
{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}

$errors=0;
         
if(isset($_POST['sendfiles'])) 
{
    
    

    $uploaddir = "multiple/"; //a directory inside
    foreach ($_FILES['photos']['name'] as $name => $value)
    {
        $filename = stripslashes($_FILES['photos']['name'][$name]);
     //get the extension of the file in a lower case format
          $extension = getExtension($filename);
         $extension = strtolower($extension);
      
         if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
         {
        //print error message
             echo '<h1>Unknown extension!</h1>';
             $errors=1;
         }
        else
        {
            $size=filesize($_FILES['photos']['tmp_name'][$name]);
            if ($size > MAX_SIZE*1024)
            {
                echo '<h1>You have exceeded the size limit!</h1>';
                $errors=1;
            }
            $image_name= $id . '_' .'.'.$extension;
            $newname="multiple/".$image_name;
			$counter = 1;
           $copied = copy($_FILES['photos']['tmp_name'][$name], $newname);
			   
            if (!$copied) 
            {
                echo '<h1>Copy unsuccessfull!</h1>';
                $errors=1;
            }
        
        }

    }
}*/

    
}



echo "</div>";
echo '	<div id="aside">';
if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{
	echo "Welcome ". $name;
	echo"<br>";

	echo'<a href="uploads/' . $name .'"  target="_blank"> 
							<object data="uploads/'. $name .'.jpeg" width="100" height="100"></a>
							<a href="uploads/img02.png" target="_blank">
								<img src="uploads/img02.png" width="100" height="100" >
								</object>
								</a>';
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


