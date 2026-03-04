<?php
/**
 * =====================================================
 * CHATBOT BACKEND API - Enhanced Version
 * =====================================================
 * File: chatbot_backend.php
 * Purpose: Process user messages and return chatbot responses
 * 
 * Features:
 * - FAQ database search
 * - Default responses for common queries
 * - Chat history storage
 * - Security (SQL injection protection)
 * - Error handling
 * 
 * =====================================================
 */

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "ecommerce_db";

$conn = mysqli_connect($hostname, $db_username, $db_password, $db_name);

if (!$conn) {
    echo json_encode([
        'response' => 'Sorry, service unavailable. Please try again later.',
        'status' => 'error'
    ]);
    exit;
}

/**
 * Sanitize user input to prevent XSS attacks
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Get default responses when no FAQ match is found
 */
function get_default_response($search_term) {
    $responses = [
        'hello' => "Hello! 👋 Welcome to our shop! How can I help you today?",
        'hi' => "Hi there! 😊 How can I assist you today?",
        'hey' => "Hey! 👋 What's up? How can I help you?",
        
        'help' => "I can help you with:
📦 Shipping & Delivery times
🔄 Returns & Refunds
💳 Payment Methods
📋 Order Tracking
🏷️ Discounts & Offers
❓ General Questions

Just ask me anything!",
        
        'shipping' => "🚚 Shipping Information:
• Standard delivery: 3-7 business days
• Express delivery: 1-3 business days
• Free shipping on orders above ₹500
• Shipping charge: ₹50 for orders below ₹500",
        
        'delivery' => "📦 Delivery Details:
• Standard delivery: 3-7 business days
• Express delivery: 1-3 business days
• We deliver all across India
• You'll receive tracking info via SMS/Email",
        
        'return' => "🔄 Return Policy:
• Return within 7 days of delivery
• Product must be unused & in original packaging
• Full refund or exchange available
• Easy return process via Order Details page",
        
        'refund' => "💰 Refund Policy:
• Refunds processed within 5-7 business days
• Amount credited to original payment method
• For COD, refund to bank account
• Check Order Details for return status",
        
        'payment' => "💳 Payment Methods:
• Credit/Debit Cards (Visa, Mastercard, RuPay)
• UPI (Google Pay, PhonePe, Paytm)
• Net Banking
• Wallets (Paytm, PhonePe, GPay)
• Cash on Delivery (COD)",
        
        'cod' => "💵 Cash on Delivery:
• Available for all orders
• Pay ₹100 advance booking amount
• Rest payment on delivery
• No extra charges for COD",
        
        'order' => "📋 Order Information:
• Go to Order Details page to view orders
• Click on order to see full details
• Track order status from same page
• Contact support for order issues",
        
        'track' => "📍 Track Your Order:
• Go to Order Details page
• Click on the order you want to track
• View current status (Pending, Processing, Shipped, Delivered)
• Call support for detailed tracking",
        
        'cancel' => "❌ Cancel Order:
• Go to Order Details page
• Find your order
• Click Cancel (only if status is 'Pending')
• Refund will be processed within 5-7 days",
        
        'register' => "📝 Registration:
• Click 'Register' on the login page
• Fill in your details (name, email, password)
• Submit the form
• Start shopping immediately after login!",
        
        'login' => "🔐 Login:
• Go to Login page
• Enter your username/email and password
• Click Login
• Forgot password? Use 'Forgot Password' link",
        
        'profile' => "👤 Profile Management:
• Click 'Profile' in the menu
• View/Update your personal details
• Add or edit shipping addresses
• Change password anytime",
        
        'address' => "📍 Shipping Address:
• Go to Profile > Add Shipping Address
• Fill in: Name, Full Address, City, District, Pincode, Phone
• Multiple addresses supported
• Select address during checkout",
        
        'product' => "🛍️ Our Products:
• Browse products on homepage
• Use search bar to find specific items
• Click 'Add to Cart' to purchase
• View cart to see selected items",
        
        'search' => "🔍 Search Products:
• Use the search bar on homepage
• Enter product name or keyword
• Browse matching results
• Add desired items to cart",
        
        'price' => "💰 Product Prices:
• Prices shown on each product card
• Discounts applied at checkout
• Add to cart to see final price
• Free shipping on orders above ₹500",
        
        'cart' => "🛒 Shopping Cart:
• Add products from homepage
• View cart by clicking 'View Cart'
• Increase/decrease quantity
• Proceed to checkout when ready",
        
        'checkout' => "💳 Checkout Process:
1) Go to Cart
2) Select shipping address
3) Choose payment method
4) Click 'Proceed to Pay'
5) Complete payment
6) Order confirmed!",
        
        'discount' => "🏷️ Discounts & Offers:
