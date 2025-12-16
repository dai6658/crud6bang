<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management", 3306);

if (mysqli_connect_errno()) {
    echo "Không thể kết nối MySQL: " . mysqli_connect_error();
    exit();
}

echo "Kết nối thành công!<br><br>";

// Lấy danh sách MaSV từ bảng sinhvien
$svQuery = mysqli_query($con, "SELECT MaSV FROM sinhvien");
$dsMaSV = [];

while ($row = mysqli_fetch_assoc($svQuery)) {
    $dsMaSV[] = $row['MaSV'];
}

if (count($dsMaSV) == 0) {
    die("Không có sinh viên nào trong bảng sinhvien → Không thể tạo thanh toán!");
}

// Danh sách nội dung
$noidungList = [
    "Đóng tiền phòng",
    "Đóng tiền điện",
    "Đóng tiền nước",
    "Đóng tiền internet",
    "Phí vệ sinh",
    "Phí an ninh"
];

// Tạo 50 thanh toán
for ($i = 1; $i <= 50; $i++) {

    // Chọn 1 sinh viên hợp lệ
    $MaSV = $dsMaSV[array_rand($dsMaSV)];

    // Mã thanh toán
    $MaTT = "TT" . str_pad($i, 4, "0", STR_PAD_LEFT);

    // Số tiền
    $SoTien = rand(500000, 5000000);

    // Ngày thanh toán (ngẫu nhiên 1 năm trở lại)
    $NgayTT = date("Y-m-d", strtotime("-" . rand(1, 365) . " days"));

    // Nội dung
    $NoiDung = $noidungList[array_rand($noidungList)];

    // INSERT
    $sql = "INSERT INTO thanhtoan (MaTT, MaSV, SoTien, NgayTT, NoiDung)
            VALUES ('$MaTT', '$MaSV', '$SoTien', '$NgayTT', '$NoiDung')";

    if (mysqli_query($con, $sql)) {
        echo "Đã thêm thanh toán $MaTT cho sinh viên $MaSV<br>";
    } else {
        echo "Lỗi khi thêm $MaTT: " . mysqli_error($con) . "<br>";
    }
}

mysqli_close($con);
?>

<html>
    <a href="index.php">Quay về giao diện xem</a><br><br>
</html>
