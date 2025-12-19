<?php include "../menu.php"; ?>
<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

$ID = $_GET['ID'];
$sql_select = "SELECT * FROM diennuoc WHERE ID='$ID'";
$result = mysqli_query($con, $sql_select);
$data = mysqli_fetch_array($result);

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
        $sql = "UPDATE diennuoc SET
                MaPhong='$MaPhong',
                Thang='$Thang',
                SoDien='$SoDien',
                SoNuoc='$SoNuoc'
                WHERE ID='$ID'";

        if (mysqli_query($con, $sql)) {
            header("Location: index.php");
            exit();
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
    <title>Sửa điện nước</title>
</head>
<body>

<h2>Sửa điện nước</h2>

<?php 
if (isset($error_MaPhong)) echo "<p style='color:red;'>$error_MaPhong</p>";
if (isset($error_Thang)) echo "<p style='color:red;'>$error_Thang</p>";
if (isset($error_SoDien)) echo "<p style='color:red;'>$error_SoDien</p>";
if (isset($error_SoNuoc)) echo "<p style='color:red;'>$error_SoNuoc</p>";
if (isset($error_sql)) echo "<p style='color:red;'>$error_sql</p>";
?>

<form method="POST">

    Mã phòng:<br>
    <input type="text" name="MaPhong" value="<?= $data['MaPhong'] ?>" required><br><br>

    Tháng:<br>
    <input type="text" name="Thang" value="<?= $data['Thang'] ?>" placeholder="VD: 2025-01" required><br><br>

    Số điện:<br>
    <input type="number" name="SoDien" value="<?= $data['SoDien'] ?>" min="0" required><br><br>

    Số nước:<br>
    <input type="number" name="SoNuoc" value="<?= $data['SoNuoc'] ?>" min="0" required><br><br>

    <input type="submit" value="Cập nhật">

</form>

<br>

<a href="index.php"><button> Quay về danh sách điện nước</button></a>

</body>
</html>

<?php mysqli_close($con); ?>
