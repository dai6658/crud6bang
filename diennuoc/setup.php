<?php
include "../db.php";

echo "<h2>Đang tạo các bảng...</h2>";

// Tắt kiểm tra foreign key tạm thời
$conn->query("SET FOREIGN_KEY_CHECKS=0");

// Xóa các bảng cũ nếu có (để tạo lại từ đầu)
$tables = ['thanhtoan', 'suco', 'hopdong', 'diennuoc', 'sinhvien', 'phong'];
foreach ($tables as $table) {
    $conn->query("DROP TABLE IF EXISTS `$table`");
    echo "Đã xóa bảng cũ: $table<br>";
}

// Tạo bảng phong (phải tạo trước vì có foreign key từ các bảng khác)
$sql_phong = "CREATE TABLE `phong` (
  `MaPhong` varchar(20) NOT NULL,
  `LoaiPhong` varchar(50) DEFAULT NULL,
  `SoNguoiToiDa` int(11) DEFAULT NULL,
  `TinhTrang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`MaPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_phong)) {
    echo "✓ Đã tạo bảng: phong<br>";
} else {
    echo "✗ Lỗi tạo bảng phong: " . $conn->error . "<br>";
}

// Tạo bảng sinhvien (phải tạo trước vì có foreign key từ các bảng khác)
$sql_sinhvien = "CREATE TABLE `sinhvien` (
  `MaSV` varchar(20) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` varchar(10) DEFAULT NULL,
  `Lop` varchar(50) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `DiaChi` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`MaSV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_sinhvien)) {
    echo "✓ Đã tạo bảng: sinhvien<br>";
} else {
    echo "✗ Lỗi tạo bảng sinhvien: " . $conn->error . "<br>";
}

// Tạo bảng diennuoc
$sql_diennuoc = "CREATE TABLE `diennuoc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MaPhong` varchar(20) DEFAULT NULL,
  `Thang` varchar(20) DEFAULT NULL,
  `SoDien` int(11) DEFAULT NULL,
  `SoNuoc` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MaPhong` (`MaPhong`),
  CONSTRAINT `diennuoc_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3";

if ($conn->query($sql_diennuoc)) {
    echo "✓ Đã tạo bảng: diennuoc<br>";
} else {
    echo "✗ Lỗi tạo bảng diennuoc: " . $conn->error . "<br>";
}

// Tạo bảng hopdong
$sql_hopdong = "CREATE TABLE `hopdong` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_hopdong)) {
    echo "✓ Đã tạo bảng: hopdong<br>";
} else {
    echo "✗ Lỗi tạo bảng hopdong: " . $conn->error . "<br>";
}

// Tạo bảng suco
$sql_suco = "CREATE TABLE `suco` (
  `MaSC` int(11) NOT NULL AUTO_INCREMENT,
  `MaPhong` varchar(20) DEFAULT NULL,
  `MoTa` varchar(255) DEFAULT NULL,
  `NgayBao` date DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`MaSC`),
  KEY `MaPhong` (`MaPhong`),
  CONSTRAINT `suco_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2";

if ($conn->query($sql_suco)) {
    echo "✓ Đã tạo bảng: suco<br>";
} else {
    echo "✗ Lỗi tạo bảng suco: " . $conn->error . "<br>";
}

// Tạo bảng thanhtoan
$sql_thanhtoan = "CREATE TABLE `thanhtoan` (
  `MaTT` int(11) NOT NULL AUTO_INCREMENT,
  `MaSV` varchar(20) DEFAULT NULL,
  `SoTien` int(11) DEFAULT NULL,
  `NgayTT` date DEFAULT NULL,
  `NoiDung` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`MaTT`),
  KEY `MaSV` (`MaSV`),
  CONSTRAINT `thanhtoan_ibfk_1` FOREIGN KEY (`MaSV`) REFERENCES `sinhvien` (`MaSV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=6";

if ($conn->query($sql_thanhtoan)) {
    echo "✓ Đã tạo bảng: thanhtoan<br>";
} else {
    echo "✗ Lỗi tạo bảng thanhtoan: " . $conn->error . "<br>";
}

// Bật lại kiểm tra foreign key
$conn->query("SET FOREIGN_KEY_CHECKS=1");

// Chèn dữ liệu mẫu
echo "<br><h3>Đang chèn dữ liệu mẫu...</h3>";

// Chèn dữ liệu vào bảng phong
$conn->query("INSERT INTO `phong` (`MaPhong`, `LoaiPhong`, `SoNguoiToiDa`, `TinhTrang`) VALUES ('1', '4', 6, '66')");
echo "✓ Đã chèn dữ liệu vào bảng: phong<br>";

// Chèn dữ liệu vào bảng sinhvien
$conn->query("INSERT INTO `sinhvien` (`MaSV`, `HoTen`, `NgaySinh`, `GioiTinh`, `Lop`, `SDT`, `DiaChi`) VALUES 
    ('123456', 'ntd', '2004-05-08', 'Nam', '9', '0000', '1aa'),
    ('2313', '31323', '3333-02-02', 'Nam', '2', '2', '2')");
echo "✓ Đã chèn dữ liệu vào bảng: sinhvien<br>";

// Chèn dữ liệu vào bảng diennuoc
$conn->query("INSERT INTO `diennuoc` (`ID`, `MaPhong`, `Thang`, `SoDien`, `SoNuoc`) VALUES (2, '1', '5', 444, 44444)");
echo "✓ Đã chèn dữ liệu vào bảng: diennuoc<br>";

// Chèn dữ liệu vào bảng suco
$conn->query("INSERT INTO `suco` (`MaSC`, `MaPhong`, `MoTa`, `NgayBao`, `TrangThai`) VALUES (1, '1', 'ắc quy hỏng', '2025-11-05', 'qqweqw')");
echo "✓ Đã chèn dữ liệu vào bảng: suco<br>";

// Chèn dữ liệu vào bảng thanhtoan
$conn->query("INSERT INTO `thanhtoan` (`MaTT`, `MaSV`, `SoTien`, `NgayTT`, `NoiDung`) VALUES (5, '123456', 8888888, '0088-08-08', '888')");
echo "✓ Đã chèn dữ liệu vào bảng: thanhtoan<br>";

echo "<br><h2 style='color: green;'>✓ Hoàn tất! Tất cả các bảng đã được tạo thành công.</h2>";
echo "<br><a href='index.php' style='display: inline-block; padding: 8px 12px; background: #3498db; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Xem danh sách điện nước</a>";
echo "<br><br>";
?>

