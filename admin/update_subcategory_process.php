<?php
include "dbconnect.php";
$id="";
$name ="";
$description="";
$priority="";
$category="";
if(isset($_POST['update']))
    {
        $id=$_POST['subcategory_id'];
        $name=$_POST['subcategory_name'];
        $description=$_POST['subcategory_discription'];
        $priority=$_POST['subcategory_priority'];
        $category=$_POST['category_id'];
    }
$update_subcategory_qry="UPDATE subcategory_tbl SET
subcategory_name='$name',
subcategory_discription='$description',
subcategory_priority='$priority',
category_id='$category'";
if(!empty($_FILES['subcategory_img']['name']))
    {
        $folder='../images/';
        $image=$_FILES['subcategory_img']['name'];
        $temp_name=$_FILES['subcategory_img']['tmp_name'];

        move_uploaded_file($temp_name, $folder.$image);
        $update_subcategory_qry .=", subcategory_img='$image'";
    }

$update_subcategory_qry .=" WHERE subcategory_id='$id' AND deleted='0'";
$update_subcategory_res=$conn->query($update_subcategory_qry);
if($update_subcategory_res !== false)
    {
        header("location:update_subcategory.php?status=success&subcategory_id=$id");
    }
else{
    header("location:update_subcategory.php?status=fail&subcategory_id=$id");
}
?>