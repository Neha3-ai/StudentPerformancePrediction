<?php
session_start();
require_once "../utils/db.php";

/* 🔐 ADMIN AUTH CHECK */
if (!isset($_SESSION['aid'])) {
    header("Location: ../public/login.html");
    exit;
}

/* 🚫 DO NOTHING IF PAGE IS LOADED DIRECTLY */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../public/admin_dashboard.php");
    exit;
}

/* ✅ PDO CONNECTION (FROM YOUR db.php) */
$conn = getDBConnection();

/* 🔥 CLEAR OLD REPORT DATA */
// unset($_SESSION['attendanceReport']);
// unset($_SESSION['worksheetReport']);
// unset($_SESSION['employeeAttendance']);
// unset($_SESSION['employeeWorksheet']);
// unset($_SESSION['error']);

$reportType = $_POST['report_type'] ?? '';
$eid        = $_POST['eid'] ?? null;

/* ================= DAILY REPORT ================= */
if ($reportType === "daily") {

    // Attendance
    $stmt = $conn->prepare(
        "SELECT * FROM emp_attendance 
         WHERE date = CURDATE()
         ORDER BY e_id"
    );
    $stmt->execute();
    $_SESSION['attendanceReport'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Worksheet
    $stmt = $conn->prepare(
        "SELECT * FROM work_attendance_worksheet
         WHERE date = CURDATE()
         ORDER BY e_id"
    );
    $stmt->execute();
    $_SESSION['worksheetReport'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ================= MONTHLY REPORT ================= */
elseif ($reportType === "monthly") {

    // Attendance
    $stmt = $conn->prepare(
        "SELECT * FROM emp_attendance
         WHERE MONTH(date)=MONTH(CURDATE())
         AND YEAR(date)=YEAR(CURDATE())
         ORDER BY e_id, date"
    );
    $stmt->execute();
    $_SESSION['attendanceReport'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Worksheet
    $stmt = $conn->prepare(
        "SELECT * FROM work_attendance_worksheet
         WHERE MONTH(date)=MONTH(CURDATE())
         AND YEAR(date)=YEAR(CURDATE())
         ORDER BY e_id, date"
    );
    $stmt->execute();
    $_SESSION['worksheetReport'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ================= EMPLOYEE-WISE REPORT ================= */
elseif ($reportType === "employee") {

    if (empty($eid)) {
        $_SESSION['error'] = "Employee ID is required for Employee-wise report";
        header("Location: ../public/admin_dashboard.php");
        exit;
    }

    // Attendance
    $stmt = $conn->prepare(
        "SELECT * FROM emp_attendance
         WHERE e_id = ?
         ORDER BY date"
    );
    $stmt->execute([$eid]);
    $_SESSION['employeeAttendance'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Worksheet
    $stmt = $conn->prepare(
        "SELECT * FROM work_attendance_worksheet
         WHERE e_id = ?
         ORDER BY date"
    );
    $stmt->execute([$eid]);
    $_SESSION['employeeWorksheet'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ================= INVALID OPTION ================= */
else {
    $_SESSION['error'] = "Invalid report type selected";
}

/* ✅ FLAG TO SHOW REPORT */
$_SESSION['showReport'] = true;

/* 🔁 BACK TO ADMIN DASHBOARD */
header("Location: ../public/admin_dashboard.php");
exit;