• Free shipping on orders above ₹500
• Regular seasonal sales
• Subscribe for exclusive deals
• Follow us on social media for offers",
        
        'coupon' => "🎫 Coupon Codes:
• Check our homepage for current offers
• Subscribe to newsletter for exclusive codes
• Enter coupon at checkout
• Discount applied to total",
        
        'contact' => "📞 Contact Support:
• Email: support@ecommerce.com
• Phone: 1800-XXX-XXXX
• Hours: Mon-Sat, 9AM-6PM
• We respond within 24 hours",
        
        'support' => "🆘 Need Help?
• Email: support@ecommerce.com
• Phone: 1800-XXX-XXXX
• Chat with us anytime!
• We're happy to assist you",
        
        'thanks' => "You're welcome! 😊 Is there anything else I can help you with?",
        'thank' => "You're welcome! 😊 Feel free to ask if you have more questions!",
        
        'bye' => "Goodbye! 👋 Thank you for shopping with us. Come back soon!",
        'goodbye' => "Take care! 👋 Visit us again for great deals!",
        
        'about' => "🏪 About Us:
We are your trusted online shopping destination offering quality products at great prices with excellent customer service.",
        
        'timing' => "⏰ Business Hours:
• Online: 24/7
• Customer Support: Mon-Sat, 9AM-6PM
• Orders processed within 24 hours",
    ];

    foreach ($responses as $key => $value) {
        if (strpos($search_term, $key) !== false) {
            return $value;
        }
    }

    return "I'm sorry, I didn't understand that. 😕

Try asking about:
• 📦 Shipping & Delivery
• 🔄 Returns & Refunds
• 💳 Payment Methods
• 📋 Order Tracking
• 🏷️ Discounts & Offers

Or contact us: support@ecommerce.com | 1800-XXX-XXXX";
}

/**
 * Search FAQ database for matching response
 */
function search_faq($conn, $search_term) {
    $query = "SELECT answer FROM chatbot_faq 
              WHERE LOWER(keywords) LIKE ? 
              OR LOWER(question) LIKE ? 
              OR LOWER(answer) LIKE ?
              LIMIT 1";
    
    $stmt = $conn->prepare($query);
    $search_pattern = "%" . $search_term . "%";
    $stmt->bind_param("sss", $search_pattern, $search_pattern, $search_pattern);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['answer'];
    }
    
    return null;
}

/**
 * Save chat to history
 */
function save_history($conn, $user_message, $response) {
    $session_id = session_id();
    $insert = "INSERT INTO chatbot_history (session_id, user_message, bot_response) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("sss", $session_id, $user_message, $response);
    $stmt->execute();
}

// ============================================
// MAIN PROCESSING
// ============================================

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'response' => 'Invalid request method.',
            'status' => 'error'
        ]);
        exit;
    }

    $user_message = isset($_POST['message']) ? $_POST['message'] : '';

    if (empty($user_message)) {
        echo json_encode([
            'response' => 'Please enter a message to chat with us!',
            'status' => 'error'
        ]);
        exit;
    }

    $user_message = sanitize_input($user_message);

    if (strlen($user_message) > 500) {
        echo json_encode([
            'response' => 'Message is too long. Please keep it under 500 characters.',
            'status' => 'error'
        ]);
        exit;
    }

    $search_term = strtolower($user_message);

    $response = search_faq($conn, $search_term);

    if ($response === null) {
        $response = get_default_response($search_term);
    }

    save_history($conn, $user_message, $response);

    echo json_encode([
        'response' => $response,
        'status' => 'success',
        'timestamp' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    echo json_encode([
        'response' => 'Oops! Something went wrong. Please try again.',
        'status' => 'error'
    ]);
}

mysqli_close($conn);
?>

