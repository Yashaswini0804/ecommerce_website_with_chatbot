<?php
include("dbconnect.php");

$id = $_GET["product_img_id"];

$delete_qry = "UPDATE product_img_tbl SET deleted='1' WHERE product_img_id='$id'";

$result = $conn->query($delete_qry);
if($result)
{
    header("location:view_product_image.php?status=success");
}
else{
    header("location:view_product_image.php?status=error");
}
?>