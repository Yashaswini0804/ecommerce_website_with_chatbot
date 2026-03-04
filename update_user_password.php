<?php
include "admin/dbconnect.php";
include "user_session_page.php";
$oldpassword="";
$user_password="";
$conpassword="";
if(isset($_POST['oldpassword']))
{
    $oldpassword=$_POST['oldpassword'];
}
if(isset($_POST['user_password']))
{
    $user_password=$_POST['user_password'];
}
if(isset($_POST['conpassword']))
{
    $conpassword=$_POST['conpassword'];
}
if (empty($user_password)) {
    header("location:user_profile.php?status=emptypassword");
    exit;
}
if ($user_password !== $conpassword) {
    header("location:user_profile.php?status=passwordmismatch");
    exit;
}

$verify_qry = "SELECT user_password FROM user_tbl WHERE user_id = '$session_user_id' AND user_password = '$oldpassword' AND deleted = '0'";
$verify_res = $conn->query($verify_qry);
if (!$verify_res || $verify_res->num_rows == 0) {
    header("location:user_profile.php?status=invalidoldpassword");
    exit;
}

$update_qry = "UPDATE user_tbl SET user_password = '$user_password' WHERE user_id = '$session_user_id'";
$update_res = $conn->query($update_qry);
if($update_res)
{
   header("location:user_profile.php?status=successupdate");
}
else{
    header("location:user_profile.php?status=fail");
}

?>