<?php
// config.php - ไฟล์เชื่อมต่อฐานข้อมูล
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login_system');

try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if ($conn->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
} catch (Exception $e) {
    die("เกิดข้อผิดพลาด: " . $e->getMessage());
}
?>