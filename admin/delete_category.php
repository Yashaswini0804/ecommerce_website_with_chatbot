<?php
include("dbconnect.php");

$id = $_GET["category_id"];

$delete_qry = "UPDATE category_tbl SET deleted='1' WHERE category_id='$id'";

$result = $conn->query($delete_qry);
if($result)
{
    header("location:view_category.php?status=success");
}
else{
    header("location:view_category.php?status=error");
}
?>