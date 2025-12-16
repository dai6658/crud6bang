<?php include "../menu.php"; ?>
<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $OK = 1;

    // --- Mã phòng ---
    if (!empty($_POST['MaPhong'])) {
        $MaPhong = trim($_POST['MaPhong']);
        if (strlen($MaPhong) > 10) {
            $error_MaPhong = "Mã phòng tối đa 10 ký tự";
            $OK = 0;
        }
    } else {
        $error_MaPhong = "Mã phòng không được để trống";
        $OK = 0;
    }

    // --- Loại phòng ---
    if (!empty($_POST['LoaiPhong'])) {
        $LoaiPhong = trim($_POST['LoaiPhong']);
    } else {
        $error_LoaiPhong = "Loại phòng không được để trống";
        $OK = 0;
    }

    // --- Số người tối đa ---
    if (!empty($_POST['SoNguoiToiDa'])) {
        $SoNguoiToiDa = (int)$_POST['SoNguoiToiDa'];
        if ($SoNguoiToiDa < 0) {
            $error_SoNguoi = "Số người tối đa không được âm";
            $OK = 0;
        }
    } else {
        $error_SoNguoi = "Số người tối đa không được để trống";
        $OK = 0;
    }

    // --- Tình trạng ---
    if (!empty($_POST['TinhTrang'])) {
        $TinhTrang = trim($_POST['TinhTrang']);
    } else {
        $error_TinhTrang = "Tình trạng không được để trống";
        $OK = 0;
    }

    // --- Nếu không lỗi ---
    if ($OK == 1) {
        $sql = "INSERT INTO phong(MaPhong, LoaiPhong, SoNguoiToiDa, TinhTrang)
                VALUES ('$MaPhong', '$LoaiPhong', '$SoNguoiToiDa', '$TinhTrang')";

        if (mysqli_query($con, $sql)) {
            $success = "Thêm phòng thành công!";
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
    <title>Thêm phòng</title>
</head>
<body>

<h2>Thêm phòng</h2>

<?php
if (isset($success)) echo "<p style='color:green;'>$success</p>";
if (isset($error_MaPhong)) echo "<p style='color:red;'>$error_MaPhong</p>";
if (isset($error_LoaiPhong)) echo "<p style='color:red;'>$error_LoaiPhong</p>";
if (isset($error_SoNguoi)) echo "<p style='color:red;'>$error_SoNguoi</p>";
if (isset($error_TinhTrang)) echo "<p style='color:red;'>$error_TinhTrang</p>";
if (isset($error_sql)) echo "<p style='color:red;'>$error_sql</p>";
?>

<form method="POST">

    Mã phòng:<br>
    <input type="text" name="MaPhong" maxlength="10" required><br><br>

    Loại phòng:<br>
    <input type="text" name="LoaiPhong" required><br><br>

    Số người tối đa:<br>
    <input type="number" name="SoNguoiToiDa" min="0" required><br><br>

    Tình trạng:<br>
    <input type="text" name="TinhTrang" required><br><br>

    <input type="submit" value="Thêm phòng">

</form>

<br>
<a href="index.php"><button>Quay về danh sách phòng</button></a>

</body>
</html>

<?php mysqli_close($con); ?>
