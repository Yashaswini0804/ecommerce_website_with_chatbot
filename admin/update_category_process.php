<?php
include "dbconnect.php";
$id="";
$name ="";
$description="";
$priority="";
if(isset($_POST['update']))
    {
        $id=$_POST['category_id'];
        $name=$_POST['category_name'];
        $description=$_POST['category_discription'];
        $priority=$_POST['category_priority'];

    }
$update_category_qry="UPDATE category_tbl SET
category_name='$name',
category_discription='$description',
category_priority='$priority'";
if(!empty($_FILES['category_img']['name']))
    {
        $folder='../images/';
        $image=$_FILES['category_img']['name'];
        $temp_name=$_FILES['category_img']['tmp_name'];

        move_uploaded_file($temp_name, $folder.$image);
        $update_category_qry .=", category_img='$image'";
    }

$update_category_qry .= " WHERE category_id='$id' AND deleted='0'";
$update_category_res=$conn->query($update_category_qry);
if($update_category_res)
    {
        header("location:update_category.php?status=success&category_id=$id");
    }
else{
    header("location:update_category.php?status=fail&category_id=$id");
}
?>