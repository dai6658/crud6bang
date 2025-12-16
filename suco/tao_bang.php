<?php
// Tao cac bang cho CSDL ktx_management (cach don gian)
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Khong ket noi duoc CSDL ktx_management: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8mb4");

// 1) Bang phong (can tao truoc vi cac bang khac tham chieu)
$sql = "CREATE TABLE IF NOT EXISTS phong (
    MaPhong VARCHAR(20) NOT NULL PRIMARY KEY,
    LoaiPhong VARCHAR(50),
    SoNguoiToiDa INT,
    TinhTrang VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($con, $sql) or die("Loi tao bang phong: " . mysqli_error($con));

// 2) Bang sinhvien
$sql = "CREATE TABLE IF NOT EXISTS sinhvien (
    MaSV VARCHAR(20) NOT NULL PRIMARY KEY,
    HoTen VARCHAR(100) NOT NULL,
    NgaySinh DATE NOT NULL,
    GioiTinh VARCHAR(10),
    Lop VARCHAR(50),
    SDT VARCHAR(15),
    DiaChi VARCHAR(200)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($con, $sql) or die("Loi tao bang sinhvien: " . mysqli_error($con));

// 3) Bang hopdong (tham chieu MaSV, MaPhong)
$sql = "CREATE TABLE IF NOT EXISTS hopdong (
    MaHD VARCHAR(20) NOT NULL PRIMARY KEY,
    MaSV VARCHAR(20),
    MaPhong VARCHAR(20),
    NgayBD DATE,
    NgayKT DATE,
    TinhTrang VARCHAR(30),
    KEY idx_ma_sv (MaSV),
    KEY idx_ma_phong (MaPhong),
    CONSTRAINT fk_hd_sv FOREIGN KEY (MaSV) REFERENCES sinhvien(MaSV),
    CONSTRAINT fk_hd_phong FOREIGN KEY (MaPhong) REFERENCES phong(MaPhong)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($con, $sql) or die("Loi tao bang hopdong: " . mysqli_error($con));

// 4) Bang suco (tham chieu MaPhong)
$sql = "CREATE TABLE IF NOT EXISTS suco (
    MaSC INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    MaPhong VARCHAR(20),
    MoTa VARCHAR(255),
    NgayBao DATE,
    TrangThai VARCHAR(50),
    KEY idx_ma_phong (MaPhong),
    CONSTRAINT fk_suco_phong FOREIGN KEY (MaPhong) REFERENCES phong(MaPhong)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($con, $sql) or die("Loi tao bang suco: " . mysqli_error($con));

// 5) Bang diennuoc (tham chieu MaPhong)
$sql = "CREATE TABLE IF NOT EXISTS diennuoc (
    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    MaPhong VARCHAR(20),
    Thang VARCHAR(20),
    SoDien INT,
    SoNuoc INT,
    KEY idx_ma_phong (MaPhong),
    CONSTRAINT fk_diennuoc_phong FOREIGN KEY (MaPhong) REFERENCES phong(MaPhong)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($con, $sql) or die("Loi tao bang diennuoc: " . mysqli_error($con));

// 6) Bang thanhtoan (tham chieu MaSV)
$sql = "CREATE TABLE IF NOT EXISTS thanhtoan (
    MaTT INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    MaSV VARCHAR(20),
    SoTien INT,
    NgayTT DATE,
    NoiDung VARCHAR(200),
    KEY idx_ma_sv (MaSV),
    CONSTRAINT fk_tt_sv FOREIGN KEY (MaSV) REFERENCES sinhvien(MaSV)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($con, $sql) or die("Loi tao bang thanhtoan: " . mysqli_error($con));

// Du lieu mau nho de test
mysqli_query($con, "INSERT INTO phong (MaPhong, LoaiPhong, SoNguoiToiDa, TinhTrang)
    VALUES ('P101','A',6,'Trong'), ('P102','B',8,'Dang o')
    ON DUPLICATE KEY UPDATE LoaiPhong=VALUES(LoaiPhong), SoNguoiToiDa=VALUES(SoNguoiToiDa), TinhTrang=VALUES(TinhTrang)");

mysqli_query($con, "INSERT INTO suco (MaPhong, MoTa, NgayBao, TrangThai)
    VALUES ('P101','Bong den hong','2025-12-01','Chua xu ly'),
           ('P102','Vo tay nam cua','2025-12-02','Dang xu ly')");

echo "Da tao bang va them du lieu mau (neu chua co).";

mysqli_close($con);
unset($sql);
?>
