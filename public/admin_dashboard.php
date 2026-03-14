<?php
session_start();
/* 🔥 CLEAR REPORTS ON PAGE LOAD */
if (!isset($_SESSION['showReport'])) {
    unset($_SESSION['attendanceReport']);
    unset($_SESSION['worksheetReport']);
    unset($_SESSION['employeeAttendance']);
    unset($_SESSION['employeeWorksheet']);
}   
if (!isset($_SESSION['aid'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="top-dark"></div>
<div class="top-light"></div>

<div class="container">
<h2 class="page-title">Admin Dashboard</h2>

<form class="report-form" action="../controllers/AdminController.php" method="POST">
    <input type="text" name="eid" placeholder="Employee ID (Only for Employee-wise)">

    <div class="radio-group">
        <label><input type="radio" name="report_type" value="daily" required> Daily</label>
        <label><input type="radio" name="report_type" value="monthly"> Monthly</label>
        <label><input type="radio" name="report_type" value="employee"> Employee Wise</label>
    </div>

    <button type="submit" name="generate">Generate Report</button>

    <?php if (
      isset($_SESSION['attendanceReport']) || 
      isset($_SESSION['worksheetReport']) ||
      isset($_SESSION['employeeAttendance']) ||
      isset($_SESSION['employeeWorksheet'])
    ) { ?>
      <div class="export-btn">
        <a href="../controllers/ExportExcel.php" class="export-btn excel">Export Excel</a>
      </div>
    <?php } ?>
</form>

<!-- ================= ALL EMPLOYEES ATTENDANCE ================= -->
<?php if (!empty($_SESSION['attendanceReport'])) { ?>
<h3>Attendance Report</h3>
<table>
<tr>
  <th>Employee ID</th>
  <th>Date</th>
  <th>Login</th>
  <th>Logout</th>
</tr>

<?php foreach ($_SESSION['attendanceReport'] as $row) { ?>
<tr>
  <td><?= $row['e_id'] ?></td>
  <td><?= $row['date'] ?></td>
  <td><?= $row['login_time'] ?? '-' ?></td>
  <td><?= $row['logout_time'] ?? '-' ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>

<!-- ================= ALL EMPLOYEES WORKSHEET ================= -->
<?php if (!empty($_SESSION['worksheetReport'])) { ?>
<h3>Worksheet Report</h3>
<table>
<tr>
  <th>Employee ID</th>
  <th>Date</th>
  <th>Worksheet</th>
</tr>

<?php foreach ($_SESSION['worksheetReport'] as $row) { ?>
<tr>
  <td><?= $row['e_id'] ?></td>
  <td><?= $row['date'] ?></td>
  <td><?= nl2br(htmlspecialchars($row['worksheet'])) ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>

<!-- ================= EMPLOYEE-WISE ATTENDANCE ================= -->
<?php if (!empty($_SESSION['employeeAttendance'])) { ?>
<h3>Employee Monthly Attendance</h3>
<table>
<tr>
  <th>Date</th>
  <th>Login</th>
  <th>Logout</th>
</tr>

<?php foreach ($_SESSION['employeeAttendance'] as $row) { ?>
<tr>
  <td><?= $row['date'] ?></td>
  <td><?= $row['login_time'] ?? '-' ?></td>
  <td><?= $row['logout_time'] ?? '-' ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>

<!-- ================= EMPLOYEE-WISE WORKSHEET ================= -->
<?php if (!empty($_SESSION['employeeWorksheet'])) { ?>
<h3>Employee Monthly Worksheet</h3>
<table>
<tr>
  <th>Date</th>
  <th>Worksheet</th>
</tr>

<?php foreach ($_SESSION['employeeWorksheet'] as $row) { ?>
<tr>
  <td><?= $row['date'] ?></td>
  <td><?= nl2br(htmlspecialchars($row['worksheet'])) ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>

<?php unset($_SESSION['showReport']); ?>

</div>

<div class="bottom-dark"></div>
</body>
</html>