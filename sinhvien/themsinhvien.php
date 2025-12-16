<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (mysqli_connect_errno()) {
    echo "Không thể kết nối MySQL: " . mysqli_connect_error();
    exit();
}

echo "Kết nối thành công!<br><br>";

$ho = ["Nguyễn", "Trần", "Lê", "Phạm", "Hoàng", "Vũ", "Đặng", "Bùi"];
$dem = ["Văn", "Thị", "Hữu", "Đức", "Minh", "Quang", "Thanh", "Ngọc", "Xuân", "Tuấn"];
$ten = ["An", "Bình", "Châu", "Dũng", "Huy", "Khánh", "Linh", "Mai", "Nam", "Phong", "Quân", "Trang", "Vy", "Yến"];

$lop = ["CNTT1", "CNTT2", "CNTT3", "Công nghệ phần mềm 1", "HTTT1", "HTTT2"];
$diachi = ["Hà Nội", "Hải Phòng", "Nam Định", "Nghệ An", "Thanh Hóa", "Đà Nẵng", "TP.HCM"];

$used_MaSV = []; // tránh trùng mã sinh viên

for ($i = 1; $i <= 50; $i++) {

    // Tạo mã sinh viên ngẫu nhiên, đảm bảo không trùng
    do {
        $MaSV = rand(2221050000, 2231050000);
    } while (in_array($MaSV, $used_MaSV));

    $used_MaSV[] = $MaSV;

    // Tạo họ tên
    $HoTen = $ho[array_rand($ho)] . " " . $dem[array_rand($dem)] . " " . $ten[array_rand($ten)];

    // Ngày sinh (1999–2005)
    $year = rand(1999, 2005);
    $month = rand(1, 12);
    $day = rand(1, 28);
    $NgaySinh = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);

    // Giới tính
    $GioiTinh = rand(0, 1) ? "Nam" : "Nữ";

    // Lớp
    $LopChon = $lop[array_rand($lop)];

    // Số điện thoại ngẫu nhiên
    $SDT = "09" . rand(10000000, 99999999);

    // Địa chỉ
    $DiaChiChon = $diachi[array_rand($diachi)];

    // SQL
    $sql = "INSERT INTO sinhvien (MaSV, HoTen, NgaySinh, GioiTinh, Lop, SDT, DiaChi)
            VALUES ('$MaSV', '$HoTen', '$NgaySinh', '$GioiTinh', '$LopChon', '$SDT', '$DiaChiChon')";

    if (mysqli_query($con, $sql)) {
        echo " Thêm sinh viên $MaSV thành công<br>";
    } else {
        echo " Lỗi với $MaSV: " . mysqli_error($con) . "<br>";
    }
}

mysqli_close($con);

?>
<html>
    <a href="index.php"> quay về giao diện xem</a><br><br>
    </html>
