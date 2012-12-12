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
<head>
<script src="gen_validatorv4.js" type="text/javascript"></script>

</head>
<body>
<form id="myform" action="verify.php" method="post" enctype="multipart/form-data">
	<table border='1' width="70%" align='center' cellpadding="8" cellspacing="0">
	<tr><th colspan='3'>New User Please Register</th></tr>
	<tr>
	<div align="center">
	<td><br>Username: <input type="text" name="username" /></br></td></tr>
	<tr><td><br>Password: <input type="password" name="password" /></br></td></tr>
	<tr><td><br>Email:&nbsp &nbsp &nbsp &nbsp <input type="email" name="email" /></br>
	<br><input type="radio" name="eformat" value="html">text/html email<input type="radio" name="eformat" value="plain">text/plain email</br></td></tr>
	<tr><td><br>&nbsp &nbsp &nbsp Image Upload : <input type="file" name="image"/>
	<form action="captcha/captcha.php" method="post" id="myForm">
	<!-- Begin of captcha -->
	<tr><td><div class="ajax-fc-container"></div></td></tr>
	<!-- End of captcha -->
	</form>
	<input type="hidden" name="form_submitted" value="1"/></td></tr>
	<tr><td colspan='3' align='right'>
	<br><input type="submit" value='Register !' name='submit'/> <input type='Reset' value='reset !' name='refresh'/> </br></td></tr>
	</table>
</form>
<script type="text/javascript">
 var frmvalidator  = new Validator("myform");
 frmvalidator.addValidation("username","req","Please enterusername");
 frmvalidator.addValidation("password","req","Please enter your password");
 frmvalidator.addValidation("email","req","Please enter your email");
 //frmvalidator.addValidation("username","req","Please enter your First Name");
</script>
</body>

</html>