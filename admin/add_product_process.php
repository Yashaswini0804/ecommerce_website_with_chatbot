<?php
include "dbconnect.php";
$name = "";
$discription = "";
$sp = "";
$stock = "";
$category = "";
$subcategory = "";
if (isset($_POST['product_name'])) {
    $name = $_POST['product_name'];
}
if (isset($_POST['product_discription'])) {
    $discription = $_POST['product_discription'];
}
if (isset($_POST['category_id'])) {
    $category = $_POST['category_id'];
}
if (isset($_POST['subcategory_id'])) {
    $subcategory = $_POST['subcategory_id'];
}
if (isset($_POST['selling_price'])) {
    $sp = $_POST['selling_price'];
}
if (isset($_POST['stock'])) {
    $stock = $_POST['stock'];
}

if (empty($name) || empty($discription) || empty($category) || empty($subcategory) || empty($sp) || empty($stock)) {
    header("location:add_product.php?status=fail");
    exit;
}
$add_product_qry = "INSERT INTO product_tbl(product_name, product_discription, subcategory_id, category_id, selling_price, stock, deleted)
values ('$name', '$discription', '$subcategory', '$category', '$sp', '$stock', '0')";
$add_product_res = $conn->query($add_product_qry);
if ($add_product_res) {
    header("location:add_product.php?status=success");
} else {
    header("location:add_product.php?status=fail");
}
?>
