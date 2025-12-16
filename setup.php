<?php
// Cấu hình kết nối
$servername = "localhost";
$username = "root"; // User mặc định của XAMPP
$password = "";     // Pass mặc định của XAMPP (để trống)

// 1. Tạo kết nối
$conn = new mysqli($servername, $username, $password);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// 2. Tạo Database
$dbName = "ktx_management";
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if ($conn->query($sqlCreateDB) === TRUE) {
    echo "<h3>1. Kiểm tra Database: '$dbName' đã sẵn sàng.</h3>";
} else {
    die("Lỗi tạo Database: " . $conn->error);
}

// Chọn Database để làm việc
$conn->select_db($dbName);

// 3. Câu lệnh SQL tạo bảng
// Lưu ý: Sử dụng SET FOREIGN_KEY_CHECKS=0 để tránh lỗi khi tạo bảng tham chiếu đến bảng chưa tồn tại
$sqlTableSchema = "
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET FOREIGN_KEY_CHECKS = 0;

-- Bảng Phòng (Cần tạo trước hoặc tắt check FK)
CREATE TABLE IF NOT EXISTS `phong` (
  `MaPhong` varchar(20) NOT NULL,
  `LoaiPhong` varchar(50) DEFAULT NULL,
  `SoNguoiToiDa` int(11) DEFAULT NULL,
  `TinhTrang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`MaPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Sinh Viên
CREATE TABLE IF NOT EXISTS `sinhvien` (
  `MaSV` varchar(20) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` varchar(10) DEFAULT NULL,
  `Lop` varchar(50) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `DiaChi` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`MaSV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Điện Nước
CREATE TABLE IF NOT EXISTS `diennuoc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MaPhong` varchar(20) DEFAULT NULL,
  `Thang` varchar(20) DEFAULT NULL,
  `SoDien` int(11) DEFAULT NULL,
  `SoNuoc` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MaPhong` (`MaPhong`),
  CONSTRAINT `diennuoc_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Hợp Đồng
CREATE TABLE IF NOT EXISTS `hopdong` (
  `MaHD` varchar(20) NOT NULL,
  `MaSV` varchar(20) DEFAULT NULL,
  `MaPhong` varchar(20) DEFAULT NULL,
  `NgayBD` date DEFAULT NULL,
  `NgayKT` date DEFAULT NULL,
  `TinhTrang` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`MaHD`),
  KEY `MaSV` (`MaSV`),
  KEY `MaPhong` (`MaPhong`),
  CONSTRAINT `hopdong_ibfk_1` FOREIGN KEY (`MaSV`) REFERENCES `sinhvien` (`MaSV`),
  CONSTRAINT `hopdong_ibfk_2` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Sự Cố
CREATE TABLE IF NOT EXISTS `suco` (
  `MaSC` int(11) NOT NULL AUTO_INCREMENT,
  `MaPhong` varchar(20) DEFAULT NULL,
  `MoTa` varchar(255) DEFAULT NULL,
  `NgayBao` date DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`MaSC`),
  KEY `MaPhong` (`MaPhong`),
  CONSTRAINT `suco_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Thanh Toán
CREATE TABLE IF NOT EXISTS `thanhtoan` (
  `MaTT` int(11) NOT NULL AUTO_INCREMENT,
  `MaSV` varchar(20) DEFAULT NULL,
  `SoTien` int(11) DEFAULT NULL,
  `NgayTT` date DEFAULT NULL,
  `NoiDung` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`MaTT`),
  KEY `MaSV` (`MaSV`),
  CONSTRAINT `thanhtoan_ibfk_1` FOREIGN KEY (`MaSV`) REFERENCES `sinhvien` (`MaSV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
";

// 4. Thực thi tạo bảng
if ($conn->multi_query($sqlTableSchema)) {
    echo "<h3>2. Tạo các bảng thành công!</h3>";
    echo "<ul>";
    echo "<li>Bảng: phong</li>";
    echo "<li>Bảng: sinhvien</li>";
    echo "<li>Bảng: diennuoc</li>";
    echo "<li>Bảng: hopdong</li>";
    echo "<li>Bảng: suco</li>";
    echo "<li>Bảng: thanhtoan</li>";
    echo "</ul>";
    
    // Xử lý hết các result set để tránh lỗi đồng bộ
    while ($conn->next_result()) {;} 
} else {
    echo "Lỗi tạo bảng: " . $conn->error;
}

$conn->close();

echo "<hr><i>Setup hoàn tất. Hãy xóa file setup.php sau khi sử dụng để bảo mật.</i>";
?>
<html>
    <a href="index.php"> quay về trang chủ</a>
</html>