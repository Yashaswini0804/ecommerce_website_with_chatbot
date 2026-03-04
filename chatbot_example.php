<?php
/**
 * Example: How to Add Chatbot to Your Pages
 * 
 * Since you want to add chatbot without changing existing code,
 * here are different ways to include it:
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Example Page with Chatbot</title>
</head>
<body>
    <!-- Your existing page content here -->
    <h1>Welcome to Our Shop</h1>
    <p>This is an example page showing the chatbot integration.</p>
    
    <!-- ========================================== -->
    <!-- OPTION 1: Add this line at bottom of body   -->
    <!-- ========================================== -->
    <?php include "chatbot_widget.php"; ?>
    
    <!-- ========================================== -->
    <!-- That's it! The chatbot will appear on this -->
    <!-- page with a chat bubble icon               -->
    <!-- ========================================== -->
    
</body>
</html>

<!-- 
=================================================================
HOW TO ADD CHATBOT TO YOUR EXISTING PAGES (Without Changing Much)
=================================================================

OPTION 1: Add to specific pages only
--------------------------------------
Add this line at the END of any PHP file (before </body>):
<?php include "chatbot_widget.php"; ?>

Example for user_homepage.php:
    ...
    </div>
    
    <?php include "chatbot_widget.php"; ?>
</body>
</html>

--------------------------------------------------------------------

OPTION 2: Add to all user pages at once
--------------------------------------
Create a new file called "footer.php" with:
    <?php include "chatbot_widget.php"; ?>
    </body>
</html>

Then modify your pages to include footer instead of closing tags.

--------------------------------------------------------------------

OPTION 3: Add via JavaScript (No PHP changes)
----------------------------------------------
Create chatbot_standalone.js:

document.write('<div id="chatbot-toggle" onclick="toggleChatbot()">💬</div>');
document.write('<div id="chatbot-container">...</div>');

Then add this to any HTML file:
<script src="chatbot_standalone.js"></script>

--------------------------------------------------------------------

DEFAULT LOGIN REQUIRED:
Since your site requires login, the chatbot will only show to 
logged-in users. The chatbot_widget.php doesn't check login,
so if you want to restrict it, add this at the top:

<?php
if (!isset($_SESSION['user_id'])) {
    // Don't show chatbot for non-logged users
    return;
}
?>

=================================================================
-->

