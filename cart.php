<?php 
$page_title = "Your Cart";
include "header.php"; 
?>

<?php
include "user_session_page.php";
include "admin/dbconnect.php";
$user_id = $session_user_id;

if(isset($_GET['status']))
{
    if($_GET['status']=="success")
    {
        echo '<div class="alert alert-success">Order Confirmed. Check your order in order page.</div>';
    }
    else
    {
        echo '<div class="alert alert-error">Order failed. Check your network.</div>';
    }
}

$cart_query = "SELECT c.cart_id, c.quantity, p.product_name, p.selling_price, p.product_id
               FROM cart_tbl c
               JOIN product_tbl p ON c.product_id = p.product_id
               WHERE c.user_id = '$user_id' AND p.deleted = '0'";
$cart_result = $conn->query($cart_query);

$total = 0;

$address_qry = "SELECT address_id, name, address, city, pincode, district, phonenumber 
                FROM shipping_address_tbl 
                WHERE user_id='$session_user_id'";
$address_res = $conn->query($address_qry);
?>

<div class="cart-container">
    <h1>Your Shopping Cart</h1>
    <div class="cart-nav-links">
        <a href="user_homepage.php" class="btn btn-secondary">Continue Shopping</a>
        <a href="add_shipping_address.php" class="btn btn-secondary">Add Address</a>
        <a href="user_profile.php" class="btn btn-secondary">Profile</a>
    </div>

    <?php if ($cart_result && $cart_result->num_rows > 0): ?>
        <form action="payment_module.php" method="post" id="check_out">
            <div class="form-group">
                <label for="shipping_address">Select Shipping Address:</label>
                <select name="shipping_address" id="shipping_address" class="form-control" required>
                    <option value="">-- Select Shipping Address --</option>
                    <?php if($address_res && $address_res->num_rows > 0): ?>
                        <?php while($address=mysqli_fetch_array($address_res)): ?>
                            <?php
                            $full_address = $address['name'] . ", " 
                                          . $address['address'] . ", " 
                                          . $address['city'] . ", "
                                          . $address['district'] . ", "
                                          . $address['pincode'] . ", "
                                          . $address['phonenumber'];      
                            ?>
                            <option value="<?php echo htmlspecialchars($full_address); ?>"><?php echo htmlspecialchars($full_address); ?></option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">No addresses found. Please add one.</option>
                    <?php endif; ?>
                </select>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $cart_result->fetch_array()): ?>
                        <?php 
                        $product_name = $item['product_name'];
                        $selling_price = $item['selling_price'];
                        $cart_id = $item['cart_id'];
                        $quantity = $item['quantity'];
                        $product_id = $item['product_id'];

                        $total += $selling_price * $quantity;
                        ?>
                        <tr id="row-<?php echo $cart_id; ?>">
                            <td><?php echo htmlspecialchars($product_name); ?></td>
                            <td>Rs. <?php echo $selling_price; ?></td>
                            <td>
                                <div class="cart-item-quantity">
                                    <button type="button" name="decrease" value="<?php echo $cart_id; ?>" class="cart-quantity-btn" onclick="add_remove('<?php echo $cart_id?>','<?php echo $product_id?>','remove')">-</button>
                                    <input type="text" id="quantity<?php echo $cart_id; ?>" name="quantity[<?php echo $cart_id; ?>]" value="<?php echo $quantity; ?>" min="1" class="form-control" readonly style="width: 60px;">
                                    <button type="button" name="increase" value="<?php echo $cart_id; ?>" class="cart-quantity-btn" onclick="add_remove('<?php echo $cart_id?>','<?php echo $product_id?>','add')">+</button>
                                </div>
                            </td>
                            <td>Rs.<span id="total<?php echo $cart_id; ?>"><?php echo $selling_price * $quantity; ?></span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="3">Grand Total</td>
                        <td>Rs.<span id="grand_total"><?php echo $total; ?></span></td>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="grand_total" id="grand_total_input" value="<?php echo $total; ?>">
            <div class="cart-total">
                <button type="submit" id="proceedbtn" class="btn btn-primary btn-lg">Proceed To Pay ₹ <?php echo $total ?></button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-info">Your cart is empty. <a href="user_homepage.php" class="btn btn-primary">Start shopping</a></div>
    <?php endif; ?>
    
    <?php $conn->close(); ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
function add_remove(cart_id, product_id, type)
{  
    $.ajax({
        method: "POST",
        url: "ajax_update_chart.php",
        data: {
            cart_id: cart_id,
            product_id: product_id,
            type: type
        },
        success: function(result) 
        {
            var data = JSON.parse(result); 

            if(data.status === "updated") {
                document.getElementById('quantity' + cart_id).value = data.new_quantity;
                document.getElementById('total' + cart_id).innerText = data.new_total;
                document.getElementById('grand_total').innerText = data.grand_total;
                document.getElementById('proceedbtn').innerText = 'Proceed To Pay ₹ ' + data.grand_total;
            } else if(data.status === "item_removed") {
                document.getElementById('row-' + cart_id).style.display = 'none';
                document.getElementById('grand_total').innerText = data.grand_total;
                document.getElementById('grand_total_input').value = data.grand_total;
                document.getElementById('proceedbtn').innerText = 'Proceed To Pay ₹ ' + data.grand_total;
            } else {
                alert("Error: " + data.message);
            }
        }
    });
}
</script>

<?php include "footer.php"; ?>

