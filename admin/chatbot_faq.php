<?php
include "session_page.php";
include "dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot FAQ Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        h1 {
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            opacity: 0.8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #667eea;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .delete-btn {
            background: #dc3545;
            padding: 5px 10px;
            font-size: 14px;
        }
        .edit-btn {
            background: #28a745;
            padding: 5px 10px;
            font-size: 14px;
            margin-right: 5px;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="homepage.php" class="back-link">← Back to Admin Panel</a>
        <h1>🤖 Chatbot FAQ Management</h1>
        
        <?php
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
            $question = isset($_POST['question']) ? trim($_POST['question']) : '';
            $answer = isset($_POST['answer']) ? trim($_POST['answer']) : '';
            $category = isset($_POST['category']) ? trim($_POST['category']) : 'general';
            
            if (!empty($keywords) && !empty($answer)) {
                $stmt = $conn->prepare("INSERT INTO chatbot_faq (keywords, question, answer, category) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $keywords, $question, $answer, $category);
                
                if ($stmt->execute()) {
                    echo '<div class="message success">FAQ added successfully!</div>';
                } else {
                    echo '<div class="message error">Error adding FAQ. Please try again.</div>';
                }
            } else {
                echo '<div class="message error">Keywords and Answer are required!</div>';
            }
        }
        
        // Handle delete
        if (isset($_GET['delete'])) {
            $delete_id = $_GET['delete'];
            $stmt = $conn->prepare("DELETE FROM chatbot_faq WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            if ($stmt->execute()) {
                echo '<div class="message success">FAQ deleted successfully!</div>';
            }
        }
        ?>
        
        <h2>Add New FAQ</h2>
        <form method="POST">
            <div class="form-group">
                <label>Keywords (comma-separated):</label>
                <input type="text" name="keywords" placeholder="e.g., shipping, delivery, time" required>
            </div>
            <div class="form-group">
                <label>Question (optional):</label>
                <input type="text" name="question" placeholder="e.g., How long does shipping take?">
            </div>
            <div class="form-group">
                <label>Answer:</label>
                <textarea name="answer" placeholder="Enter the answer..." required></textarea>
            </div>
            <div class="form-group">
                <label>Category:</label>
                <select name="category">
                    <option value="general">General</option>
                    <option value="shipping">Shipping</option>
                    <option value="returns">Returns & Refunds</option>
                    <option value="payment">Payment</option>
                    <option value="order">Order</option>
                    <option value="product">Product</option>
                    <option value="support">Support</option>
                </select>
            </div>
            <button type="submit">Add FAQ</button>
        </form>
        
        <h2>Existing FAQs</h2>
        <?php
        $result = $conn->query("SELECT * FROM chatbot_faq ORDER BY category, id");
        if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Keywords</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['keywords']); ?></td>
                            <td><?php echo htmlspecialchars($row['question']); ?></td>
                            <td><?php echo htmlspecialchars($row['answer']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" 
                                   class="delete-btn" 
                                   onclick="return confirm('Are you sure you want to delete this FAQ?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No FAQs found. Add some above!</p>
        <?php endif; ?>
    </div>
</body>
</html>

