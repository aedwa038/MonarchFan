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
//create_cat.php
include("header.php");
require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//the form hasn't been posted yet, display it
	echo " No Topic submited";
}

$cat_id = $_POST['topic_cat'];

$topic_subject = $_POST['topic_subject'];

$post = $_POST['post'];

echo"<br>";


if($topic_subject == '' || $post == '')
{
	echo"A post or topic subject is needed ";

}
else
{

	//$topic_subject = $mysqli->real_escape_string($topic_subject);
	//$post = $mysqli->real_escape_string($post);


		$query  = "BEGIN WORK;";
		$result = $mysqli->query($query);
		


		if(!$result)
		{
			//Damn! the query failed, quit
			echo 'An error occured while creating your topic. Please try again later.';
		}
		else
		{
			//the form has been posted, so save it
			//insert the topic into the topics table first, then we'll save the post into the posts table
			$sql = "INSERT INTO
						topics(topic_subject,
							   topic_date,
							   topic_cat,
							   topic_by)
				   VALUES('" . $mysqli->real_escape_string($topic_subject) . "',
							   NOW(),
							   " . $mysqli->real_escape_string($cat_id) . ",". $id . ")";
			$result = $mysqli->query($sql);
			
			
			

			if(!$result)
			{
				//something went wrong, display the error
				echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
				$sql = "ROLLBACK;";
				$result = $mysqli->query($sql);
			}
			else
			{
				//the first query worked, now start the second, posts query
				//retrieve the id of the freshly created topic for usage in the posts query
				
				$topicid = $mysqli->insert_id;
				
				$sql = "INSERT INTO
							posts(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . $mysqli->real_escape_string($post) . "',
								  NOW(),
								  " . $topicid . ",". $id . ")";
								  $result = $mysqli->query($sql);
								

				if(!$result)
				{
					//something went wrong, display the error
					echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
					$sql = "ROLLBACK;";
					$result = $mysqli->query($sql);
				}
				
				else
				{
					$sql = "COMMIT;";
					$result = mysql_query($sql);
					//after a lot of work, the query succeeded!
					echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
				}

			}

		

		}	
	}


include("footer.php");

?>


