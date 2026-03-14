<?php
require_once(__DIR__ . "/../utils/db.php");

class AdminReportDAO {

    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    /* ================= DAILY ================= */
    public function getDailyAttendance($date) {
        $sql = "
            SELECT e_id, date, login_time, logout_time
            FROM emp_attendance
            WHERE date = ?
            ORDER BY e_id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDailyWorksheet($date) {
        $sql = "
            SELECT e_id, date, worksheet
            FROM work_attendance_worksheet
            WHERE date = ?
            ORDER BY e_id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ================= MONTHLY ================= */
    public function getMonthlyAttendance($month) {
        $sql = "
            SELECT e_id, date, login_time, logout_time
            FROM emp_attendance
            WHERE DATE_FORMAT(date,'%Y-%m') = ?
            ORDER BY e_id, date
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$month]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyWorksheet($month) {
        $sql = "
            SELECT e_id, date, worksheet
            FROM work_attendance_worksheet
            WHERE DATE_FORMAT(date,'%Y-%m') = ?
            ORDER BY e_id, date
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$month]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ================= EMPLOYEE WISE ================= */
    public function getEmployeeAttendance($eid) {
        $sql = "
            SELECT date, login_time, logout_time
            FROM emp_attendance
            WHERE e_id = ?
            ORDER BY date
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$eid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmployeeWorksheet($eid) {
        $sql = "
            SELECT date, worksheet
            FROM work_attendance_worksheet
            WHERE e_id = ?
            ORDER BY date
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$eid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}