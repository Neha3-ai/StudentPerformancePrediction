<?php
require_once("../services/AuthService.php");

$userId = $_POST['user_id'];
$secret = $_POST['secret'];

$authService = new AuthService();
$result = $authService->login($userId, $secret);

if ($result == "admin") {
    header("Location: ../public/admin_dashboard.php");
}
elseif ($result == "employee") {
    header("Location: ../public/employee_dashboard.php");
}
else {
    echo "Invalid Login Credentials";
}
?>
