<?php
include "admin/dbconnect.php";
$user_email="";
$user_phonenumber="";
$username="";
$password="";
$profile_img="";
$image_name="";
if(isset($_POST['user_email']))
{
    $user_email=$_POST['user_email'];
}
if(isset($_POST['user_phonenumber']))
{
    $user_phonenumber=$_POST['user_phonenumber'];
}
if(isset($_POST['user_name']))
{
    $username=$_POST['user_name'];
}
if(isset($_POST['user_password']))
{
    $password=$_POST['user_password'];
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
$register_qry="INSERT into user_tbl (user_email,user_phonenumber,user_name,user_password,profile_img,deleted)
values('$user_email','$user_phonenumber','$username','$password','$image_name','0')";
$register_res=$conn->query($register_qry);
if($register_res)
{
    header("location:user_register.php?status=success");
}
else{
    // Add error handling
    echo "Error: " . $conn->error;
    header("location:user_register.php?status=error");
}
?>
