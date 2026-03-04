
<?php 
session_start();
$page_title = "Admin Login";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<?php
$error = "";
if(isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<div class="auth-container">
    <h2>Admin Login</h2>
    
    <?php if($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form action="login_process.php" method="post">
        <div class="form-group">
            <div id="user_name_error" class="error-message"></div>
            <label for="user_name">User Name:</label>
            <input type="text" name="user_name" id="user_name" class="form-control">
        </div>
        
        <div class="form-group">
            <div id="user_password_error" class="error-message"></div>
            <label for="upassword">Password:</label>
            <input type="password" name="upassword" id="upassword" class="form-control">
        </div>
        
        <button type="submit" value="submit" name="submit" class="btn btn-primary">Login</button>
        
        <p>Don't have an account? <a href="register.php">Register here!</a></p>
    </form>
</div>

</body>
</html>


