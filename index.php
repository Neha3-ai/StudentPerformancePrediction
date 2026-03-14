<?php
session_start();

// redirect after 2 seconds
header("refresh:2; url=views/login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Office Attendance System</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #dbeafe, #bfdbfe);
            font-family: Arial, sans-serif;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            padding: 40px 60px;
            border-radius: 12px;
            border: 2px solid #1e3a8a;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .card h1 {
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .card p {
            color: #334155;
            font-size: 15px;
        }

        .loader {
            margin-top: 20px;
            width: 40px;
            height: 40px;
            border: 5px solid #c7d2fe;
            border-top: 5px solid #1e3a8a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Office Attendance System</h1>
    <p>Loading secure login...</p>
    <div class="loader"></div>
</div>

</body>
</html>
