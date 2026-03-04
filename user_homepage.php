<?php 
$page_title = "User Homepage";
include "header.php"; 
?>

<?php
include "user_session_page.php";
include "admin/dbconnect.php"; 

if(isset($_GET['status']))
{
    if($_GET['status']== "success")
    {
        echo '<div class="alert alert-success">Product added to the cart! Go to cart to view the product.</div>';
    }
    else{
        echo '<div class="alert alert-error">Unable to add the product</div>';
    }
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$get_qry = "SELECT p.product_id, p.product_name, p.selling_price, p.product_discription, pi.product_img
            FROM product_tbl p
            LEFT JOIN product_img_tbl pi ON p.product_id = pi.product_id AND pi.deleted='0'
            WHERE p.deleted='0'";

if (!empty($search)) {
    $get_qry .= " AND p.product_name LIKE '%$search%'";
}

$result = $conn->query($get_qry);
?>

<div class="search-bar">
    <form action="user_homepage.php" method="get">
        <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="product-grid">
        <?php while ($product = $result->fetch_array()): ?>
            <?php 
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_price = $product['selling_price'];
            $product_description = substr($product['product_discription'], 0, 100); 
            $product_image = $product['product_img'] ? 'images/' . $product['product_img'] : '';
            ?>
            <div class="product-card">
                <?php if ($product_image && file_exists($product_image)): ?>
                    <img src="<?php echo htmlspecialchars($product_image); ?>" alt="<?php echo htmlspecialchars($product_name); ?>">
                <?php else: ?>
                    <div class="no-image">No image available</div>
                <?php endif; ?>
                <div class="product-card-body">
                    <h3><?php echo htmlspecialchars($product_name); ?></h3>
                    <div class="price">Rs.<?php echo $product_price; ?></div>
                    <p class="description"><?php echo htmlspecialchars($product_description); ?></p>
                    <form action="add_to_cart.php" method="post"> 
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">No products found.</div>
<?php endif; ?>

<?php include "chatbot_widget.php"; ?>

<?php include "footer.php"; ?>

