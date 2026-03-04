<?php
include "dbconnect.php";
$name="";
$discription="";
$priority="";
$image="";
if(isset($_POST['category_name']))
    {
        $name=$_POST['category_name'];
    }
if(isset($_POST['category_discription']))
    {
        $discription=$_POST['category_discription'];
    }
if(isset($_POST['category_priority']))
    {
        $priority=$_POST['category_priority'];
    }
if(!empty($_FILES['category_img']['name']))
    {
        $folder="../images/";
        $image=$_FILES['category_img']['name'];
        $temp_img=$_FILES['category_img']['tmp_name'];

        move_uploaded_file($temp_img ,$folder.$image);
    }
$add_category_qry="INSERT INTO category_tbl(category_name,category_discription,category_priority,category_img)
values ('$name','$discription','$priority','$image')";
$add_category_res=$conn->query($add_category_qry);
if($add_category_res)
    {
        header("location:add_category.php?status=success");
    }
else
    {
        // Add error handling
        header("location:add_category.php?status=fail");
    }
?>