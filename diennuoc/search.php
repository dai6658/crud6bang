<?php include "../menu.php"; ?>
<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

// Lấy tham số tìm kiếm (chỉ theo mã phòng)
$MaPhong = isset($_GET["MaPhong"]) ? trim($_GET["MaPhong"]) : "";

// Xử lý tìm kiếm
$resultRows = [];
$message = "";
if ($MaPhong === "") {
    $message = "Vui lòng nhập Mã phòng để tìm kiếm.";
} else {
    $sql = "SELECT * FROM diennuoc WHERE MaPhong LIKE '%$MaPhong%'";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $resultRows[] = $row;
        }
    } else {
        $message = "Không tìm thấy dữ liệu.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm điện nước</title>
</head>
<body>

<h2>Tìm kiếm điện nước theo phòng</h2>

<form method="GET">
    Mã phòng:<br>
    <input type="text" name="MaPhong" value="<?php echo htmlspecialchars($MaPhong); ?>" placeholder="Nhập mã phòng" required><br><br>
    <input type="submit" value="Tìm">
</form>

<?php if ($message): ?>
    <p style="color:#d35400;font-weight:600;"><?php echo $message; ?></p>
<?php endif; ?>

<?php if (!empty($resultRows)): ?>
    <h3>Kết quả</h3>
    <table border='1' width=100%>
        <tr>
            <th>STT</th>
            <th>ID</th>
            <th>Mã phòng</th>
            <th>Tháng</th>
            <th>Số điện</th>
            <th>Số nước</th>
        </tr>
        <?php 
        $i = 1;
        foreach ($resultRows as $row): 
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['ID']; ?></td>
            <td><?php echo $row['MaPhong']; ?></td>
            <td><?php echo $row['Thang']; ?></td>
            <td><?php echo $row['SoDien']; ?></td>
            <td><?php echo $row['SoNuoc']; ?></td>
        </tr>
        <?php 
        $i++;
        endforeach; 
        ?>
    </table>
<?php endif; ?>

<br>
<a href="index.php"><button> Quay về danh sách điện nước</button></a>

</body>
</html>

<?php mysqli_close($con); ?>
