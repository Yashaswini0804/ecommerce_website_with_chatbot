<?php 
$page_title = "Add Shipping Address";
include "header.php"; 
?>

<?php
if(isset($_GET['status']))
{
    if($_GET['status']=="success")
    {
        echo '<div class="alert alert-success">Address added successfully!</div>';
    }
    else{
        echo '<div class="alert alert-error">Error in adding address</div>';
    }
}
?>

<div class="card" style="max-width: 600px; margin: 20px auto;">
    <div class="card-header">
        <h3>Your Shipping Details</h3>
    </div>
    <div class="card-body">
        <form action="shipping_address_prosess.php" method="post" id="addressform">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" name="city" id="city" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="district">District:</label>
                <input type="text" name="district" id="district" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="pincode">Zip Code:</label>
                <input type="text" name="pincode" id="pincode" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" id="phonenumber" class="form-control" required>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <button type="submit" class="btn btn-primary">Submit Address</button>
                <a href="cart.php" class="btn btn-secondary">View Cart</a>
            </div>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

