<?php
/* ========================= KẾT NỐI DATABASE ======================= */
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

echo "<h2>Tạo hợp đồng ngẫu nhiên</h2>";
echo "Đang xử lý...<br><br>";

/* ========================= CẤU HÌNH ======================= */
$soHopDongCanThem = 50;
$tinhTrangArr = ["Đang hiệu lực", "Hết hạn", "Chờ duyệt"];

/* ========================= HÀM TẠO MÃ HỢP ĐỒNG ======================= */
function taoMaHopDongNgauNhien($con) {
    do {
        $ma = "HD" . rand(1000, 9999);
        $check = mysqli_query($con, "SELECT MaHD FROM HopDong WHERE MaHD = '$ma'");
    } while (mysqli_num_rows($check) > 0);
    return $ma;
}

/* ========================= LẤY DANH SÁCH SINH VIÊN THỰC ======================= */
$dsSinhVien = [];
$querySV = mysqli_query($con, "SELECT MaSV FROM sinhvien");
while ($row = mysqli_fetch_assoc($querySV)) {
    $dsSinhVien[] = $row['MaSV'];
}

if (count($dsSinhVien) == 0) {
    die("Lỗi: Không có sinh viên nào trong CSDL. Vui lòng thêm sinh viên trước!");
}

/* ========================= LẤY DANH SÁCH PHÒNG THỰC ======================= */
$dsPhong = [];
$queryPhong = mysqli_query($con, "SELECT MaPhong FROM phong");
while ($row = mysqli_fetch_assoc($queryPhong)) {
    $dsPhong[] = $row['MaPhong'];
}

if (count($dsPhong) == 0) {
    die("Lỗi: Không có phòng nào trong CSDL. Vui lòng thêm phòng trước!");
}

echo "Tìm thấy " . count($dsSinhVien) . " sinh viên và " . count($dsPhong) . " phòng trong CSDL<br>";
echo "Bắt đầu tạo $soHopDongCanThem hợp đồng...<br><br>";

/* ========================= TẠO HỢP ĐỒNG NGẪU NHIÊN ======================= */
$thanhCong = 0;
$thatBai = 0;

for ($i = 0; $i < $soHopDongCanThem; $i++) {

    // Tạo mã hợp đồng ngẫu nhiên không trùng
    $MaHD = taoMaHopDongNgauNhien($con);

    // Lấy sinh viên ngẫu nhiên từ danh sách THỰC
    $MaSV = $dsSinhVien[array_rand($dsSinhVien)];

    // Lấy phòng ngẫu nhiên từ danh sách THỰC
    $MaPhong = $dsPhong[array_rand($dsPhong)];

    // Random ngày bắt đầu từ 01/01/2023 đến 31/12/2025
    $ngayBatDau = rand(strtotime("2023-01-01"), strtotime("2025-12-31"));
    $NgayBD = date("Y-m-d", $ngayBatDau);

    // Ngày kết thúc sau ngày bắt đầu từ 6-12 tháng
    $soThang = rand(6, 12);
    $ngayKetThuc = strtotime("+$soThang months", $ngayBatDau);
    $NgayKT = date("Y-m-d", $ngayKetThuc);

    // Random tình trạng
    $TinhTrang = $tinhTrangArr[array_rand($tinhTrangArr)];

    // SQL thêm hợp đồng
    $sql = "INSERT INTO HopDong (MaHD, MaSV, MaPhong, NgayBD, NgayKT, TinhTrang)
            VALUES ('$MaHD', '$MaSV', '$MaPhong', '$NgayBD', '$NgayKT', '$TinhTrang')";

    if (mysqli_query($con, $sql)) {
        $thanhCong++;
        echo "✓ Hợp đồng $MaHD | SV: $MaSV | Phòng: $MaPhong | $NgayBD → $NgayKT | $TinhTrang<br>";
    } else {
        $thatBai++;
        echo "✗ Lỗi hợp đồng $MaHD: " . mysqli_error($con) . "<br>";
    }
}

/* ========================= THỐNG KÊ KẾT QUẢ ======================= */
echo "<br><hr><br>";
echo "<strong>KẾT QUẢ:</strong><br>";
echo "Thành công: $thanhCong hợp đồng<br>";
echo "Thất bại: $thatBai hợp đồng<br>";

mysqli_close($con);
?>

<br>
<a href="index.php" style="
    display: inline-block;
    padding: 8px 12px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
">Quay về danh sách</a>
<br><br>
```

