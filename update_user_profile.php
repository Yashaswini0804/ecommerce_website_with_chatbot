<?php
include "admin/dbconnect.php";
include "user_session_page.php";
$user_id="";
$name="";
$email="";
$phonenumber="";
$image_name = "";
if(isset($_POST['update']))
{
    $user_id=$_POST['user_id'];
    $name=$_POST['user_name'];
    $email=$_POST['user_email'];
    $phonenumber=$_POST['user_phonenumber'];
    $image_name="";
   

    $update_qry="UPDATE user_tbl SET
    user_name='$name',
    user_email='$email',
    user_phonenumber='$phonenumber'";


    if(!empty($_FILES['profile_img']['name']))
    {
        $folder ="uploads/";
        $image_name=$_FILES['profile_img']['name'];
        $temp_name =$_FILES['profile_img']['tmp_name'];

        move_uploaded_file($temp_name ,$folder.$image_name);

        $update_qry .=",profile_img='$image_name'";
    }
    $update_qry .=" WHERE user_id='$user_id'";
    $update_res=$conn->query($update_qry);
    if($update_res)
    {
       header("location:user_profile.php?status=successupdate");
    }
    else{
          header("location:user_profile.php?status=fail");
    }
}
?>