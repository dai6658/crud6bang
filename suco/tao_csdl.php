<?php
// Tao CSDL ktx_management (cach don gian giong badminton_booking_final)
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die("Khong ket noi duoc MySQL: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS ktx_management
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci";

if (mysqli_query($con, $sql)) {
    echo "Da tao (hoac da ton tai) CSDL ktx_management<br>";
} else {
    echo "Loi khi tao CSDL: " . mysqli_error($con);
}

mysqli_close($con);
unset($sql);
?>
