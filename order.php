<?php 
$page_title = "My Orders";
include "header.php"; 
?>

<?php
include "admin/dbconnect.php";
include "user_session_page.php";

$user_id = $session_user_id;

$get_order_details = "SELECT o.order_num, o.order_date, o.order_status, o.order_id, o.deleted,
                     SUM(od.total_price) as grand_total
                     FROM order_tbl o
                     JOIN order_details_tbl od ON o.order_id = od.order_id
                     WHERE o.user_id = '$user_id'
                     GROUP BY o.order_num, o.order_date, o.order_status, o.order_id, o.deleted";
$get_order_details_res = $conn->query($get_order_details);
?>

<div class="orders-container">
    <h1>My Orders</h1>
    <a href="user_homepage.php" class="btn btn-secondary mb-2">Back to Home</a>

    <?php if($get_order_details_res && $get_order_details_res->num_rows > 0): ?>
        <table class="table mt-2">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>Order Number</th>
                    <th>Order Date</th>
                    <th>Order Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sno = 1;
                while($row = mysqli_fetch_array($get_order_details_res)):
                    $order_num = $row['order_num'];
                    $order_date = $row['order_date'];
                    $order_status = $row['order_status'];
                    $grand_total = $row['grand_total'];
                    $order_id = $row['order_id'];
                ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                    <td><?php echo htmlspecialchars($order_num); ?></td>
                    <td><?php echo htmlspecialchars($order_date); ?></td>
                    <td>
                        <span class="order-status <?php echo strtolower($order_status); ?>">
                            <?php echo htmlspecialchars($order_status); ?>
                        </span>
                    </td>
                    <td>Rs. <?php echo $grand_total; ?></td>
                    <td><button type="button" class="btn btn-primary btn-sm view-details-btn" data-order-id="<?php echo $order_id; ?>">View Details</button></td>
                </tr>
                <?php
                $sno++;
                endwhile;
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No orders found.</div>
    <?php endif; ?>
</div>

<div id="productDetailsModal" class="modal">
    <div class="modal-content" style="width: 600px; max-height: 80vh; overflow-y: auto;">
        <h3>Order Details</h3>
        <div id="productDetailsContent"></div>
        <button type="button" onclick="closeProductModal()" class="btn btn-secondary" style="margin-top: 20px;">Close</button>
    </div>
</div>

<div id="reasonModal" class="modal">
    <div class="modal-content">
        <h3>Select Cancellation Reason</h3>
        <form id="cancelReasonForm">
            <input type="hidden" id="cancelProductId" name="product_id">
            <input type="hidden" id="cancelOrderId" name="order_id">
            
            <div class="reason-option">
                <input type="radio" id="reason1" name="reason" value="Product damaged during delivery" required>
                <label for="reason1">Product damaged during delivery</label>
            </div>
            
            <div class="reason-option">
                <input type="radio" id="reason2" name="reason" value="Wrong product received">
                <label for="reason2">Wrong product received</label>
            </div>
            
            <div class="reason-option">
                <input type="radio" id="reason3" name="reason" value="Product not as described">
                <label for="reason3">Product not as described</label>
            </div>
            
            <div class="reason-option">
                <input type="radio" id="reason4" name="reason" value="Changed my mind">
                <label for="reason4">Changed my mind</label>
            </div>
            
            <div class="reason-option">
                <input type="radio" id="reason5" name="reason" value="Found better price elsewhere">
                <label for="reason5">Found better price elsewhere</label>
            </div>
            
            <div class="reason-option">
                <input type="radio" id="reason6" name="reason" value="Other">
                <label for="reason6">Other</label>
            </div>
            
            <div class="confirm-modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="closeReasonModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="showConfirmModal()">Next</button>
            </div>
        </form>
    </div>
</div>

<div id="confirmModal" class="modal">
    <div class="modal-content">
        <h3>Confirm Cancellation</h3>
        <p>Are you sure you want to cancel this product?</p>
        <p><strong>Reason:</strong> <span id="confirmReason"></span></p>
        <div class="confirm-modal-buttons">
            <button type="button" class="btn btn-secondary" onclick="closeConfirmModal()">Cancel</button>
            <button type="button" class="btn btn-success" onclick="submitCancellation()">OK</button>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).on('click', '.view-details-btn', function() {
    var orderId = $(this).data('order-id');
    loadOrderDetails(orderId);
});

function loadOrderDetails(orderId) {
    $.ajax({
        method: "POST",
        url: "get_order_details.php",
        data: { order_id: orderId },
        success: function(result) {
            $('#productDetailsContent').html(result);
            $('#productDetailsModal').show();
        }
    });
}

function closeProductModal() {
    $('#productDetailsModal').hide();
}

function openCancelModal(productId, orderId) {
    $('#cancelProductId').val(productId);
    $('#cancelOrderId').val(orderId);
    $('#reasonModal').show();
}

function closeReasonModal() {
    $('#reasonModal').hide();
    $('#cancelReasonForm')[0].reset();
}

function showConfirmModal() {
    var reason = $('input[name="reason"]:checked').val();
    if (!reason) {
        alert('Please select a reason for cancellation');
        return;
    }
    $('#confirmReason').text(reason);
    $('#reasonModal').hide();
    $('#confirmModal').show();
}

function closeConfirmModal() {
    $('#confirmModal').hide();
    $('#reasonModal').show();
}

function submitCancellation() {
    var productId = $('#cancelProductId').val();
    var orderId = $('#cancelOrderId').val();
    var reason = $('input[name="reason"]:checked').val();

    $.ajax({
        method: "POST",
        url: "cancel_product_process.php",
        data: { 
            product_id: productId,
            order_id: orderId,
            reason: reason
        },
        success: function(result) {
            var response = result.trim(); 

            if (response === 'success') {
                alert('Product cancelled successfully!');
                $('#confirmModal').hide();
                $('#productDetailsModal').hide();
                
                $('#cancel-btn-' + productId).prop('disabled', true);
                $('#cancel-btn-' + productId).addClass('cancel-btn-red');
                $('#cancel-btn-' + productId).text('Cancelled');
            }
            else if(response === 'already_cancelled'){
                alert('Product already cancelled!');
                $('#confirmModal').hide();
                $('#productDetailsModal').hide();
            }
            else {
                alert('Error: ' + response);
            }
        }
    });
}

window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = "none";
    }
}
</script>

<?php include "footer.php"; ?>

