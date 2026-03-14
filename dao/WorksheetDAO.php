<?php
require_once __DIR__ . "/../utils/db.php";

class WorksheetDAO {

    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function getAllWorksheets() {
        $sql = "
            SELECT 
                w.eid,
                w.date,
                w.worksheet
            FROM work_attendance_worksheet w
            ORDER BY w.date DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}