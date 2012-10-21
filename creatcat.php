<?php

session_start();
$name = '';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{

	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
	$acess = $_SESSION['level'];
	
	if($acess < 2)
	{

		echo"Your not suppose to be here";
		exit();
	}	

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >

<title> Creation</title>
<style type="text/css">

		
       #element
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

<h3> Forum Creation </h3>

<form method="post" action="createcat.php">
 	<label id="element">Category name:</label> <input type="text" name="cat_name" >
	<br>
	<br>
 	<label id="element">Category description:</label> <textarea name="cat_description" rows="10" cols="50"></textarea>
	<br>
	<br>
	<input type="submit" value="Add category" >
 </form>

</body>

</html>
