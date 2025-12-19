<?php include "../menu.php"; ?>
<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $OK = 1;

    if (!empty($_POST['MaPhong'])) {
        $MaPhong = trim($_POST['MaPhong']);
    } else {
        $error_MaPhong = "Mã phòng không được để trống";
        $OK = 0;
    }

    if (!empty($_POST['Thang'])) {
        $Thang = trim($_POST['Thang']);
    } else {
        $error_Thang = "Tháng không được để trống";
        $OK = 0;
    }

    if (!empty($_POST['SoDien'])) {
        $SoDien = $_POST['SoDien'];
        if (!is_numeric($SoDien) || $SoDien < 0) {
            $error_SoDien = "Số điện phải là số và >= 0";
            $OK = 0;
        }
    } else {
        $error_SoDien = "Số điện không được để trống";
        $OK = 0;
    }

    if (!empty($_POST['SoNuoc'])) {
        $SoNuoc = $_POST['SoNuoc'];
        if (!is_numeric($SoNuoc) || $SoNuoc < 0) {
            $error_SoNuoc = "Số nước phải là số và >= 0";
            $OK = 0;
        }
    } else {
        $error_SoNuoc = "Số nước không được để trống";
        $OK = 0;
    }

    if ($OK == 1) {
        $sql = "INSERT INTO diennuoc(MaPhong, Thang, SoDien, SoNuoc)
                VALUES ('$MaPhong', '$Thang', '$SoDien', '$SoNuoc')";

        if (mysqli_query($con, $sql)) {
            $success = "Thêm điện nước thành công!";
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
    <title>Thêm điện nước</title>
</head>
<body>

<h2>Thêm điện nước</h2>

<?php 
if (isset($success)) echo "<p style='color:green;'>$success</p>";
if (isset($error_MaPhong)) echo "<p style='color:red;'>$error_MaPhong</p>";
if (isset($error_Thang)) echo "<p style='color:red;'>$error_Thang</p>";
if (isset($error_SoDien)) echo "<p style='color:red;'>$error_SoDien</p>";
if (isset($error_SoNuoc)) echo "<p style='color:red;'>$error_SoNuoc</p>";
if (isset($error_sql)) echo "<p style='color:red;'>$error_sql</p>";
?>

<form method="POST">

    Mã phòng:<br>
    <input type="text" name="MaPhong" required><br><br>

    Tháng:<br>
    <input type="text" name="Thang" placeholder="VD: 2025-01" required><br><br>

    Số điện:<br>
    <input type="number" name="SoDien" min="0" required><br><br>

    Số nước:<br>
    <input type="number" name="SoNuoc" min="0" required><br><br>

    <input type="submit" value="Thêm điện nước">

</form>

<br>

<!-- Nút quay về danh sách -->
<a href="index.php"><button> Quay về danh sách điện nước</button></a>

</body>
</html>

<?php mysqli_close($con); ?>
