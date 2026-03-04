<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Register - MyShop";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <h2>Register at MyShop</h2>
    
    <?php
    if(isset($_GET["status"]))
    {
        if($_GET["status"] == "success")
        {
            echo '<div class="alert alert-success">Registered successfully!!</div>';
        }
        else
        {
            echo '<div class="alert alert-error">Register Failed</div>';
        }
    }
    ?>
    
    <form action="user_register_process.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="user_email">Email:</label>
            <input type="email" name="user_email" id="user_email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="user_phonenumber">Phone Number:</label>
            <input type="tel" name="user_phonenumber" id="user_phonenumber" class="form-control" required>
        </div>
        
        <div class="form-group">
            <div id="user_name_error" class="error-message"></div>
            <label for="user_name">User Name:</label>
            <input type="text" name="user_name" id="user_name" class="form-control" onblur="uniquename()" required>
        </div>
        
        <div class="form-group">
            <label for="user_password">Password:</label>
            <input type="password" name="user_password" id="user_password" class="form-control" onkeyup="checkpassword()" required>
        </div>
        
        <div class="form-group">
            <label for="conpassword">Confirm Password:</label>
            <input type="password" name="conpassword" id="conpassword" class="form-control" onkeyup="checkpassword()">
        </div>
        
        <div class="form-group">
            <label for="profile_img">Profile Image:</label>
            <input type="file" name="profile_img" id="profile_img" class="form-control" required>
        </div>
        
        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary" onchange="reset()">Reset</button>
        
        <p>Do you have an account? <a href="user_login.php">Login Here!</a></p>
    </form>
</div>

<script>
function reset()
{
    document.getElementById("user_name").value = "";
    document.getElementById("user_email").value = "";
    document.getElementById("user_phonenumber").value = "";
    document.getElementById("user_password").value = "";
    document.getElementById("conpassword").value = "";
    document.getElementById("profile_img").value = "";
}

function checkpassword()
{
    var user_password = document.getElementById("user_password").value;
    var conpassword = document.getElementById("conpassword").value;
    var submitbtn = document.getElementById("submit");
    
    if(user_password == conpassword && user_password != "")
    {
        submitbtn.disabled = false;
    }
    else
    {
        submitbtn.disabled = true;
    }
}

function uniquename()
{
    var username = document.getElementById("user_name").value;
    $.ajax({
        method: "POST",
        url: "ajax_check_username.php",
        data: {username: username},
        success : function(result)
        {
            if(result.trim() == "duplicatename")
            {
                document.getElementById("user_name_error").innerHTML = "<font color='red' size='1'>Please enter unique user name</font>";
                document.getElementById("user_name").focus();
                document.getElementById("user_name").value = "";
            }
            else if(result.trim() == "uniquename")
            {
                document.getElementById("user_name_error").innerHTML = "";
                document.getElementById("user_password").focus();
            }
        }
    });
}
</script>

</body>
</html>

