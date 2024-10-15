<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message-container {
            text-align: center;
            padding: 60px;
            background-color: #ffffff;
            border-radius: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Increased for better responsiveness */
            width: 90%; /* Added for better responsiveness */
        }
        h1 {
            color: #007bff;
            font-size: 48px; /* Increased font size */
            margin: 0;
            margin-bottom: 30px; /* Added for spacing */
        }
        p {
            font-size: 24px; /* Increased font size */
            margin-top: 0; /* Added for spacing */
            margin-bottom: 30px; /* Added for spacing */
        }
        .loader {
            border: 10px solid #f3f3f3; /* Light grey */
            border-top: 10px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 100px; /* Increased size */
            height: 100px; /* Increased size */
            animation: spin 1s linear infinite;
            margin: 40px auto; /* Added for spacing */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h1>Payment Successful!</h1>
        <p>Thank you for your order. Your purchase is being processed.</p>
        <div class="loader"></div>
    </div>
    <script>
        setTimeout(function(){
            window.location.href = "../Canteen/home.php";
        }, 2000);

    </script>
</body>
</html>