<!-- Chatbot Widget for Ecommerce Website -->
<!-- This is a standalone widget - no changes needed to your existing code -->
<!-- Just include this file in any page where you want the chatbot to appear -->

<style>
/* Chatbot Widget Styles */
#chatbot-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

#chatbot-toggle:hover {
    transform: scale(1.1);
}

#chatbot-toggle img {
    width: 35px;
    height: 35px;
}

#chatbot-container {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 380px;
    height: 500px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.3);
    z-index: 10000;
    display: none;
    flex-direction: column;
    overflow: hidden;
    font-family: Arial, sans-serif;
}

#chatbot-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#chatbot-header h3 {
    margin: 0;
    font-size: 18px;
}

#chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}

#chatbot-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f9f9f9;
}

.message {
    margin-bottom: 15px;
    max-width: 85%;
    padding: 12px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
}

.bot-message {
    background: #e8e8e8;
    color: #333;
    border-bottom-left-radius: 3px;
    float: left;
    clear: both;
}

.user-message {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom-right-radius: 3px;
    float: right;
    clear: both;
}

.message::after {
    content: "";
    display: table;
    clear: both;
}

#chatbot-input-area {
    padding: 15px;
    background: #fff;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
}

#chatbot-input {
    flex: 1;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 25px;
    outline: none;
    font-size: 14px;
}

#chatbot-input:focus {
    border-color: #667eea;
}

#chatbot-send {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 14px;
    transition: opacity 0.3s;
}

#chatbot-send:hover {
    opacity: 0.8;
}

.typing-indicator {
    display: none;
    padding: 10px 15px;
    background: #e8e8e8;
    border-radius: 15px;
    border-bottom-left-radius: 3px;
    margin-bottom: 15px;
    float: left;
    clear: both;
}

.typing-indicator span {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #999;
    border-radius: 50%;
    margin: 0 2px;
    animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-5px); }
}

/* Quick Reply Buttons */
.quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
    float: left;
    clear: both;
}

.quick-reply-btn {
    background: #fff;
    border: 1px solid #667eea;
    color: #667eea;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.quick-reply-btn:hover {
    background: #667eea;
    color: white;
}

/* Mobile Responsive */
@media (max-width: 480px) {
    #chatbot-container {
        width: calc(100% - 20px);
        right: 10px;
        bottom: 80px;
        height: calc(100% - 150px);
    }
    
    #chatbot-toggle {
        bottom: 15px;
        right: 15px;
    }
}
</style>

<!-- Chatbot Toggle Button -->
<div id="chatbot-toggle" onclick="toggleChatbot()">
    💬
</div>

<!-- Chatbot Container -->
<div id="chatbot-container">
    <div id="chatbot-header">
        <h3>🛒 Shop Assistant</h3>
        <button id="chatbot-close" onclick="toggleChatbot()">×</button>
    </div>
    
    <div id="chatbot-messages">
        <div class="message bot-message">
            Hello! 👋 Welcome to our shop! How can I help you today?
        </div>
        
        <div class="quick-replies">
            <button class="quick-reply-btn" onclick="sendQuickMessage('Shipping')">📦 Shipping</button>
            <button class="quick-reply-btn" onclick="sendQuickMessage('Returns')">🔄 Returns</button>
            <button class="quick-reply-btn" onclick="sendQuickMessage('Payment')">💳 Payment</button>
            <button class="quick-reply-btn" onclick="sendQuickMessage('Track order')">📋 Track Order</button>
        </div>
        
        <div class="typing-indicator" id="typing-indicator">
            <span></span><span></span><span></span>
        </div>
    </div>
    
    <div id="chatbot-input-area">
        <input type="text" id="chatbot-input" placeholder="Type your message..." onkeypress="handleKeyPress(event)">
        <button id="chatbot-send" onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
function toggleChatbot() {
    const container = document.getElementById('chatbot-container');
    const toggle = document.getElementById('chatbot-toggle');
    
    if (container.style.display === 'flex') {
        container.style.display = 'none';
        toggle.style.display = 'flex';
    } else {
        container.style.display = 'flex';
        toggle.style.display = 'none';
    }
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function sendQuickMessage(message) {
    const input = document.getElementById('chatbot-input');
    input.value = message;
    sendMessage();
}

function sendMessage() {
    const input = document.getElementById('chatbot-input');
    const message = input.value.trim();
    
    if (message === '') return;
    
    // Add user message to chat
    addMessage(message, 'user');
    input.value = '';
    
    // Show typing indicator
    const typingIndicator = document.getElementById('typing-indicator');
    typingIndicator.style.display = 'block';
    scrollToBottom();
    
    // Send to server (using enhanced backend)
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'chatbot_backend.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            typingIndicator.style.display = 'none';
            
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    addMessage(response.response, 'bot');
                } else {
                    addMessage(response.response || 'Sorry, something went wrong.', 'bot');
                }
            } catch (e) {
                addMessage('Sorry, something went wrong. Please try again.', 'bot');
            }
        } else if (xhr.readyState === 4) {
            // Fallback to process.php if backend fails
            fallbackToProcess(message);
        }
    };
    
    xhr.send('message=' + encodeURIComponent(message));
}

// Fallback function if backend fails
function fallbackToProcess(message) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'chatbot_process.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                addMessage(response.response, 'bot');
            } catch (e) {
                addMessage('Sorry, please try again later.', 'bot');
            }
        }
    };
    
    xhr.send('message=' + encodeURIComponent(message));
}

function addMessage(text, sender) {
    const messagesContainer = document.getElementById('chatbot-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + (sender === 'user' ? 'user-message' : 'bot-message');
    messageDiv.textContent = text;
    
    // Insert before typing indicator
    const typingIndicator = document.getElementById('typing-indicator');
    messagesContainer.insertBefore(messageDiv, typingIndicator);
    
    scrollToBottom();
}

function scrollToBottom() {
    const messagesContainer = document.getElementById('chatbot-messages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}
</script>

