<?php
require_once("../utils/db.php");

class LogoutDAO {

    public function saveLogout($eid) {
        global $conn;

        $time = date("H:i:s");
        $date = date("Y-m-d");

        $sql = "INSERT INTO Logout (e_id, logout_time, logout_date)
                VALUES ('$eid', '$time', '$date')";

        mysqli_query($conn, $sql);
    }
}
?>
