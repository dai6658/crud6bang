<?php include "../menu.php"; ?>
<?php
include "../db.php";

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO diennuoc(MaPhong, Thang, SoDien, SoNuoc)
            VALUES(
                '{$_POST['MaPhong']}',
                '{$_POST['Thang']}',
                '{$_POST['SoDien']}',
                '{$_POST['SoNuoc']}'
            )";

    if ($conn->query($sql)) header("Location: index.php");
    else echo "Lỗi: " . $conn->error;
}
?>

<div class="card" style="max-width:520px;">
    <h2>Thêm điện nước</h2>
    <form method="post" style="display:flex;flex-direction:column;gap:12px;margin-top:12px;">
        <div>
            <label for="MaPhong">Mã phòng</label><br>
            <input id="MaPhong" name="MaPhong" required>
        </div>
        <div>
            <label for="Thang">Tháng</label><br>
            <input id="Thang" name="Thang" placeholder="VD: 2025-01" required>
        </div>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <div style="flex:1;min-width:180px;">
                <label for="SoDien">Số điện</label><br>
                <input id="SoDien" name="SoDien" type="number" min="0" required>
            </div>
            <div style="flex:1;min-width:180px;">
                <label for="SoNuoc">Số nước</label><br>
                <input id="SoNuoc" name="SoNuoc" type="number" min="0" required>
            </div>
        </div>
        <div style="display:flex;gap:10px;">
            <button class="btn btn-primary" name="submit" type="submit">Lưu</button>
            <a class="btn btn-accent" href="index.php">Danh sách</a>
        </div>
    </form>
</div>

<a class="btn btn-primary" href="../index.php">Quay về trang chủ</a>
