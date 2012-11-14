<?php

include("header.php");
require("config.php");
require_once("paginator.class.php");

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


}

$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");


$query = "  SELECT
					topic_id,
					topic_subject,
					topic_date,
					frozen,
					topic_cat
				FROM
					topics
				WHERE
					topic_id =  " .$_GET['id'];
					
					
					$result = $mysqli->query($query) or die ("could not complete querry");
					$row = $result->fetch_assoc();
					
					//echo $query;
					//print_r($row);
					//print_r($result);
					//echo"test test test";
					//echo $row['topic_subject'];
					//echo $row['frozen'];


				if($row[frozen] == 1)
				{
					$sql = "UPDATE `aedwards`.`topics` SET `frozen` = '0' WHERE `topics`.`topic_id` =". $_GET['id'];
					
					$mysqli->query($sql) or die ("something went wrong querrying");
					echo '<a href="category.php?id='. $row['topic_cat'] .'">Successfully unlocked topic </a>';
					exit();
				}
				else if ($row[frozen] == 0)
				{
					$sql = "UPDATE `aedwards`.`topics` SET `frozen` = '1' WHERE `topics`.`topic_id` =" . $_GET['id'];
					$mysqli->query($sql) or die ("Something went wrong with querying");
					echo '<a href="category.php?id='. $row['topic_cat'] .'">Successfully locked topic </a>';
					exit();
					}
//UPDATE `aedwards`.`topics` SET `frozen` = '0' WHERE `topics`.`topic_id` =30;



?>