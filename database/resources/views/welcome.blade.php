<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test</title>
</head>
<body>
    <h1>WebSocket Test</h1>
    <input type="text" id="messageInput" placeholder="Type a message">
    <button onclick="sendMessage()">Send</button>
    <pre id="output"></pre>

    <script>
        // Connect to the WebSocket server
        const ws = new WebSocket('ws://192.168.1.6:6001');

        // Handle connection open
        ws.onopen = () => {
            console.log('Connected to WebSocket server');
            document.getElementById('output').textContent += 'Connected to server\n';
        };

        // Handle incoming messages
        ws.onmessage = (event) => {
            console.log('Received:', event.data);
            document.getElementById('output').textContent += `Server: ${event.data}\n`;
        };

        // Handle connection close
        ws.onclose = () => {
            console.log('Disconnected from WebSocket server');
            document.getElementById('output').textContent += 'Disconnected from server\n';
        };

        // Handle errors
        ws.onerror = (error) => {
            console.error('WebSocket error:', error);
            document.getElementById('output').textContent += `Error: ${error.message}\n`;
        };

        // Send a message to the server
        function sendMessage() {
            const message = document.getElementById('messageInput').value;
            ws.send(message);
            document.getElementById('output').textContent += `You: ${message}\n`;
            document.getElementById('messageInput').value = ''; // Clear input
        }
    </script>
</body>
</html>
