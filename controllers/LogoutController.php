<?php
session_start();
require_once("../dao/AttendanceDAO.php");

if (!isset($_SESSION['eid'])) {
    header("Location: ../views/login.php");
    exit;
}

date_default_timezone_set("Asia/Kolkata");

$eid  = $_SESSION['eid'];
$date = date("Y-m-d");
$time = date("H:i:s");

$attendanceDAO = new AttendanceDAO();

/* ✅ Update logout time in emp_attendance */
$attendanceDAO->updateLogoutTime($eid, $date, $time);

/* Destroy session */
session_destroy();

header("Location: ../views/login.php?logged_out=1");
exit;