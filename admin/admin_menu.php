
<?php 
$page_title = "Admin Menu";
include "admin_navbar.php"; 
include "admin_header.php";
?>

<div class="admin-content">
    <div class="card">
        <div class="card-header" style="color:white">
            <h3><a href="homepage.php">Admin Menu</a></h3>
        </div>
        <div class="card-body">
            <div class="menu-grid">
                <a href="add_category.php" class="menu-item">
                    <span class="menu-icon">📁</span>
                    <span class="menu-text">Add Category</span>
                </a>
                <a href="view_category.php" class="menu-item">
                    <span class="menu-icon">📋</span>
                    <span class="menu-text">View Category</span>
                </a>
                <a href="add_subcategory.php" class="menu-item">
                    <span class="menu-icon">📁</span>
                    <span class="menu-text">Add Subcategory</span>
                </a>
                <a href="view_subcategory.php" class="menu-item">
                    <span class="menu-icon">📋</span>
                    <span class="menu-text">View Subcategory</span>
                </a>
                <a href="add_product.php" class="menu-item">
                    <span class="menu-icon">➕</span>
                    <span class="menu-text">Add Product</span>
                </a>
                <a href="view_product.php" class="menu-item">
                    <span class="menu-icon">📋</span>
                    <span class="menu-text">View Product</span>
                </a>
                <a href="add_product_image.php" class="menu-item">
                    <span class="menu-icon">🖼️</span>
                    <span class="menu-text">Add Product Image</span>
                </a>
                <a href="view_product_image.php" class="menu-item">
                    <span class="menu-icon">🖼️</span>
                    <span class="menu-text">View Product Image</span>
                </a>
                <a href="homepage.php" class="menu-item">
                    <span class="menu-icon">🏠</span>
                    <span class="menu-text">Home</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
    .menu-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 30px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .menu-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .menu-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }
    .menu-text {
        font-size: 14px;
        font-weight: 600;
    }
</style>

<?php include "admin_footer.php"; ?>


