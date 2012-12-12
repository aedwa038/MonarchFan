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

<html>
<head>
<title> Monarch Forums</title>
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
  <link rel="stylesheet" type="text/css" href="style.css" >
  <!-- JavaScript includes -->
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="assets/js/script.js"></script>
		<!-- Captcha -->
		
	<script type="text/javascript" src="latest-jquery/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="latest-jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="captcha/jquery.captcha.js"></script>
	<link href="captcha/captcha.css" rel="stylesheet" type="text/css" />
	
	</style>
	<script type="text/javascript" charset="utf-8">
		$(function() {
			$(".ajax-fc-container").captcha({
				borderColor: "silver",
				text: "Verify that you are a human,<br />drag <span>scissors</span> into the circle."
			});
		});
	</script>

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
