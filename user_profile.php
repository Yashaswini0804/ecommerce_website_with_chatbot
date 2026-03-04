<?php 
$page_title = "Profile Page";
include "header.php"; 
?>

<?php
include "admin/dbconnect.php";
include "user_session_page.php";

if(isset($_GET["status"]))
{
    if($_GET["status"] == "successupdate")
    {
        echo '<div class="alert alert-success">Profile updated successfully!!</div>';
    }
    else if($_GET["status"] == "fail")
    {
        echo '<div class="alert alert-error">Profile update failed!</div>';
    }
}

$userid = "";
$useremail = "";
$phonenumber = "";
$username = "";
$profile_img = "";

$get_user_tbl = "SELECT user_id, user_name, user_email, profile_img, user_phonenumber 
                 FROM user_tbl 
                 WHERE user_id = '$session_user_id' AND deleted='0'";
$get_user_res = $conn->query($get_user_tbl);

if($get_user_res->num_rows > 0)
{
    $row = mysqli_fetch_array($get_user_res);
    {
        $userid = $row['user_id'];
        $useremail = $row['user_email'];
        $phonenumber = $row['user_phonenumber'];
        $username = $row['user_name'];
        $profile_img = $row['profile_img'];
    }
}
?>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php echo strtoupper(substr($username, 0, 1)); ?>
        </div>
        <div class="profile-info">
            <h3><?php echo htmlspecialchars($username); ?></h3>
            <p><?php echo htmlspecialchars($useremail); ?></p>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <h3>Update Profile</h3>
        </div>
        <div class="card-body">
            <form action="update_profile.php" method="post">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userid; ?>">
                
                <div class="form-group">
                    <label for="user_name">User Name:</label>
                    <input type="text" name="user_name" id="user_name" value="<?php echo htmlspecialchars($username); ?>" onblur="uniquename()" class="form-control">
                    <div id="user_name_error" class="error-message"></div>
                </div>
                
                <div class="form-group">
                    <label for="user_email">Email:</label>
                    <input type="email" name="user_email" id="user_email" value="<?php echo htmlspecialchars($useremail); ?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="user_phonenumber">Phone Number:</label>
                    <input type="tel" name="user_phonenumber" id="user_phonenumber" value="<?php echo htmlspecialchars($phonenumber); ?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="profile_img">Profile Image:</label>
                    <input type="file" name="profile_img" id="profile_img" class="form-control">
                </div>
                
                <?php if ($profile_img): ?>
                <div class="form-group">
                    <label>Current Image:</label>
                    <div>
                        <img src="uploads/<?php echo htmlspecialchars($profile_img); ?>" width="100" alt="Profile" class="profile-thumbnail">
                    </div>
                </div>
                <?php endif; ?>
                
                <button type="submit" value="update" name="update" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <h3>Change Password</h3>
        </div>
        <div class="card-body">
            <form action="update_user_password.php" method="POST">
                <div id="password_error"></div>
                
                <div class="form-group">
                    <label for="oldpassword">Old Password:</label>
                    <input type="password" name="oldpassword" id="oldpassword" onblur="validpassword()" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="user_password">Enter New Password:</label>
                    <input type="password" name="user_password" id="user_password" disabled onkeyup="checkpassword()" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="conpassword">Confirm Password:</label>
                    <input type="password" name="conpassword" id="conpassword" disabled onkeyup="checkpassword()" class="form-control">
                </div>
                
                <button type="submit" name="updatepassword" id="updatepassword" disabled class="btn btn-primary">Update Password</button>
                <a href="user_homepage.php" class="btn btn-secondary">Home Page</a>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
function uniquename()
{
    var username = document.getElementById("user_name").value;
    var user_id = document.getElementById("user_id").value;
    
    $.ajax({
        method: "POST",
        url: "ajax_check_user_profile.php",
        data: {user_name: username, user_id: user_id},
        success: function(result) {
            if(result.trim() == "unique_name")
            {
                document.getElementById("user_password").focus();
                document.getElementById("user_name_error").innerHTML = "";
            }
            else if(result.trim() == "duplicate_name")
            {
                document.getElementById("user_name_error").innerHTML = "<font color='red' size='1'>Please enter unique user name</font>";
                document.getElementById("user_name").focus();
                document.getElementById("user_name").value = "";
            }
        }
    });
}

function validpassword()
{
    var oldpassword = document.getElementById('oldpassword').value;
    var newpassword = document.getElementById('user_password');
    var conpassword = document.getElementById('conpassword');
    var updatebtn = document.getElementById("updatepassword");
    
    $.ajax({
        method: "POST",
        url: "ajax_check_old_user_password.php",
        data: {oldpassword: oldpassword},
        success: function(result)
        {
            if(result.trim() == "valid")
            {
                newpassword.disabled = false;
                conpassword.disabled = false;
                document.getElementById("password_error").innerHTML = "";
            }
            else if(result.trim() == "invalid")
            {
                newpassword.disabled = true;
                conpassword.disabled = true;
                updatebtn.disabled = true;
                document.getElementById("password_error").innerHTML = "<font color='red' size='2'>Invalid old password!</font>";
            }
        }
    });
}

function checkpassword()
{
    var password = document.getElementById('user_password').value;
    var confirmpassword = document.getElementById('conpassword').value;
    var updatebtn = document.getElementById("updatepassword");

    if(password === confirmpassword && password != "")
    {
        updatebtn.disabled = false;
    }
    else
    {
        updatebtn.disabled = true;
    }
}
</script>

<?php include "footer.php"; ?>

