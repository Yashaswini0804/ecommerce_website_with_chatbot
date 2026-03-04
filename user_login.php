<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Login - MyShop";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    <h2>Login to MyShop</h2>
    
    <?php if($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form action="user_login_process.php" method="post">
        <div class="form-group">
            <div id="user_name_error" class="error-message"></div>
            <label for="user_name">User Name:</label>
            <input type="text" name="user_name" id="user_name" class="form-control">
        </div>
        
        <div class="form-group">
            <div id="user_password_error" class="error-message"></div>
            <label for="user_password">Password:</label>
            <input type="password" name="user_password" id="user_password" class="form-control">
        </div>
        
        <button type="submit" value="submit" name="submit" class="btn btn-primary" onclick="return validateForm()">Login</button>
        
        <p>Don't have an account? <a href="user_register.php">Register here!</a></p>
    </form>
</div>

<script>
function validateForm()
{
    var username = document.getElementById("user_name").value;
    var password = document.getElementById("user_password").value;
    var isValid = true;
    
    if(username === "")
    {
        document.getElementById("user_name_error").innerHTML = "Please enter user name";
        isValid = false;
    }
    else
    {
        document.getElementById("user_name_error").innerHTML = "";
    }
    
    if(password === "")
    {
        document.getElementById("user_password_error").innerHTML = "Please enter password";
        isValid = false;
    }
    else
    {
        document.getElementById("user_password_error").innerHTML = "";
    }
    
    return isValid;
}
</script>

</body>
</html>

