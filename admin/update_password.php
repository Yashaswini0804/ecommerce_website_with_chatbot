<?php
include "dbconnect.php";
include "session_page.php";
$oldpassword="";
$upassword="";
$conpassword="";
if(isset($_POST['oldpassword']))
{
    $oldpassword=$_POST['oldpassword'];
}
if(isset($_POST['upassword']))
{
    $upassword=$_POST['upassword'];
}
if(isset($_POST['conpassword']))
{
    $conpassword=$_POST['conpassword'];
}
if (empty($upassword)) {
    header("location:profile.php?status=emptypassword");
    exit;
}
if ($upassword !== $conpassword) {
    header("location:profile.php?status=passwordmismatch");
    exit;
}

$verify_qry = "SELECT upassword FROM admin_tbl WHERE admin_id = '$session_admin_id' AND upassword = '$oldpassword' AND deleted = '0'";
$verify_res = $conn->query($verify_qry);
if (!$verify_res || $verify_res->num_rows == 0) {
    header("location:profilepage.php?status=invalidoldpassword");
    exit;
}

$update_qry = "UPDATE admin_tbl SET upassword = '$upassword' WHERE admin_id = '$session_admin_id'";
$update_res = $conn->query($update_qry);
if($update_res)
{
   header("location:profilepage.php?status=successupdate");
}
else{
    header("location:profilepage.php?status=fail");
}

?>