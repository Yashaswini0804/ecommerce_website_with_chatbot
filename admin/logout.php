<?php 
session_start();
session_destroy();//deleting the session using this code
header("location:login.php");
?>