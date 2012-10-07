<?php

session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
}

require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//the form hasn't been posted yet, display it
	echo " No Reply submited";
}

$reply = $_POST['reply'];
$topic_id = $_POST['topic_id'] ;

//$reply = $mysqli->real_escape_string($reply);


 if ($reply == '')
 {
		echo "No reply was posted";
		
 }
 
 else 
 {
echo $reply;
echo $topic_id;
echo "<br>";
echo $id;


$sql = "INSERT INTO
							posts(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . $mysqli->real_escape_string($reply) . "',
								  NOW(),
								  " . $topic_id . ",". $id .")";
								  $result = $mysqli->query($sql);

	
	
			header("location:topic.php?id=". $topic_id );

}

?>