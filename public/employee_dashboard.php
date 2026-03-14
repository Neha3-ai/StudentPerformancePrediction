<?php
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['eid'])) {
    header("Location: login.html");
    exit;
}

require_once("../dao/AttendanceDAO.php");
$attendanceDAO = new AttendanceDAO();

$eid = $_SESSION['eid'];

$todayDate    = date("Y-m-d");
$currentDay   = date("j");
$todayDayName = date("l");
$currentHour  = date("H"); // 24-hour format

$month = date("m");
$year  = date("Y");

$monthName   = date("F Y", strtotime("$year-$month-01"));
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDay    = date("w", strtotime("$year-$month-01"));

$presentDates = $attendanceDAO->getPresentDates($eid, $month, $year);
$presentDays  = [];

foreach ($presentDates as $d) {
    $presentDays[] = (int)date("j", strtotime($d));
}

$attendanceSubmitted = isset($_GET['success']);
$attendanceAlready   = in_array($currentDay, $presentDays);
$isWeekend           = ($todayDayName == "Saturday" || $todayDayName == "Sunday");
$isAfterSix          = ($currentHour >= 18);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Employee Dashboard</title>
  <link rel="stylesheet" href="css/employee.css">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <span>Employee Dashboard</span>
  <form action="worksheet.php" method="GET">
    <button type="submit" class="worksheet-btn">📝 Worksheet</button>
  </form>
  <a href="../controllers/LogoutController.php" class="logout">Logout</a>
</div>

<div class="container">

<!-- ================= SMALL CALENDAR ================= -->
<div class="small-calendar">
  <div class="calendar-title"><?= $monthName ?></div>

  <div class="weekdays">
    <span>Su</span><span>Mo</span><span>Tu</span>
    <span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
  </div>

  <div class="calendar-grid small">
    <?php
    for ($i = 0; $i < $firstDay; $i++) echo "<span class='empty'></span>";

    for ($d = 1; $d <= $daysInMonth; $d++) {

        $loopDate = date("Y-m-d", strtotime("$year-$month-$d"));

        if ($d == $currentDay) {
            echo "<span class='day today'>$d</span>";
        }
        else if (in_array($d, $presentDays)) {
            echo "<span class='day present'>$d</span>";
        }
        else if (strtotime($loopDate) < strtotime($todayDate)) {
            echo "<span class='day absent'>$d</span>";
        }
        else {
            echo "<span class='day future'>$d</span>";
        }
    }
    ?>
  </div>
</div>

<!-- ================= BIG CALENDAR ================= -->
<div class="big-calendar">
  <h3><?= $monthName ?> — Attendance</h3>

  <!-- ===== STATUS MESSAGES ===== -->
  <?php if ($attendanceSubmitted) { ?>
    <p class="success">✅ Attendance submitted successfully</p>
  <?php } ?>

  <?php if (!$attendanceSubmitted && $attendanceAlready) { ?>
    <p class="info">ℹ️ Attendance already marked</p>
  <?php } ?>

  <?php if ($isWeekend) { ?>
    <p class="info">ℹ️ Attendance disabled (Weekend)</p>
  <?php } ?>

  <?php if ($isAfterSix && !$attendanceAlready) { ?>
    <p class="warning">⏰ Attendance closed for today (After 6 PM)</p>
  <?php } ?>

  <div class="weekdays big">
    <span>Sun</span><span>Mon</span><span>Tue</span>
    <span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
  </div>

  <form action="../controllers/EmployeeController.php" method="POST">
    <input type="hidden" name="date" value="<?= $todayDate ?>">

    <div class="calendar-grid big">
      <?php
      for ($i = 0; $i < $firstDay; $i++) echo "<span class='empty'></span>";

      for ($d = 1; $d <= $daysInMonth; $d++) {

          if (
              $d == $currentDay &&
              !$attendanceAlready &&
              !$isWeekend &&
              !$isAfterSix
          ) {
              echo "
              <label class='day today attendance-day'>
                <input type='radio' name='attendance' value='present'
                       onchange='this.form.submit()'>
                <span>$d</span>
              </label>";
          }
          else if (in_array($d, $presentDays)) {
              echo "<div class='day present'>$d</div>";
          }
          else {
              echo "<div class='day disabled'>$d</div>";
          }
      }
      ?>
    </div>
  </form>
</div>

<!-- ================= TIME ================= -->
<div class="time-box">
  <p>System Time</p>
  <strong><?= date("h:i A") ?></strong>
</div>

</div>
</body>
</html>