<?php
include "dbconnect.php";
$id="";
$name ="";
$description="";
$sp="";
$stock="";
$category="";
$subcategory="";
if(isset($_POST['update']))
    {
        $id=$_POST['product_id'];
        $name=$_POST['product_name'];
        $description=$_POST['product_discription'];
        $sp=$_POST['selling_price'];
        $stock=$_POST['stock'];
        $category=$_POST['category_id'];
        $subcategory=$_POST['subcategory_id'];

    }
$update_product_qry="UPDATE product_tbl SET
product_name='$name',
product_discription='$description',
category_id='$category',
subcategory_id='$subcategory',
selling_price='$sp',
stock='$stock'
WHERE product_id='$id' AND deleted='0'";
$update_product_res=$conn->query($update_product_qry);
if($update_product_res !== false)
    {
        header("location:update_product.php?status=success&product_id=$id");
    }
else{
    header("location:update_product.php?status=fail&product_id=$id");
}
?>