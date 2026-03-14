<?php
require_once(__DIR__ . "/../utils/db.php");

class LoginDAO {

    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function checkEmployee($e_id, $e_secret) {
        $sql = "SELECT * FROM employee WHERE e_id = ? AND e_secret = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$e_id, $e_secret]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkAdmin($a_id, $a_secret) {
        $sql = "SELECT * FROM admin WHERE a_id = ? AND a_secret = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$a_id, $a_secret]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ USED ONLY WHEN ATTENDANCE IS SUBMITTED
    public function storeLogin($eid) {
        $sql = "INSERT INTO login (e_id, login_time, login_date)
                VALUES (?, CURTIME(), CURDATE())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$eid]);
    }
}