<?php
$host = "localhost";
$user = "s68160380"; 
$pass = "rHX77ww1";
$db   = "s68160380"; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    // ตั้งค่าแสดงสิทธิ์ข้อผิดพลาดในรูปแบบ Exception สำหรับดักจับ Error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage());
}
?>
