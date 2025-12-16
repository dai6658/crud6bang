<?php
// Thêm dữ liệu mẫu cho bảng suco 
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "ktx_management";

$con = mysqli_connect($dbHost, $dbUser, $dbPass);
if (!$con) {
    die("Không kết nối được MySQL: " . mysqli_connect_error());
}
if (!mysqli_select_db($con, $dbName)) {
    die("Chưa có database '$dbName'. Vào phpMyAdmin tạo database này và bảng 'suco' trước.");
}
mysqli_set_charset($con, "utf8mb4");

// Kiểm tra bảng suco tồn tại
$checkSuco = mysqli_query($con, "SHOW TABLES LIKE 'suco'");
if (!$checkSuco || mysqli_num_rows($checkSuco) == 0) {
    die("Chưa có bảng 'suco'. Hãy tạo bảng này trước khi sử dụng.");
}

echo "Kết nối thành công.<br><br>";

// Lấy danh sách mã phòng
$phongs = [];
$res = mysqli_query($con, "SELECT MaPhong FROM phong");
if ($res) {
    while ($r = mysqli_fetch_assoc($res)) {
        $phongs[] = $r["MaPhong"];
    }
}
if (empty($phongs)) {
    $phongs = ["P101"];
}

$motaArr = [
    "Đèn hỏng",
    "Khóa cửa kẹt",
    "Ống nước rỉ",
    "Ổ cắm cháy",
    "Cửa sổ kêu",
    "Máy lạnh yếu",
    "Quạt trần rung",
    "Sàn thấm nước",
    "Tường nứt",
    "Bồn cầu nghẹt"
];

$statusArr = ["Chưa xử lý", "Đang xử lý", "Đã xử lý", "Bảo trì"];
$soCanThem = 20;

for ($i = 0; $i < $soCanThem; $i++) {
    $MaPhong   = $phongs[array_rand($phongs)];
    $MoTa      = $motaArr[array_rand($motaArr)];
    $NgayBao   = date("Y-m-d", strtotime("-" . rand(0, 60) . " days"));
    $TrangThai = $statusArr[array_rand($statusArr)];

    $mp = mysqli_real_escape_string($con, $MaPhong);
    $mt = mysqli_real_escape_string($con, $MoTa);
    $nb = mysqli_real_escape_string($con, $NgayBao);
    $tt = mysqli_real_escape_string($con, $TrangThai);

    $sql = "INSERT INTO suco (MaPhong, MoTa, NgayBao, TrangThai)
            VALUES ('$mp', '$mt', '$nb', '$tt')";
    if (mysqli_query($con, $sql)) {
        echo "Đã thêm sự cố: MaPhong=$MaPhong, MoTa=$MoTa, NgayBao=$NgayBao, TrangThai=$TrangThai<br>";
    } else {
        echo "Lỗi khi thêm (MaPhong=$MaPhong): " . mysqli_error($con) . "<br>";
    }
}

mysqli_close($con);
?>

<br>
<a href="index_suco.php">Quay về giao diện xem sự cố</a>
