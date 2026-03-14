<?php
require_once(__DIR__ . "/../utils/db.php");

class AttendanceDAO {

    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    /* =======================
       MARK ATTENDANCE
       ======================= */
    public function markAttendance($eid, $date, $loginTime) {

        // prevent duplicate entry
        if ($this->isAttendanceMarked($eid, $date)) {
            return false;
        }

        $sql = "INSERT INTO emp_attendance (e_id, date, login_time)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$eid, $date, $loginTime]);
    }

    /* =======================
       GET PRESENT DATES (Mini Calendar)
       ======================= */
    public function getPresentDates($eid, $month, $year) {

        $sql = "SELECT date
                FROM emp_attendance
                WHERE e_id = ?
                AND MONTH(date) = ?
                AND YEAR(date) = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$eid, $month, $year]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /* =======================
       CHECK IF ALREADY MARKED
       ======================= */
    public function isAttendanceMarked($eid, $date) {

        $sql = "SELECT COUNT(*) 
                FROM emp_attendance
                WHERE e_id = ? AND date = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$eid, $date]);

        return $stmt->fetchColumn() > 0;
    }

    // ✅ Store logout time
    public function storeLogoutTime($eid, $date, $time) {
        $sql = "INSERT INTO logout (e_id, logout_date, logout_time)
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$eid, $date, $time]);
    }

    public function updateLogoutTime($eid, $date, $time) {
    $sql = "UPDATE emp_attendance
            SET logout_time = ?
            WHERE e_id = ?
            AND date = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$time, $eid, $date]);
}

}
