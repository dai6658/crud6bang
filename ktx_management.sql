-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 22, 2025 lúc 11:16 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ktx_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diennuoc`
--

CREATE TABLE `diennuoc` (
  `ID` int(11) NOT NULL,
  `MaPhong` varchar(20) DEFAULT NULL,
  `Thang` varchar(20) DEFAULT NULL,
  `SoDien` int(11) DEFAULT NULL,
  `SoNuoc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diennuoc`
--

INSERT INTO `diennuoc` (`ID`, `MaPhong`, `Thang`, `SoDien`, `SoNuoc`) VALUES
(2, '1', '5', 444, 44444);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hopdong`
--

CREATE TABLE `hopdong` (
  `MaHD` varchar(20) NOT NULL,
  `MaSV` varchar(20) DEFAULT NULL,
  `MaPhong` varchar(20) DEFAULT NULL,
  `NgayBD` date DEFAULT NULL,
  `NgayKT` date DEFAULT NULL,
  `TinhTrang` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phong`
--

CREATE TABLE `phong` (
  `MaPhong` varchar(20) NOT NULL,
  `LoaiPhong` varchar(50) DEFAULT NULL,
  `SoNguoiToiDa` int(11) DEFAULT NULL,
  `TinhTrang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phong`
--

INSERT INTO `phong` (`MaPhong`, `LoaiPhong`, `SoNguoiToiDa`, `TinhTrang`) VALUES
('1', '4', 6, '66');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sinhvien`
--

CREATE TABLE `sinhvien` (
  `MaSV` varchar(20) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` varchar(10) DEFAULT NULL,
  `Lop` varchar(50) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `DiaChi` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sinhvien`
--

INSERT INTO `sinhvien` (`MaSV`, `HoTen`, `NgaySinh`, `GioiTinh`, `Lop`, `SDT`, `DiaChi`) VALUES
('123456', 'ntd', '2004-05-08', 'Nam', '9', '0000', '1aa'),
('2313', '31323', '3333-02-02', 'Nam', '2', '2', '2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suco`
--

CREATE TABLE `suco` (
  `MaSC` int(11) NOT NULL,
  `MaPhong` varchar(20) DEFAULT NULL,
  `MoTa` varchar(255) DEFAULT NULL,
  `NgayBao` date DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `suco`
--

INSERT INTO `suco` (`MaSC`, `MaPhong`, `MoTa`, `NgayBao`, `TrangThai`) VALUES
(1, '1', 'ắc quy hỏng', '2025-11-05', 'qqweqw');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `MaTT` int(11) NOT NULL,
  `MaSV` varchar(20) DEFAULT NULL,
  `SoTien` int(11) DEFAULT NULL,
  `NgayTT` date DEFAULT NULL,
  `NoiDung` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhtoan`
--

INSERT INTO `thanhtoan` (`MaTT`, `MaSV`, `SoTien`, `NgayTT`, `NoiDung`) VALUES
(5, '123456', 8888888, '0088-08-08', '888');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `diennuoc`
--
ALTER TABLE `diennuoc`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MaPhong` (`MaPhong`);

--
-- Chỉ mục cho bảng `hopdong`
--
ALTER TABLE `hopdong`
  ADD PRIMARY KEY (`MaHD`),
  ADD KEY `MaSV` (`MaSV`),
  ADD KEY `MaPhong` (`MaPhong`);

--
-- Chỉ mục cho bảng `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`MaPhong`);

--
-- Chỉ mục cho bảng `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`MaSV`);

--
-- Chỉ mục cho bảng `suco`
--
ALTER TABLE `suco`
  ADD PRIMARY KEY (`MaSC`),
  ADD KEY `MaPhong` (`MaPhong`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`MaTT`),
  ADD KEY `MaSV` (`MaSV`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `diennuoc`
--
ALTER TABLE `diennuoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `suco`
--
ALTER TABLE `suco`
  MODIFY `MaSC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `MaTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `diennuoc`
--
ALTER TABLE `diennuoc`
  ADD CONSTRAINT `diennuoc_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`);

--
-- Các ràng buộc cho bảng `hopdong`
--
ALTER TABLE `hopdong`
  ADD CONSTRAINT `hopdong_ibfk_1` FOREIGN KEY (`MaSV`) REFERENCES `sinhvien` (`MaSV`),
  ADD CONSTRAINT `hopdong_ibfk_2` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`);

--
-- Các ràng buộc cho bảng `suco`
--
ALTER TABLE `suco`
  ADD CONSTRAINT `suco_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`);

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `thanhtoan_ibfk_1` FOREIGN KEY (`MaSV`) REFERENCES `sinhvien` (`MaSV`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
