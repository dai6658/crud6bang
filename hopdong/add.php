<?php include "../menu.php"; ?>
<?php
include "../db.php";

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO HopDong VALUES(
        '{$_POST['MaHD']}',
        '{$_POST['MaSV']}',
        '{$_POST['MaPhong']}',
        '{$_POST['NgayBD']}',
        '{$_POST['NgayKT']}',
        '{$_POST['TinhTrang']}'
    )";

    if ($conn->query($sql)) header("Location: index.php");
    else echo "Lỗi: " . $conn->error;
}
?>

<h2>Thêm hợp đồng</h2>
<form method="post">
    Mã hợp đồng: <input name="MaHD"><br><br>
    Mã sinh viên: <input name="MaSV"><br><br>
    Mã phòng: <input name="MaPhong"><br><br>
    Ngày bắt đầu: <input type="date" name="NgayBD"><br><br>
    Ngày kết thúc: <input type="date" name="NgayKT"><br><br>
    Tình trạng: <input name="TinhTrang"><br><br>
    <button name="submit">Lưu</button>
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