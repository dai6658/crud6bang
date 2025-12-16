<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

echo "Kết nối thành công!<br><br>";

// Lấy danh sách phòng hiện có
$dsPhong = mysqli_query($con, "SELECT MaPhong FROM phong");
$phongArr = [];

while ($row = mysqli_fetch_assoc($dsPhong)) {
    $phongArr[] = $row['MaPhong'];
}

// Nếu không có phòng thì dừng
if (count($phongArr) == 0) {
    die("Không có phòng trong bảng phong!");
}

$soDongCanThem = 20;

// Hàm tạo tháng ngẫu nhiên
function randomMonth() {
    $year = rand(2023, 2025);
    $month = rand(1, 12);
    return sprintf("%04d-%02d", $year, $month);
}

for ($i = 0; $i < $soDongCanThem; $i++) {

    // Random mã phòng từ danh sách
    $MaPhong = $phongArr[array_rand($phongArr)];

    // Random tháng
    $Thang = randomMonth();

    // Random số điện & nước
    $SoDien = rand(20, 500);
    $SoNuoc = rand(10, 200);

    // SQL thêm vào bảng diennuoc
    $sql = "INSERT INTO diennuoc (MaPhong, Thang, SoDien, SoNuoc)
            VALUES ('$MaPhong', '$Thang', '$SoDien', '$SoNuoc')";

    if (mysqli_query($con, $sql)) {
        echo "Thêm điện nước cho phòng $MaPhong - tháng $Thang thành công<br>";
    } else {
        echo "Lỗi: " . mysqli_error($con) . "<br>";
    }
}

mysqli_close($con);
?>
<html>
    <a href="index.php">Quay về giao diện xem</a>
</html>
