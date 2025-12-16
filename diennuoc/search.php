<?php include "../menu.php"; ?>
<?php
include "../db.php";

// Lấy tham số tìm kiếm (chỉ theo mã phòng)
$MaPhong = isset($_GET["MaPhong"]) ? trim($_GET["MaPhong"]) : "";

// Xử lý tìm kiếm
$resultRows = [];
$message = "";
if ($MaPhong === "") {
    $message = "Vui lòng nhập Mã phòng để tìm kiếm.";
} else {
    $stmt = $conn->prepare("SELECT * FROM diennuoc WHERE MaPhong = ?");
    $stmt->bind_param("s", $MaPhong);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resultRows[] = $row;
        }
    } else {
        $message = "Không tìm thấy dữ liệu.";
    }
    $stmt->close();
}
?>

<div class="card" style="max-width:640px;">
    <h2>Tìm kiếm điện nước theo phòng</h2>
    <form method="get" style="display:flex;gap:10px;flex-wrap:wrap;margin:14px 0 8px;">
        <div style="flex:1;min-width:220px;">
            <label for="MaPhong">Mã phòng</label><br>
            <input id="MaPhong" name="MaPhong" value="<?php echo htmlspecialchars($MaPhong); ?>" placeholder="" required>
        </div>
        <div style="display:flex;align-items:flex-end;gap:10px;">
            <button class="btn btn-primary" type="submit" style="min-width:110px;">Tìm</button>
            <a class="btn btn-accent" href="index.php">Danh sách</a>
        </div>
    </form>
    <?php if ($message): ?>
        <div style="margin-top:6px;color:#d35400;font-weight:600;"><?php echo $message; ?></div>
    <?php endif; ?>
</div>

<?php if (!empty($resultRows)): ?>
    <div class="card" style="max-width:640px;">
        <h3 style="margin-top:0;">Kết quả</h3>
        <?php foreach ($resultRows as $row): ?>
            <div style="margin-bottom:12px;padding:10px;border:1px solid #e5e8f0;border-radius:8px;">
                <div><strong>ID:</strong> <?php echo $row['ID']; ?></div>
                <div><strong>Mã Phòng:</strong> <?php echo $row['MaPhong']; ?></div>
                <div><strong>Tháng:</strong> <?php echo $row['Thang']; ?></div>
                <div><strong>Số điện:</strong> <?php echo $row['SoDien']; ?></div>
                <div><strong>Số nước:</strong> <?php echo $row['SoNuoc']; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<a class="btn btn-primary" href="../index.php">Quay về trang chủ</a>