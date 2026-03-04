<?php
session_start();
include "admin/dbconnect.php";
include "user_session_page.php";
$username="";
$password="";
if(isset($_POST['user_name']))
{
    $username=$_POST['user_name'];
}
if(isset($_POST['user_password']))
{
    $password=$_POST['user_password'];
}
$user_id="";
$get_qry="SELECT user_id,user_name,user_password from user_tbl where user_name = '$username' AND user_password ='$password' AND deleted='0'";
$get_res=$conn->query($get_qry);
if($get_res->num_rows >0)
{
    while($get_row = mysqli_fetch_array($get_res))
    {
        $user_id=$get_row['user_id'];
    }
    $_SESSION["user_id"] = $user_id;//setting the session
    header("location:user_homepage.php");
}
else
{
    $_SESSION['login_error'] = "Invalid user credential! Please check username and password.";
    header("location:user_login.php");
}
?>