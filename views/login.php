<?php
date_default_timezone_set("Asia/Kolkata");
$currentHour = date("H");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Office Attendance</title>
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>

<!-- Top bar -->
<div class="top-bar"></div>

<!-- Space -->
<div class="space-8"></div>

<!-- Main section -->
<div class="main-container">

    <!-- Video background -->
    <div class="video-bg">
        <video autoplay muted loop>
            <source src="../public/images/office.mp4" type="video/mp4">
        </video>
    </div>

    <!-- Login box -->
    <div class="login-box">
        <h2>Login</h2>

        <form action="../controllers/LoginController.php" method="POST">
            <input type="text" name="eid" placeholder="ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

    </div>

</div>

<!-- Space -->
<div class="space-5"></div>

<!-- Bottom bar -->
<div class="bottom-bar"></div>

</body>
</html>
