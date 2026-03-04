<?php
include "admin/dbconnect.php";
include "user_session_page.php";

$product_id = "";
$order_id   = "";
$reason     = "";
$user_id    = $session_user_id;
$date_of_deletion = date('Y-m-d H:i:s');

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
}
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
}
if (isset($_POST['reason'])) {
    $reason = $_POST['reason'];
}

$check_existing = "SELECT product_id 
                   FROM cancled_product_tbl 
                   WHERE product_id = '$product_id' AND user_id = '$user_id'";
$check_existing_res = $conn->query($check_existing);

if ($check_existing_res && $check_existing_res->num_rows > 0) {
    echo "already_cancelled";
    $conn->close();
    exit;
}
$insert_cancelled = "INSERT INTO cancled_product_tbl (product_id, reason, user_id, date_of_deletion)
                     VALUES ('$product_id', '$reason', '$user_id', '$date_of_deletion')";
$insert_cancelled_res = $conn->query($insert_cancelled);

if ($insert_cancelled_res) {
    $update_deleted = "UPDATE order_details_tbl 
                       SET deleted = '1' 
                       WHERE product_id = '$product_id' AND order_id = '$order_id' AND user_id = '$user_id'";
    $conn->query($update_deleted);

    $update_order_deleted = "UPDATE order_tbl 
                             SET deleted = '1', order_status = 'cancelled' 
                             WHERE order_id = '$order_id' AND user_id = '$user_id'";
    $conn->query($update_order_deleted);

    echo "success";
} else {
    echo "error";
}

$conn->close();
?>