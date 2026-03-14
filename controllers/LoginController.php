<?php
session_start();
require_once("../dao/LoginDAO.php");

if (!isset($_POST['eid'], $_POST['password'])) {
    header("Location: ../public/login.html?error=1");
    exit;
}

$eid = $_POST['eid'];
$password = $_POST['password'];

$loginDAO = new LoginDAO();
$user = $loginDAO->checkEmployee($eid, $password);
$adm  = $loginDAO->checkAdmin($eid, $password);

if ($user) {

    $_SESSION['eid'] = $user['e_id'];

    // ❌ DO NOT STORE LOGIN TIME HERE
    header("Location: ../public/employee_dashboard.php");
    exit;
}

if ($adm) {

    $_SESSION['aid'] = $adm['a_id'];

    // ❌ DO NOT STORE LOGIN TIME HERE
    header("Location: ../public/admin_dashboard.php");
    exit;
}

header("Location: ../views/login.php?error=1");
exit;