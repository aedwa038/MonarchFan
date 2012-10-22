<?php

//session_start();
//session_destroy();



setcookie("username", "", 1);
setcookie("id", "" , 1);
setcookie("level", "", 1);
setcookie("signed_in", "", 1);

session_destroy();
session_write_close();


//echo $_COOKIE['username'];
//echo $_COOKIE['level'];


echo'<a href =  "index.php"> Sucessfully Loged Out</a>';
//header("location:index.php");



?>
