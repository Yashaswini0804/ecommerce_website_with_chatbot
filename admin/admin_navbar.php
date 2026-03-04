<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "session_page.php";
$page_title = isset($page_title) ? $page_title : 'Admin Panel';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - MyShop Admin</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .admin-sidebar {
            width: 260px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .admin-sidebar-header {
            padding: 25px 20px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .admin-sidebar-header h2 {
            margin: 0;
            font-size: 22px;
            color: #667eea;
        }
        
        .admin-sidebar-header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #bdc3c7;
        }
        
        .admin-menu {
            list-style: none;
            padding: 15px 0;
            margin: 0;
        }
        
        .admin-menu-item {
            padding: 0;
        }
        
        .admin-menu-link {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .admin-menu-link:hover {
            background: rgba(102, 126, 234, 0.2);
            border-left-color: #667eea;
            color: white;
        }
        
        .admin-menu-link.active {
            background: rgba(102, 126, 234, 0.3);
            border-left-color: #667eea;
            color: white;
        }
        
        .admin-menu-icon {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        .admin-menu-section {
            padding: 15px 20px 8px;
            font-size: 11px;
            text-transform: uppercase;
            color: #7f8c8d;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .admin-main {
            flex: 1;
            margin-left: 260px;
            padding: 0;
            background: #f5f5f5;
        }
        
        .admin-header {
            background: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .admin-header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .admin-header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-left :10px;
            margin-right:0;
        }
        
        .admin-content {
            padding: 30px;
        }
        
        .admin-breadcrumb {
            padding: 15px 30px;
            background: white;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            color: #666;
        }
        
        .admin-breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        
        .admin-breadcrumb a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <h2>🛒Bhuvi</h2>
            <p>Admin Dashboard</p>
        </div>
        
        <ul class="admin-menu">
            <li class="admin-menu-section">Main</li>
            <li class="admin-menu-item">
                <a href="homepage.php" class="admin-menu-link">
                    <span class="admin-menu-icon">📊</span>
                    Dashboard
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="profilepage.php" class="admin-menu-link">
                    <span class="admin-menu-icon">👤</span>
                    Profile
                </a>
            </li>
            
            <li class="admin-menu-section">Products</li>
            <li class="admin-menu-item">
                <a href="add_product.php" class="admin-menu-link">
                    <span class="admin-menu-icon">➕</span>
                    Add Product
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="view_product.php" class="admin-menu-link">
                    <span class="admin-menu-icon">📋</span>
                    View Products
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="add_product_image.php" class="admin-menu-link">
                    <span class="admin-menu-icon">🖼️</span>
                    Add Product Image
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="view_product_image.php" class="admin-menu-link">
                    <span class="admin-menu-icon">🖼️</span>
                    View Product Images
                </a>
            </li>
            
            <li class="admin-menu-section">Categories</li>
            <li class="admin-menu-item">
                <a href="add_category.php" class="admin-menu-link">
                    <span class="admin-menu-icon">➕</span>
                    Add Category
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="view_category.php" class="admin-menu-link">
                    <span class="admin-menu-icon">📋</span>
                    View Categories
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="add_subcategory.php" class="admin-menu-link">
                    <span class="admin-menu-icon">➕</span>
                    Add Subcategory
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="view_subcategory.php" class="admin-menu-link">
                    <span class="admin-menu-icon">📋</span>
                    View Subcategories
                </a>
            </li>
            
            <li class="admin-menu-section">Support</li>
            <li class="admin-menu-item">
                <a href="chatbot_faq.php" class="admin-menu-link">
                    <span class="admin-menu-icon">💬</span>
                    Chatbot FAQ
                </a>
            </li>
            
            <li class="admin-menu-section">Account</li>
            <li class="admin-menu-item">
                <a href="logout.php" class="admin-menu-link">
                    <span class="admin-menu-icon">🚪</span>
                    Logout
                </a>
            </li>
        </ul>
    </aside>
    
   

