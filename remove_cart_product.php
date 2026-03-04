<?php
include "admin/dbconnect.php";

$id = $_GET["cart_id"];

$delete_qry = "UPDATE cart_tbl SET deleted='1' WHERE cart_id='$id'";

$result = $conn->query($delete_qry);
if($result)
{
    header("location:cart.php?status=success");
}
else{
    header("location:cart.php?status=error");
}
?>