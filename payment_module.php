
<?php 
$page_title = "Payment - MyShop";
include "header.php"; 
?>

<?php
include "admin/dbconnect.php";
include "user_session_page.php"; 

$user_id = $session_user_id;
$grand_total = "";
$shipping_address = "";

if(isset($_POST['shipping_address']))
{
    $shipping_address = $_POST['shipping_address'];
}

if(isset($_POST['grand_total']))
{
    $grand_total = $_POST['grand_total'];
}
?>

<div class="checkout-container">
    <div class="checkout-form">
        <div class="card">
            <div class="card-header">
                <h3>Payment Details</h3>
            </div>
            <div class="card-body">
                <form action="payment_process.php" method="post">
                    <div class="form-group">
                        <label for="address">Shipping Address:</label>
                        <textarea name="shipping_address" id="address" class="form-control" rows="3" readonly><?php echo htmlspecialchars($shipping_address); ?></textarea>
                    </div>
                    
                    <input type="hidden" name="grand_total" value="<?php echo htmlspecialchars($grand_total); ?>">
                    
                    <div class="form-group">
                        <label for="payment_method">Select Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control" onchange="selection(this.value)" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="phonenumber">Phone Number</option>
                            <option value="Card">Credit/Debit Card</option>
                        </select>
                    </div>
                    
                    <div id="phoneform" class="payment-form" style="display: none;">
                        <div class="form-group">
                            <label for="phonenumber">Phone Number:</label>
                            <input type="text" name="phonenumber" class="form-control" placeholder="Enter phone number">
                        </div>
                        <button type="submit" class="btn btn-primary">Pay ₹<?php echo htmlspecialchars($grand_total); ?></button>
                    </div>
                    
                    <div id="cardForm" class="payment-form" style="display: none;">
                        <div class="form-group">
                            <label for="cardnumber">Card Number:</label>
                            <input type="text" name="cardnumber" class="form-control" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="form-group">
                            <label for="date">Expiry Date:</label>
                            <input type="date" name="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">CVV/Passcode:</label>
                            <input type="password" name="password" class="form-control" placeholder="***">
                        </div>
                        <button type="submit" class="btn btn-primary">Pay ₹<?php echo htmlspecialchars($grand_total); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="checkout-summary">
        <h3>Order Summary</h3>
        <div class="checkout-row">
            <span>Shipping Address:</span>
        </div>
        <div style="margin-bottom: 15px; font-size: 14px;">
            <?php echo nl2br(htmlspecialchars($shipping_address)); ?>
        </div>
        <div class="checkout-row total">
            <span>Total Amount:</span>
            <span>₹<?php echo htmlspecialchars($grand_total); ?></span>
        </div>
    </div>
</div>

<script>
function selection(value)
{
    var phoneform = document.getElementById("phoneform");
    var cardForm = document.getElementById("cardForm");
    
    phoneform.style.display = "none";
    cardForm.style.display = "none";

    if (value == "phonenumber") {
        phoneform.style.display = "block";
    } else if (value == "Card") {
        cardForm.style.display = "block";
    }
}
</script>

<?php include "footer.php"; ?>


