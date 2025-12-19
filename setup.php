<?php

$servername = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$dbName = "ktx_management";
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbName 
               CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if (mysqli_query($conn, $sqlCreateDB)) {
    echo "<h3>1. Kiểm tra Database: '$dbName' đã sẵn sàng.</h3>";
} else {
    die("Lỗi tạo Database: " . mysqli_error($conn));
}

mysqli_select_db($conn, $dbName);

$sqlTableSchema = "
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS phong (
  MaPhong varchar(20) NOT NULL,
  LoaiPhong varchar(50),
  SoNguoiToiDa int(11),
  TinhTrang varchar(50),
  PRIMARY KEY (MaPhong)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sinhvien (
  MaSV varchar(20) NOT NULL,
  HoTen varchar(100) NOT NULL,
  NgaySinh date NOT NULL,
  GioiTinh varchar(10),
  Lop varchar(50),
  SDT varchar(15),
  DiaChi varchar(200),
  PRIMARY KEY (MaSV)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS diennuoc (
  ID int(11) NOT NULL AUTO_INCREMENT,
  MaPhong varchar(20),
  Thang varchar(20),
  SoDien int(11),
  SoNuoc int(11),
  PRIMARY KEY (ID),
  FOREIGN KEY (MaPhong) REFERENCES phong(MaPhong)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS hopdong (
  MaHD varchar(20) NOT NULL,
  MaSV varchar(20),
  MaPhong varchar(20),
  NgayBD date,
  NgayKT date,
  TinhTrang varchar(30),
  PRIMARY KEY (MaHD),
  FOREIGN KEY (MaSV) REFERENCES sinhvien(MaSV),
  FOREIGN KEY (MaPhong) REFERENCES phong(MaPhong)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS suco (
  MaSC int(11) NOT NULL AUTO_INCREMENT,
  MaPhong varchar(20),
  MoTa varchar(255),
  NgayBao date,
  TrangThai varchar(50),
  PRIMARY KEY (MaSC),
  FOREIGN KEY (MaPhong) REFERENCES phong(MaPhong)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS thanhtoan (
  MaTT int(11) NOT NULL AUTO_INCREMENT,
  MaSV varchar(20),
  SoTien int(11),
  NgayTT date,
  NoiDung varchar(200),
  PRIMARY KEY (MaTT),
  FOREIGN KEY (MaSV) REFERENCES sinhvien(MaSV)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
";

if (mysqli_multi_query($conn, $sqlTableSchema)) {
    echo "<h3>2. Tạo các bảng thành công!</h3>";
    echo "<ul>
            <li>Bảng phong</li>
            <li>Bảng sinhvien</li>
            <li>Bảng diennuoc</li>
            <li>Bảng hopdong</li>
            <li>Bảng suco</li>
            <li>Bảng thanhtoan</li>
          </ul>";

    while (mysqli_next_result($conn)) {;}
} else {
    echo "Lỗi tạo bảng: " . mysqli_error($conn);
}

mysqli_close($conn);

echo "<hr><i>Setup hoàn tất. Hãy xoá file setup.php sau khi sử dụng để bảo mật.</i>";
?>

<html>
    <a href="index.php">Quay về trang chủ</a>
</html>
