<?php
/**
 * Chatbot Processing Script
 * Handles user messages and returns appropriate responses
 */

include "admin/dbconnect.php";

// Get user message
$user_message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($user_message)) {
    echo json_encode(['response' => 'Please enter a message.']);
    exit;
}

$search_term = strtolower($user_message);

$query = "SELECT answer FROM chatbot_faq WHERE LOWER(keywords) LIKE ? OR LOWER(question) LIKE ? OR LOWER(answer) LIKE ?";
$stmt = $conn->prepare($query);
$search_pattern = "%" . $search_term . "%";
$stmt->bind_param("sss", $search_pattern, $search_pattern, $search_pattern);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = $row['answer'];
} else {
    $response = get_default_response($search_term);
}

// Optional: Save chat history
$session_id = session_id();
$insert_history = "INSERT INTO chatbot_history (session_id, user_message, bot_response) VALUES (?, ?, ?)";
$hist_stmt = $conn->prepare($insert_history);
$hist_stmt->bind_param("sss", $session_id, $user_message, $response);
$hist_stmt->execute();

echo json_encode(['response' => $response]);

$conn->close();

function get_default_response($search_term) {
    $default_responses = [
        'hello' => 'Hello! 👋 How can I help you today? You can ask about:\n• Shipping & Delivery\n• Return & Refund\n• Payment Methods\n• Order Tracking\n• Discounts & Offers',
        'hi' => 'Hi there! 😊 How can I assist you today?',
        'help' => 'I can help you with:\n📦 Shipping & Delivery\n🔄 Returns & Refunds\n💳 Payment Methods\n📋 Order Tracking\n🏷️ Discounts & Offers\n💬 General Questions',
        'thanks' => 'You\'re welcome! 😊 Is there anything else I can help you with?',
        'thank you' => 'You\'re welcome! 😊 Is there anything else I can help you with?',
        'bye' => 'Goodbye! 👋 Thank you for visiting. Feel free to chat anytime you need help!',
        'price' => 'You can view product prices on our homepage. Simply browse products and add them to cart to see the final price including any discounts!',
        'cart' => 'To add products to cart: 1) Browse products on homepage 2) Click "Add to Cart" 3) Go to Cart page to checkout',
        'checkout' => 'To checkout: Go to Cart > Select Shipping Address > Click "Proceed to Pay" > Complete payment',
        'register signup' => 'To register: Click Register on login page > Fill your details > Submit. You can then login and start shopping!',
        'login' => 'If you have an account, go to Login page > Enter username & password > Click Login. New users can register first.',
    ];

    foreach ($default_responses as $key => $value) {
        if (strpos($search_term, $key) !== false) {
            return $value;
        }
    }

    return "I'm sorry, I didn't understand that. 😕\n\nTry asking about:\n• Shipping & Delivery times\n• Return & Refund policy\n• Payment methods\n• How to track order\n• Available discounts\n\nOr call our support: 1800-XXX-XXXX";
}
?>

