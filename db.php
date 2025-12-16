<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ktx_management";

// Kết nối đến MySQL server (chưa chọn database)
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo database nếu chưa có
$conn->query("CREATE DATABASE IF NOT EXISTS `ktx_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

// Chọn database
$conn->select_db($db);

$conn->set_charset("utf8");
?>
