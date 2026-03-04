<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Ecommerce Website'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="user_homepage.php" class="navbar-brand">🛒Bhuvi</a>
        <ul class="navbar-menu">
            <li><a href="user_homepage.php">Home</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="order.php">Orders</a></li>
            <li><a href="user_profile.php">Profile</a></li>
            <li><a href="user_logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<main class="main-content">
    <div class="container">

