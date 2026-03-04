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
            width: calc(100% - 260px);
            right: 0;
            margin-left: 10px;
            box-sizing: border-box;
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
        }
        
        .admin-content {
            padding: 30px;
        }
    </style>
</head>
<body>

<main class="admin-main">
        <header class="admin-header">
            <h1><?php echo $page_title; ?></h1>
            <div class="admin-header-actions">
                <a href="profilepage.php" class="btn btn-secondary btn-sm">Profile</a>
                <a href="logout.php" class="btn btn-primary btn-sm">Logout</a>
            </div>
        </header>

<div class="admin-content">

