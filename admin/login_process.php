<?php
session_start();
include "dbconnect.php";
include "session_page.php";
$username="";
$password="";
if(isset($_POST['user_name']))
{
    $username=$_POST['user_name'];
}
if(isset($_POST['upassword']))
{
    $password=$_POST['upassword'];
}
$admin_id="";
$get_qry="SELECT admin_id,user_name,upassword from admin_tbl where user_name = '$username' AND upassword ='$password' AND deleted='0'";
$get_res=$conn->query($get_qry);
if($get_res->num_rows >0)
{
    while($get_row = mysqli_fetch_array($get_res))
    {
        $admin_id=$get_row['admin_id'];
    }
    $_SESSION["admin_id"] = $admin_id;//setting the session
    header("location:homepage.php");
}
else
{
    $_SESSION['login_error'] = "Invalid user credential! Please check username and password.";
    header("location:login.php");
}
?>