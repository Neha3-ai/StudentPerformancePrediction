<?php
session_start();
if (!isset($_SESSION['eid'])) {
    header("Location: login.html");
    exit;
}

$dayName = date("l");      // Monday, Tuesday...
$currentTime = date("H:i"); // 24-hour format

$isWeekend = ($dayName == "Saturday" || $dayName == "Sunday");
$isAfterSix = ($currentTime >= "18:00");
$disableWorksheet = ($isWeekend || $isAfterSix);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Daily Worksheet</title>
    <link rel="stylesheet" href="css/employee.css">
</head>
<body>

<div class="worksheet-page">
  <div class="worksheet-card">

    <h2>📝 Daily Worksheet</h2>
    <p style="text-align:center;color:#475569;font-size:14px;">
      Describe your work for today (max 300 words)
    </p>

    <form action="../controllers/WorksheetController.php" method="POST">
      <textarea id="worksheet"
                name="worksheet"
                rows="8"
                maxlength="300"
                placeholder="• Tasks completed today  
• Meetings attended  
• Progress made  
• Issues faced"
                required></textarea>

      <div id="counter">0 / 300 words</div>

      <?php if($disableWorksheet): ?>
          <p style="color:red; font-weight:bold;">
              Worksheet submission is disabled on weekends and after 6 PM.
          </p>
      <?php endif; ?>

      <button type="submit" class="submit-btn" <?php if($disableWorksheet) echo "disabled"; ?>>
          Submit Worksheet
      </button>
    </form>

    <?php if (isset($_SESSION['worksheet_success'])) { ?>
      <p class="success"><?= $_SESSION['worksheet_success'] ?></p>
    <?php unset($_SESSION['worksheet_success']); } ?>

    <?php if (isset($_SESSION['worksheet_error'])) { ?>
      <p class="error"><?= $_SESSION['worksheet_error'] ?></p>
    <?php unset($_SESSION['worksheet_error']); } ?>

    <!-- <a href="employee_dashboard.php" class="back-link">⬅ Back to Dashboard</a> -->

  </div>
</div>

<!-- ✨ WORD COUNTER SCRIPT -->
<script>
const textarea = document.getElementById("worksheet");
const counter = document.getElementById("counter");

textarea.addEventListener("input", () => {
  const words = textarea.value.trim().split(/\s+/).filter(Boolean).length;
  counter.textContent = `${words} / 300 words`;
});
</script>

</body>
</html>