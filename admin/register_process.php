<?php
include "dbconnect.php";
$admin_name="";
$admin_email="";
$admin_phonenumber="";
$username="";
$password="";
$profile_img="";
if(isset($_POST['admin_name']))
{
    $admin_name=$_POST['admin_name'];
}
if(isset($_POST['admin_email']))
{
    $admin_email=$_POST['admin_email'];
}
if(isset($_POST['admin_phonenumber']))
{
    $admin_phonenumber=$_POST['admin_phonenumber'];
}
if(isset($_POST['user_name']))
{
    $username=$_POST['user_name'];
}
if(isset($_POST['upassword']))
{
    $password=$_POST['upassword'];
}
if(isset($_POST['profile_img']))
{
    $image_name=$_POST['profile_img'];
}
 if(!empty($_FILES['profile_img']['name']))
    {
        $folder ="uploads/";
        $image_name=$_FILES['profile_img']['name'];//permanent
        $temp_name =$_FILES['profile_img']['tmp_name'];//temporary

        move_uploaded_file($temp_name ,$folder.$image_name);
    }
$register_qry="INSERT into admin_tbl (admin_name,admin_email,admin_phonenumber,user_name,upassword,profile_img,deleted)
values('$admin_name','$admin_email','$admin_phonenumber','$username','$password','$image_name','0')";
$register_res=$conn->query($register_qry);
if($register_res)
{
    header("location:register.php?status=success");
}
else{
    // Add error handling
    echo "Error: " . $conn->error;
    header("location:register.php?status=error");
}
?>
