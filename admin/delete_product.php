<?php
include("dbconnect.php");

$id = $_GET["product_id"];

$delete_qry = "UPDATE product_tbl SET deleted='1' WHERE product_id='$id'";

$result = $conn->query($delete_qry);
if($result)
{
    header("location:view_product.php?status=success");
}
else{
    header("location:view_product.php?status=error");
}
?>