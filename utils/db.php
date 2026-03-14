<?php

function getDBConnection() {
    $host = "localhost";
    $dbname = "attendance_system";   // ⚠️ your database name
    $username = "root";
    $password = "";

    try {
        $conn = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $username,
            $password
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Database Connection Failed: " . $e->getMessage());
    }
}
