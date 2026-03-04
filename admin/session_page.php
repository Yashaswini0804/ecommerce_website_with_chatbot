<?php
error_reporting(E_ALL & ~E_NOTICE);
if (session_status() == PHP_SESSION_NONE) 
{ @session_start(); }
$session_admin_id="";
if(isset($_SESSION['admin_id']))
{
    $session_admin_id=$_SESSION['admin_id'];
}
else{
    header("location:login.php");
}
?>