/<?php
include "dbconnect.php";
include "session_page.php";
$admin_id="";
$name="";
$email="";
$phonenumber="";
$username="";
$image_name = "";
if(isset($_POST['update']))
{
    $admin_id=$_POST['admin_id'];
    $name=$_POST['admin_name'];
    $email=$_POST['admin_email'];
    $phonenumber=$_POST['admin_phonenumber'];
    $username=$_POST['user_name'];
    $image_name="";
   

    $update_qry="UPDATE admin_tbl SET
    admin_name='$name',
    admin_email='$email',
    admin_phonenumber='$phonenumber',
    user_name='$username' ";


    if(!empty($_FILES['profile_img']['name']))
    {
        $folder ="../uploads/";
        $image_name=$_FILES['profile_img']['name'];//permanent
        $temp_name =$_FILES['profile_img']['tmp_name'];//temporary

        move_uploaded_file($temp_name ,$folder.$image_name);

        $update_qry .=",profile_img='$image_name'";
    }
    $update_qry .=" WHERE admin_id='$admin_id'";
    $update_res=$conn->query($update_qry);
    if($update_res)
    {
       header("location:profilepage.php?status=successupdate");
    }
    else{
          header("location:profilepage.php?status=fail");
    }
}
?>