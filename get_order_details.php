<?php
include "admin/dbconnect.php";
include "user_session_page.php";

$order_id = $_POST['order_id'];
$user_id = $session_user_id;

$order_date = "";
$order_deleted = false;
$get_order_info = "SELECT order_date, deleted FROM order_tbl WHERE order_id = '$order_id' AND user_id = '$user_id'";
$get_order_info_res = $conn->query($get_order_info);
if ($get_order_info_res && $row = mysqli_fetch_assoc($get_order_info_res)) {
    $order_date = $row['order_date'];
    $order_deleted = ($row['deleted'] == 1);
}

$get_products = "SELECT od.product_id, od.product_name, od.quantity, od.price, od.total_price,
                 (SELECT pi.product_img FROM product_img_tbl pi WHERE pi.product_id = od.product_id AND pi.deleted = '0' ORDER BY pi.product_img_priority ASC LIMIT 1) as product_image
                 FROM order_details_tbl od
                 WHERE od.order_id = '$order_id' AND od.user_id = '$user_id' AND od.deleted = '0'";

$get_products_res = $conn->query($get_products);

$cancelled_products = [];
$check_cancelled = "SELECT product_id FROM cancled_product_tbl WHERE user_id = '$user_id'";
$check_cancelled_res = $conn->query($check_cancelled);
if ($check_cancelled_res) {
    while ($row = mysqli_fetch_assoc($check_cancelled_res)) {
        $cancelled_products[] = $row['product_id'];
    }
}

echo '<style>
    .order-details-container {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    .order-date {
        margin-bottom: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .order-details-container hr {
        margin: 15px 0;
        border: none;
        border-top: 1px solid #ddd;
    }
    .order-product-card {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 15px;
        background: white;
    }
    .order-product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 20px;
    }
    .order-product-info {
        flex: 1;
    }
    .order-product-info h4 {
        margin: 0 0 8px 0;
        color: #333;
    }
    .order-product-info p {
        margin: 4px 0;
        color: #666;
        font-size: 14px;
    }
    .order-product-action {
        margin-left: 15px;
    }
    .cancel-btn {
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background: #dc3545;
        color: white;
        font-size: 14px;
        transition: all 0.3s;
    }
    .cancel-btn:hover {
        background: #c82333;
    }
    .cancel-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }
    .cancel-btn-red {
        background: #6c757d !important;
    }
    .cancelled-badge {
        padding: 8px 15px;
        border-radius: 5px;
        background: #f8d7da;
        color: #721c24;
        font-weight: 600;
    }
    .order-cancelled-notice {
        padding: 10px 15px;
        background: #f8d7da;
        color: #721c24;
        border-radius: 8px;
        margin-bottom: 15px;
        font-weight: bold;
    }
</style>';

echo '<div class="order-details-container">';
echo '<div class="order-date">';
echo '<strong>Ordered Date:</strong> ' . htmlspecialchars($order_date);
if ($order_deleted) {
    echo ' &nbsp; | &nbsp; <span style="color: red; font-weight: bold;">Order Cancelled</span>';
}
echo '</div><hr>';

if ($order_deleted) {
    echo '<div class="order-cancelled-notice">This order has been cancelled.</div>';
}

while ($row = mysqli_fetch_array($get_products_res)) {
    $product_id = $row['product_id'];
    $product_name = $row['product_name'];
    $quantity = $row['quantity'];
    $price = $row['price'];
    $total_price = $row['total_price'];
    $product_image = $row['product_image'];
    $is_cancelled = in_array($product_id, $cancelled_products);
    
    $image_src = !empty($product_image) ? "images/" . $product_image : "images/image2.jpg";
    ?>
    <div class="order-product-card">
        <img src="<?php echo htmlspecialchars($image_src); ?>" alt="<?php echo htmlspecialchars($product_name); ?>" class="order-product-image">
        <div class="order-product-info">
            <h4><?php echo htmlspecialchars($product_name); ?></h4>
            <p><strong>Price:</strong> Rs. <?php echo $price; ?></p>
            <p><strong>Quantity:</strong> <?php echo $quantity; ?></p>
            <p><strong>Total:</strong> Rs. <?php echo $total_price; ?></p>
        </div>
        <div class="order-product-action">
            <?php if ($order_deleted): ?>
                <span class="cancelled-badge">Order Cancelled</span>
            <?php elseif ($is_cancelled): ?>
                <button type="button" id="cancel-btn-<?php echo $product_id; ?>" 
                        class="cancel-btn cancel-btn-red" disabled>Cancelled</button>
            <?php else: ?>
                <button type="button" id="cancel-btn-<?php echo $product_id; ?>" 
                        class="cancel-btn" onclick="openCancelModal(<?php echo $product_id; ?>, <?php echo $order_id; ?>)">Cancel</button>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

echo '</div>';

$conn->close();
?>

