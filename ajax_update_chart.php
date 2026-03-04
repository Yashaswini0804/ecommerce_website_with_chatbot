<?php
include "admin/dbconnect.php";
include "user_session_page.php"; 

$cartid = $_POST['cart_id'] ?? '';
$productid = $_POST['product_id'] ?? '';
$type = $_POST['type'] ?? '';
$user_id = $session_user_id;

$response = [];

if ($type == 'add') {
    $update_qty_qry = "UPDATE cart_tbl SET quantity = quantity + 1 WHERE cart_id = '$cartid' AND product_id = '$productid'";
    $conn->query($update_qty_qry);
} elseif ($type == 'remove') {
    $get_qty_qry = "SELECT quantity FROM cart_tbl WHERE cart_id = '$cartid' AND product_id = '$productid'";
    $get_result = $conn->query($get_qty_qry);

    if ($get_result && $row = mysqli_fetch_array($get_result)) {
        if ($row['quantity'] > 1) {
            $update_qty_qry = "UPDATE cart_tbl SET quantity = quantity - 1 WHERE cart_id = '$cartid' AND product_id = '$productid'";
            $conn->query($update_qty_qry);
        } else {
            $remove_qty_qry = "DELETE FROM cart_tbl WHERE cart_id = '$cartid' AND product_id = '$productid'";
            $conn->query($remove_qty_qry);

            $grand_total_qry="SELECT SUM(c.quantity * p.selling_price) AS grand_total 
                                       FROM cart_tbl c 
                                       JOIN product_tbl p ON c.product_id = p.product_id 
                                       WHERE c.user_id='$user_id' AND p.deleted='0'";
        
            $grand_res = $conn->query($grand_total_qry);
            $grand_row = mysqli_fetch_array($grand_res);
            $response = [
                "status" => "item_removed",
                "grand_total" => $grand_row['grand_total'] ?? 0
            ];
            echo json_encode($response);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error checking quantity"]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid type"]);
    exit;
}

//getting  new quantity after updations
$qty_res = $conn->query("SELECT quantity FROM cart_tbl WHERE cart_id='$cartid'");
$qty_row = mysqli_fetch_array($qty_res);
$new_quantity = $qty_row['quantity'];

// getting new selling price after updations 
$price_res = $conn->query("SELECT selling_price FROM product_tbl WHERE product_id='$productid'");
$price_row = mysqli_fetch_array($price_res);
$selling_price = $price_row['selling_price'];

$new_total = $new_quantity * $selling_price;

$grand_total_qry= "SELECT SUM(c.quantity * p.selling_price) AS grand_total 
                           FROM cart_tbl c 
                           JOIN product_tbl p ON c.product_id = p.product_id 
                           WHERE c.user_id='$user_id' AND p.deleted='0'";
$grand_res = $conn->query($grand_total_qry);
$grand_row = mysqli_fetch_array($grand_res);
$grand_total = $grand_row['grand_total'];

$response = [
    "status" => "updated",
    "new_quantity" => $new_quantity,
    "new_total" => $new_total,
    "grand_total" => $grand_total
];

echo json_encode($response);

// here Javascript Object Notaion(json)is used for data interchange in php.
?>