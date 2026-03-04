<?php
include "admin/dbconnect.php";
include "user_session_page.php";
$shipping_address="";
$cart_id="";
$payment_method="";
$grand_total="";
$user_id = $session_user_id;
if(isset($_POST['shipping_address']))
    {
        $shipping_address = $_POST['shipping_address'];
    }

if(isset($_POST['grand_total']))
    {
        $grand_total = $_POST['grand_total'];
    }
if(isset($_POST['payment_method']))
    {
        $payment_method =  $_POST['payment_method'];
    }
$get_cart_id = "SELECT cart_id from cart_tbl where user_id ='$session_user_id' ";
$get_cart_id_res = $conn->query($get_cart_id);
if($get_cart_id_res && $get_cart_id_res->num_rows > 0)
    {
        $row = mysqli_fetch_assoc($get_cart_id_res);
        $cart_id = $row['cart_id'];
    }

$insert_payment_qry = "INSERT into payment_tbl(cart_id, payment_method,grand_total,user_id,shipping_address,payment_status)
values('$cart_id','$payment_method','$grand_total','$user_id','$shipping_address','successful')";
$insert_payment_res = $conn->query($insert_payment_qry);
if($insert_payment_res)
    {      
        $random_no=rand(1,1000000);
        $order_num=$random_no.$session_user_id;
        echo $order_num;
        $insert_order_qry = "INSERT into order_tbl(order_num,user_id)values('$order_num','$session_user_id')";
        $insert_order_res=$conn->query($insert_order_qry);
        if($insert_order_res)
            {
                $order_key = $conn->insert_id;
            }                
        $get_cart_details = "SELECT c.product_id, c.quantity,p.selling_price, p.product_name
                            from cart_tbl c
                            join product_tbl p ON c.product_id = p.product_id
                            WHERE c.user_id = '$user_id' AND p.deleted = '0'";
        $get_cart_details_res = $conn->query($get_cart_details);
        if($get_cart_details_res && $get_cart_details_res > 0)
            {
             while($row = mysqli_fetch_array($get_cart_details_res))
                {
                    $product_id = $row['product_id'];
                    $quantity = $row['quantity'];
                    $selling_price =$row['selling_price'];
                    $product_name = $row['product_name'];
                    $total_price = $quantity * $selling_price;

                    $insert_into_order_details_qry = "INSERT into order_details_tbl (user_id,order_id,product_id,quantity,price,product_name,shipping_address,total_price)
                    values('$session_user_id','$order_key','$product_id','$quantity','$selling_price','$product_name','$shipping_address','$total_price')";
                    $conn->query($insert_into_order_details_qry);
                }
            }
            $delete_cart_qry = "DELETE FROM cart_tbl WHERE user_id='$user_id'";
            $conn->query($delete_cart_qry);
        header("location:cart.php?status=success");
    }
else
    {
        header("loaction:cart.php?status=fail");
    }

?>