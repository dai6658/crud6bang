<?php include "../menu.php"; ?>
<?php
include "../db.php";

$ID = $_GET['ID'];
$data = $conn->query("SELECT * FROM diennuoc WHERE ID='$ID'")->fetch_assoc();

if (isset($_POST['submit'])) {
    $sql = "UPDATE diennuoc SET
        MaPhong='{$_POST['MaPhong']}',
        Thang='{$_POST['Thang']}',
        SoDien='{$_POST['SoDien']}',
        SoNuoc='{$_POST['SoNuoc']}'
        WHERE ID='$ID'";

    if ($conn->query($sql)) header("Location: index.php");
    else echo "Lỗi: " . $conn->error;
}
?>

<h2>Sửa điện nước</h2>
<form method="post">
    Mã phòng: <input name="MaPhong" value="<?= $data['MaPhong'] ?>"><br><br>
    Tháng: <input name="Thang" value="<?= $data['Thang'] ?>"><br><br>
    Số điện: <input name="SoDien" value="<?= $data['SoDien'] ?>"><br><br>
    Số nước: <input name="SoNuoc" value="<?= $data['SoNuoc'] ?>"><br><br>
    <button name="submit">Cập nhật</button>
</form><br>
<a href="../index.php" style="
    display: inline-block;
    padding: 8px 12px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
"> Quay về trang chủ</a>
<br><br>
