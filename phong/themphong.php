<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

echo "Kết nối thành công!<br><br>";

$loaiPhongArr = ["A", "B", "C"];
$tinhTrangArr = ["Trống", "Đầy", "Bảo trì"];

$soPhongCanThem = 20;

function taoMaPhongNgauNhien($con) {
    do {
        $ma = rand(1, 9999);
        $check = mysqli_query($con, "SELECT MaPhong FROM phong WHERE MaPhong = '$ma'");
    } while (mysqli_num_rows($check) > 0);
    return $ma;
}

for ($i = 0; $i < $soPhongCanThem; $i++) {

    // Tạo mã phòng ngẫu nhiên không trùng
    $MaPhong = taoMaPhongNgauNhien($con);

    // Random loại phòng
    $LoaiPhong = $loaiPhongArr[array_rand($loaiPhongArr)];

    // Random số người theo loại phòng
    if ($LoaiPhong == "A") {
        $SoNguoiToiDa = rand(8, 12);
    } elseif ($LoaiPhong == "B") {
        $SoNguoiToiDa = rand(6, 10);
    } else {
        $SoNguoiToiDa = rand(4, 8);
    }

    // Random tình trạng
    $TinhTrang = $tinhTrangArr[array_rand($tinhTrangArr)];

    // SQL thêm phòng
    $sql = "INSERT INTO phong (MaPhong, LoaiPhong, SoNguoiToiDa, TinhTrang)
            VALUES ('$MaPhong', '$LoaiPhong', '$SoNguoiToiDa', '$TinhTrang')";

    if (mysqli_query($con, $sql)) {
        echo "Thêm phòng $MaPhong thành công<br>";
    } else {
        echo "Lỗi với phòng $MaPhong: " . mysqli_error($con) . "<br>";
    }
}

mysqli_close($con);
?>
<html>
    <a href="index.php">Quay về giao diện xem</a><br><br>
</html>
