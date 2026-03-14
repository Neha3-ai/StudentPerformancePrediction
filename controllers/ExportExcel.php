<?php
session_start();

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=attendance_report.xls");

echo "Employee ID\tDate\tLogin\tLogout\tWorksheet\n";

if (!empty($_SESSION['attendanceReport'])) {
    foreach ($_SESSION['attendanceReport'] as $row) {
        echo "{$row['e_id']}\t{$row['date']}\t{$row['login_time']}\t{$row['logout_time']}\t\n";
    }
}

if (!empty($_SESSION['worksheetReport'])) {
    foreach ($_SESSION['worksheetReport'] as $row) {
        echo "{$row['e_id']}\t{$row['date']}\t\t\t{$row['worksheet']}\n";
    }
}

if (!empty($_SESSION['employeeAttendance'])) {
    foreach ($_SESSION['employeeAttendance'] as $row) {
        echo "\t{$row['date']}\t{$row['login_time']}\t{$row['logout_time']}\t\n";
    }
}

if (!empty($_SESSION['employeeWorksheet'])) {
    foreach ($_SESSION['employeeWorksheet'] as $row) {
        echo "\t{$row['date']}\t\t\t{$row['worksheet']}\n";
    }
}

// After exporting
unset($_SESSION['attendanceReport']);
unset($_SESSION['worksheetReport']);
unset($_SESSION['employeeAttendance']);
unset($_SESSION['employeeWorksheet']);