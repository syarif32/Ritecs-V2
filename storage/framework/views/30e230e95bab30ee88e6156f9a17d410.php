<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Gemini Chatbot</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .chat-container { width: 500px; height: 700px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; flex-direction: column; }
        .chat-header { background: #6200ea; color: white; padding: 15px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center; }
        #chat-box { flex-grow: 1; padding: 20px; overflow-y: auto; border-bottom: 1px solid #ddd; }
        .chat-message { margin-bottom: 15px; }
        .user-message { text-align: right; }
        .bot-message { text-align: left; }
        .message-bubble { display: inline-block; padding: 10px 15px; border-radius: 18px; max-width: 80%; }
        .user-message .message-bubble { background: #e0e0e0; color: black; }
        .bot-message .message-bubble { background: #6200ea; color: white; }
        #chat-form { display: flex; padding: 20px; }
        #message-input { flex-grow: 1; border: 1px solid #ddd; border-radius: 20px; padding: 10px 15px; font-size: 16px; }
        #send-button { background: #6200ea; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; margin-left: 10px; font-size: 20px; cursor: pointer; }
        .typing-indicator { font-style: italic; color: #888; }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        <h2>RITECS Chatbot</h2>
    </div>
    <div id="chat-box">
        <div class="chat-message bot-message">
            <div class="message-bubble">Halo! Ada yang bisa saya bantu?</div>
        </div>
    </div>
    <form id="chat-form">
        <input type="text" id="message-input" placeholder="Ketik pesan Anda..." autocomplete="off">
        <button type="submit" id="send-button">➤</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const chatBox = document.getElementById('chat-box');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        chatForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const userMessage = messageInput.value.trim();
            if (userMessage === '') return;
            appendMessage(userMessage, 'user');
            messageInput.value = '';
            const typingIndicator = appendMessage('...', 'bot', true);
            fetch('<?php echo e(route("chatbot.send")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message: userMessage })
            })
            .then(response => response.json())
            .then(data => {
                chatBox.removeChild(typingIndicator);
                if (data.reply) {
                    appendMessage(data.reply, 'bot');
                } else {
                    appendMessage('Maaf, ada kesalahan.', 'bot');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                chatBox.removeChild(typingIndicator);
                appendMessage('Gagal terhubung ke server.', 'bot');
            });
        });

        function appendMessage(text, type, isTyping = false) {
            const messageWrapper = document.createElement('div');
            messageWrapper.classList.add('chat-message', type + '-message');

            const messageBubble = document.createElement('div');
            messageBubble.classList.add('message-bubble');
            if (isTyping) {
                messageBubble.classList.add('typing-indicator');
            }
            messageBubble.textContent = text;
            
            messageWrapper.appendChild(messageBubble);
            chatBox.appendChild(messageWrapper);
            chatBox.scrollTop = chatBox.scrollHeight; 
            return messageWrapper;
        }
    });
</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\AI\chatbot.blade.php ENDPATH**/ ?>