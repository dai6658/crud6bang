<?php include "../menu.php"; ?>
<?php
include "../db.php";

$MaHD = $_GET['MaHD'];
$data = $conn->query("SELECT * FROM HopDong WHERE MaHD='$MaHD'")->fetch_assoc();

if (isset($_POST['submit'])) {
    $sql = "UPDATE HopDong SET
        MaSV='{$_POST['MaSV']}',
        MaPhong='{$_POST['MaPhong']}',
        NgayBD='{$_POST['NgayBD']}',
        NgayKT='{$_POST['NgayKT']}',
        TinhTrang='{$_POST['TinhTrang']}'
        WHERE MaHD='$MaHD'";

    if ($conn->query($sql)) header("Location: index.php");
    else echo "Lỗi: " . $conn->error;
}
?>

<h2>Sửa hợp đồng</h2>
<form method="post">
    Mã sinh viên: <input name="MaSV" value="<?= $data['MaSV'] ?>"><br><br>
    Mã phòng: <input name="MaPhong" value="<?= $data['MaPhong'] ?>"><br><br>
    Ngày bắt đầu: <input type="date" name="NgayBD" value="<?= $data['NgayBD'] ?>"><br><br>
    Ngày kết thúc: <input type="date" name="NgayKT" value="<?= $data['NgayKT'] ?>"><br><br>
    Tình trạng: <input name="TinhTrang" value="<?= $data['TinhTrang'] ?>"><br><br>
    <button name="submit">Cập nhật</button>
</form>
<a href="index.php" style="
    display: inline-block;
    padding: 8px 12px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
">Quay về danh sách</a>
<br><br>