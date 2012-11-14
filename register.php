<?php

session_start();
$name = '';
include("header.php");
require("config.php");
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	$name = $_SESSION['username'];
	$id = $_SESSION['id'];
	$acess = $_SESSION['level'];
	

}

?>

<html>
 <body>
  <form action="verify.php" method="post" name="register">
    <br>Username: <input type="text" name="username" /></br>
 <br>Password: <input type="password" name="password" /></br>
 <br>Email:&nbsp &nbsp &nbsp &nbsp <input type="email" name="email" /></br>
	<input type="hidden" name="form_submitted" value="1"/>
  <br><input type="submit" /></br>
  </form>
 </body>

</html>