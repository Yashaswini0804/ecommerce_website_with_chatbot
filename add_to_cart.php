<?php
include "user_session_page.php";
include "admin/dbconnect.php";

if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $session_user_id;


    $check_product = "SELECT product_id FROM product_tbl WHERE product_id = '$product_id' AND deleted = '0'";
    $product_result = $conn->query($check_product);


    if ($product_result && $product_result->num_rows > 0) {
        //if product exists then it enter in to this if statement.
        // Checking the cart  if item is already in cart
        $check_cart = "SELECT cart_id, quantity FROM cart_tbl WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $cart_result = $conn->query($check_cart);
         
        // updating the quantity  if product is already in cart
        if ($cart_result && $cart_result->num_rows > 0) {
            $cart_row = mysqli_fetch_array($cart_result);
            $new_quantity = $cart_row['quantity'] + 1;
            $update_cart = "UPDATE cart_tbl SET quantity = '$new_quantity' WHERE cart_id = '{$cart_row['cart_id']}'";
            $conn->query($update_cart);
        }
        //if product is not in cart then add it to cart.
         else {
            $insert_cart = "INSERT INTO cart_tbl (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)";
            $conn->query($insert_cart);
        }


        header("Location: user_homepage.php?status=success");
        exit();
    } else {
        header("Location: user_homepage.php?status=fail");
        exit();
    }
} else {
    header("Location: user_homepage.php?status=fail");
    exit();
}
?>
