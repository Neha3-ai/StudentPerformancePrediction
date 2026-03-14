<?php
session_start();
require_once "../utils/db.php";

date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['eid'])) {
    header("Location: ../views/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $e_id = $_SESSION['eid'];
    $date = date("Y-m-d");
    $currentTime = date("H:i");
    $worksheet = trim($_POST['worksheet']);

    // ⏰ Block after 6 PM
    if ($currentTime >= "18:00") {
        $_SESSION['worksheet_error'] = "⏰ Worksheet submission closed after 6:00 PM";
        header("Location: ../public/worksheet.php");
        exit;
    }

    // 🚫 Block worksheet on weekends
    if ($dayName == "Saturday" || $dayName == "Sunday") {
        $_SESSION['worksheet_error'] = "🚫 Worksheet submission disabled on weekends";
        header("Location: ../public/worksheet.php");
        exit;
    }

    if (empty($worksheet)) {
        $_SESSION['worksheet_error'] = "Worksheet cannot be empty";
        header("Location: ../public/worksheet.php");
        exit;
    }

    try {
        $conn = getDBConnection();

        $sql = "INSERT INTO work_attendance_worksheet (e_id, date, worksheet)
                VALUES (:e_id, :date, :worksheet)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':e_id' => $e_id,
            ':date' => $date,
            ':worksheet' => $worksheet
        ]);

        $_SESSION['worksheet_success'] = "✅ Worksheet saved successfully";

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            $_SESSION['worksheet_error'] = "📌 Worksheet already submitted for today";
        } else {
            $_SESSION['worksheet_error'] = "Error: " . $e->getMessage();
        }
    }

    header("Location: ../public/worksheet.php");
    exit;
}