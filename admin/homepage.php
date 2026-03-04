
<?php 
$page_title = "Admin Dashboard";
include "admin_navbar.php";
include "admin_header.php"; 
?>

<?php
include "dbconnect.php";
?>

<div class="admin-content">
    <div class="quick-actions"> 
        <div class="action-card">
            <h3>⚙️ Admin Menu</h3>
            <p>Access admin features</p>
            <a href="admin_menu.php">View Menu</a>
        </div>
        
        <?php
        $product_count = 0;
        $category_count = 0;
        $order_count = 0;
        
        $product_qry = "SELECT COUNT(*) as count FROM product_tbl WHERE deleted='0'";
        $product_res = $conn->query($product_qry);
        if($product_res && $row = $product_res->fetch_assoc()) {
            $product_count = $row['count'];
        }
        
        $category_qry = "SELECT COUNT(*) as count FROM category_tbl WHERE deleted='0'";
        $category_res = $conn->query($category_qry);
        if($category_res && $row = $category_res->fetch_assoc()) {
            $category_count = $row['count'];
        }
        
        $order_qry = "SELECT COUNT(*) as count FROM order_tbl";
        $order_res = $conn->query($order_qry);
        if($order_res && $row = $order_res->fetch_assoc()) {
            $order_count = $row['count'];
        }
        ?>
        
        <div class="action-card">
            <h3>📦 Products</h3>
            <p class="stat-number"><?php echo $product_count; ?></p>
            <a href="view_product.php">View Products</a>
        </div>
        
        <div class="action-card">
            <h3>📁 Categories</h3>
            <p class="stat-number"><?php echo $category_count; ?></p>
            <a href="view_category.php">View Categories</a>
        </div>
        
        <div class="action-card">
            <h3>📋 Orders</h3>
            <p class="stat-number"><?php echo $order_count; ?></p>
            <a href="#">View Orders</a>
        </div>
    </div>
</div>

<style>
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }
    
    .action-card {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.3s;
    }
    
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    
    .action-card h3 {
        color: #667eea;
        margin-bottom: 10px;
    }
    
    .action-card p {
        color: #666;
        margin-bottom: 10px;
    }
    
    .action-card .stat-number {
        font-size: 36px;
        font-weight: bold;
        color: #667eea;
        margin: 10px 0;
    }
    
    .action-card a {
        display: inline-block;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }
    
    .action-card a:hover {
        color: #764ba2;
    }
</style>

<?php include "admin_footer.php"; ?>


