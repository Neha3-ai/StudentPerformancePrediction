<?php
session_start();
require_once("../dao/AttendanceDAO.php");
require_once("../dao/LoginDAO.php");

if (!isset($_SESSION['eid'])) {
    header("Location: ../public/login.html");
    exit;
}

date_default_timezone_set("Asia/Kolkata");

$eid  = $_SESSION['eid'];
$date = $_POST['date'] ?? date("Y-m-d");
$time = date("H:i:s");

$attendanceDAO = new AttendanceDAO();
$loginDAO      = new LoginDAO();

// ✅ ONLY WHEN ATTENDANCE IS CLICKED
if (!$attendanceDAO->isAttendanceMarked($eid, $date)) {

    // Mark attendance
    $attendanceDAO->markAttendance($eid, $date, $time);

    // Store login time (actual attendance submit time)
    $loginDAO->storeLogin($eid);
}

header("Location: ../public/employee_dashboard.php?success=1");
exit;