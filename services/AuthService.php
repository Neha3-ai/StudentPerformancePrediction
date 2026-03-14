<?php
require_once("../dao/LoginDAO.php");

class AuthService {

    public function login($userId, $secret) {
        $loginDAO = new LoginDAO();
        return $loginDAO->checkLogin($userId, $secret);
    }
}
?>
