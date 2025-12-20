<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ktx_management";

$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS `$db`
               DEFAULT CHARACTER SET utf8mb4
               COLLATE utf8mb4_unicode_ci";

mysqli_query($conn, $sqlCreateDB);

mysqli_select_db($conn, $db);

mysqli_set_charset($conn, "utf8");
?>
