<?php
include("dbconnect.php");

$id = $_GET["subcategory_id"];

$delete_qry = "UPDATE subcategory_tbl SET deleted='1' WHERE subcategory_id='$id'";

$result = $conn->query($delete_qry);
if($result)
{
    header("location:view_subcategory.php?status=success");
}
else{
    header("location:view_subcategory.php?status=error");
}
?>