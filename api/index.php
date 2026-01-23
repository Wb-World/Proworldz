<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 15px 0 5px;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            margin-top: 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
            min-height: 100px;
        }
        .loading {
            color: #666;
            font-style: italic;
        }
        .error {
            color: #d32f2f;
            background-color: #ffebee;
            border-color: #ffcdd2;
        }
        .success {
            color: #388e3c;
            background-color: #e8f5e9;
            border-color: #c8e6c9;
        }
        .info-item {
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .info-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Get User Information</h2>
        
        <label for="userId">User ID:</label>
        <input type="text" id="userId" placeholder="Enter user ID (e.g., U001)">
        
        <button onclick="getUserInfo()">Get User Info</button>
        
        <div class="result" id="result">
            <div class="loading">Enter a user ID and click "Get User Info"</div>
        </div>
    </div>

    <script>
        function getUserInfo() {
            const id = document.getElementById('userId').value.trim();
            const resultDiv = document.getElementById('result');
            
            if (!id) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = '⚠️ Please enter a user ID';
                return;
            }
            
            resultDiv.className = 'result';
            resultDiv.innerHTML = '<div class="loading">Loading user information...</div>';
            
            fetch(`http://localhost:3000/lead.php?id=${encodeURIComponent(id)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        resultDiv.className = 'result error';
                        resultDiv.innerHTML = `❌ Error: ${data.error}`;
                    } else {
                        resultDiv.className = 'result success';
                        
                        // Format the response data
                        let html = '<h3>User Information:</h3>';
                        console.log(data)
                        if (data.name) {
                            html += `<div class="info-item"><strong>Name:</strong> ${data.name}</div>`;
                        }
                        if (data.course) {
                            html += `<div class="info-item"><strong>Course:</strong> ${data.course}</div>`;
                        }
                        if (data.eagle_coins !== undefined) {
                            html += `<div class="info-item"><strong>Eagle Coins:</strong> ${data.eagle_coins}</div>`;
                        }
                        
                        // If no data fields found
                        if (html === '<h3>User Information:</h3>') {
                            html = 'No user information available';
                        }
                        
                        resultDiv.innerHTML = html;
                    }
                })
                .catch(err => {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = '❌ Failed to fetch user information. Please check your connection and try again.';
                    console.error('Fetch error:', err);
                });
        }
        
        // Allow pressing Enter in the input field
        document.getElementById('userId').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                getUserInfo();
            }
        });
        
        // Focus on input field when page loads
        document.getElementById('userId').focus();
    </script>

</body>
</html>