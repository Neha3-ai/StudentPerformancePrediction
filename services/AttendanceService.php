<?php
require_once("../dao/AttendanceDAO.php");

class AttendanceService {

    public function markAttendance($eid, $date) {
        $dao = new AttendanceDAO();
        $dao->insertAttendance($eid, $date);
    }

    public function getMonthlyAttendance($eid, $month, $year) {
        $dao = new AttendanceDAO();
        return $dao->getPresentDates($eid, $month, $year);
    }

}
?>
