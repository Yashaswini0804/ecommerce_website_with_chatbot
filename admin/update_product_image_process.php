<?php
include "dbconnect.php";
include "session_page.php";
$id="";
$name="";
$priority="";
$image="";
$product_id="";
if(isset($_POST['update']))
    {
        $id=$_POST['product_img_id'];
        $name=$_POST['product_img_name'];
        $priority=$_POST['product_img_priority'];
        $image=$_POST['product_img'];
        $product_id=$_POST['product_id'];
    }
$update_product_image_qry="UPDATE product_img_tbl SET
product_img_name='$name',
product_img_priority='$priority',
product_id='$product_id'";
if(!empty($_FILES['product_img']['name']))
    {
        $folder='../images/';
        $image=$_FILES['product_img']['name'];
        $temp_name=$_FILES['product_img']['tmp_name'];
        move_uploaded_file($temp_name ,$folder.$image);
        $update_product_image_qry .=", product_img='$image'";
    }
if(empty($name) || empty($product_id) || empty($priority)) {
    header("location:update_product_image.php?status=fail");
    exit;
}
$update_product_image_qry .="WHERE product_img_id='$id' and deleted='0'";
$update_product_image_res=$conn->query($update_product_image_qry);
if($update_product_image_res)
    {
        header("location:update_product_image.php?status=success&product_img_id=$id");
    }
else{
    header("location:update_product_image.php?status=fail&product_img_id=$id");
}
?>