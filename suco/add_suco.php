<?php include "../menu.php"; ?>
<?php
// Kết nối MySQL đơn giản, hiển thị lỗi dễ hiểu
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "ktx_management";

$con = mysqli_connect($dbHost, $dbUser, $dbPass);
if (!$con) {
    die("Không kết nối được MySQL: " . mysqli_connect_error());
}
if (!mysqli_select_db($con, $dbName)) {
    die("Chưa có database '$dbName'");
}
mysqli_set_charset($con, "utf8mb4");

// Kiểm tra bảng suco tồn tại
$checkSuco = mysqli_query($con, "SHOW TABLES LIKE 'suco'");
if (!$checkSuco || mysqli_num_rows($checkSuco) == 0) {
    die("Chưa có bảng 'suco'. Hãy tạo bảng này trước khi sử dụng.");
}

$success = "";
$errors = [];
$MaPhong = $MoTa = $NgayBao = $TrangThai = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $MaPhong   = trim($_POST["MaPhong"] ?? "");
    $MoTa      = trim($_POST["MoTa"] ?? "");
    $NgayBao   = trim($_POST["NgayBao"] ?? "");
    $TrangThai = trim($_POST["TrangThai"] ?? "");

    // Kiểm tra đơn giản
    if ($MaPhong === "" || strlen($MaPhong) > 20) {
        $errors[] = "Mã phòng bắt buộc và tối đa 20 ký tự.";
    }
    if ($MoTa !== "" && strlen($MoTa) > 255) {
        $errors[] = "Mô tả tối đa 255 ký tự.";
    }
    if ($NgayBao === "") {
        $errors[] = "Ngày báo bắt buộc.";
    }
    if ($TrangThai === "" || strlen($TrangThai) > 50) {
        $errors[] = "Trạng thái bắt buộc và tối đa 50 ký tự.";
    }

    if (empty($errors)) {
        // Ép dữ liệu trước khi ghi
        $mp  = mysqli_real_escape_string($con, $MaPhong);
        $mt  = mysqli_real_escape_string($con, $MoTa);
        $nb  = mysqli_real_escape_string($con, $NgayBao);
        $tt  = mysqli_real_escape_string($con, $TrangThai);

        $sql = "INSERT INTO suco (MaPhong, MoTa, NgayBao, TrangThai)
                VALUES ('$mp', '$mt', '$nb', '$tt')";
        if (mysqli_query($con, $sql)) {
            $success   = "Thêm sự cố thành công.";
            $MaPhong = $MoTa = $NgayBao = $TrangThai = "";
        } else {
            $errors[] = "Lỗi ghi dữ liệu: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sự cố</title>
</head>
<body>
    <h2>Thêm sự cố</h2>

    <?php if ($success !== ""): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php foreach ($errors as $e): ?>
        <p style="color:red;"><?php echo htmlspecialchars($e); ?></p>
    <?php endforeach; ?>

    <form method="post">
        Mã phòng:<br>
        <input type="text" name="MaPhong" maxlength="20" required value="<?php echo htmlspecialchars($MaPhong); ?>"><br><br>

        Mô tả:<br>
        <textarea name="MoTa" maxlength="255"><?php echo htmlspecialchars($MoTa); ?></textarea><br><br>

        Ngày báo:<br>
        <input type="date" name="NgayBao" required value="<?php echo htmlspecialchars($NgayBao); ?>"><br><br>

        Trạng thái:<br>
        <input type="text" name="TrangThai" maxlength="50" required value="<?php echo htmlspecialchars($TrangThai); ?>"><br><br>

        <input type="submit" value="Thêm sự cố">
    </form>

    <br>
    <a href="index_suco.php">Quay về danh sách sự cố</a>
</body>
</html>

<?php mysqli_close($con); ?>
