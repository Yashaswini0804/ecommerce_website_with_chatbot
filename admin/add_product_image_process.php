<?php
include "dbconnect.php";
include "session_page.php";

$name="";
$product_id="";
$image="";
$priority="";
if(isset($_POST['product_img_priority']))
    {
        $priority=$_POST['product_img_priority'];
    }
if(isset($_POST['product_id']))
    {
        $product_id=$_POST['product_id'];
    }
if(isset($_POST['product_img_name']))
    {
        $name=$_POST['product_img_name'];
    }
if(!empty($_FILES['product_img']['name']))
    {
        $random_no=rand(1,1000000);
        $folder='../images/';
        $image=$_FILES['product_img']['name'];
         $image=$random_no."-".$image;
        $temp_img=$_FILES['product_img']['tmp_name'];
        move_uploaded_file($temp_img ,$folder.$image);

       
    }
if(empty($name) || empty($product_id) || empty($priority) || empty($image)) {
    header("location:add_product_image.php?status=fail");
    exit;
}
echo $add_product_image_qry="INSERT into product_img_tbl(product_img_name,product_img,product_id,product_img_priority)
values('$name','$image','$product_id','$priority')";
$add_product_image_res=$conn->query($add_product_image_qry);
if($add_product_image_res)
    {
        header("location:add_product_image.php?status=success");
    }
else{
    header("location:add_product_image.php?status=fail");
}

?>