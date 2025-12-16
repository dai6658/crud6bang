<?php include "../menu.php"; ?>
<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $OK = 1;

    if (!empty($_POST['MaSV'])) {
        $MaSV = trim($_POST['MaSV']);
        if (strlen($MaSV) > 10) {
            $error_MaSV = "Mã sinh viên tối đa 10 ký tự";
            $OK = 0;
        }
    } else {
        $error_MaSV = "Mã sinh viên không được để trống";
        $OK = 0;
    }

    if (!empty($_POST['HoTen'])) {
        $HoTen = trim($_POST['HoTen']);
    } else {
        $error_HoTen = "Họ tên không được để trống";
        $OK = 0;
    }

    if (!empty($_POST['NgaySinh'])) {
        $NgaySinh = $_POST['NgaySinh'];
    } else {
        $error_NgaySinh = "Ngày sinh không được để trống";
        $OK = 0;
    }

    if (!empty($_POST['GioiTinh'])) {
        $GioiTinh = $_POST['GioiTinh'];
        if ($GioiTinh !== "Nam" && $GioiTinh !== "Nữ") {
            $error_GioiTinh = "Giới tính phải là Nam hoặc Nữ";
            $OK = 0;
        }
    } else {
        $error_GioiTinh = "Vui lòng chọn giới tính";
        $OK = 0;
    }

    $Lop = $_POST['Lop'];

    $SDT = $_POST['SDT'];

    $DiaChi = $_POST['DiaChi'];

    if ($OK == 1) {

        $sql = "INSERT INTO sinhvien(MaSV, HoTen, NgaySinh, GioiTinh, Lop, SDT, DiaChi)
                VALUES ('$MaSV', '$HoTen', '$NgaySinh', '$GioiTinh', '$Lop', '$SDT', '$DiaChi')";

        if (mysqli_query($con, $sql)) {
            $success = "Thêm sinh viên thành công!";
        } else {
            $error_sql = "Lỗi SQL: " . mysqli_error($con);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sinh viên</title>
</head>
<body>

<h2>Thêm sinh viên</h2>

<?php 
if (isset($success)) echo "<p style='color:green;'>$success</p>";
if (isset($error_MaSV)) echo "<p style='color:red;'>$error_MaSV</p>";
if (isset($error_HoTen)) echo "<p style='color:red;'>$error_HoTen</p>";
if (isset($error_NgaySinh)) echo "<p style='color:red;'>$error_NgaySinh</p>";
if (isset($error_GioiTinh)) echo "<p style='color:red;'>$error_GioiTinh</p>";
if (isset($error_sql)) echo "<p style='color:red;'>$error_sql</p>";
?>

<form method="POST">

    Mã sinh viên:<br>
    <input type="text" name="MaSV" maxlength="10" required><br><br>

    Họ tên:<br>
    <input type="text" name="HoTen" required><br><br>

    Ngày sinh:<br>
    <input type="date" name="NgaySinh" required><br><br>

    Giới tính:<br>
    <select name="GioiTinh" required>
        <option value="">-- chọn giới tính --</option>
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
    </select>
    <br><br>

    Lớp:<br>
    <input type="text" name="Lop"><br><br>

    Số điện thoại:<br>
    <input type="text" name="SDT"><br><br>

    Địa chỉ:<br>
    <input type="text" name="DiaChi"><br><br>

    <input type="submit" value="Thêm sinh viên">

</form>

<br>

<!-- Nút quay về danh sách -->
<a href="index.php"><button> Quay về danh sách sinh viên</button></a>

</body>
</html>

<?php mysqli_close($con); ?>
