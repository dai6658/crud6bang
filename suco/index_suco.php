<?php include "../menu.php"; ?>
<?php
// Trang danh sách sự cố (đơn giản)
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "ktx_management";

$con = mysqli_connect($dbHost, $dbUser, $dbPass);
if (!$con) {
    die("Không kết nối được MySQL: " . mysqli_connect_error());
}
if (!mysqli_select_db($con, $dbName)) {
    die("Chưa có database '$dbName'. Vào phpMyAdmin tạo database này và bảng 'suco' trước.");
}
mysqli_set_charset($con, "utf8mb4");

// Kiểm tra bảng suco tồn tại
$checkSuco = mysqli_query($con, "SHOW TABLES LIKE 'suco'");
if (!$checkSuco || mysqli_num_rows($checkSuco) == 0) {
    die("Chưa có bảng 'suco'. Hãy tạo bảng này trước khi sử dụng.");
}

$q      = trim($_GET["q"] ?? "");
$order  = $_GET["order"] ?? "ASC";
$ppage  = (int)($_GET["ppage"] ?? 10);
$p      = isset($_GET["page"]) ? (int)$_GET["page"] : (int)($_GET["p"] ?? 1); // chấp nhận cả page hoặc p
if ($p < 1) $p = 1;
$validPpage = [5, 10, 20, 30];
if (!in_array($ppage, $validPpage)) $ppage = 10;

$qEsc = mysqli_real_escape_string($con, $q);
$where = "WHERE 1";
if ($q !== "") {
    $like = "'%$qEsc%'";
    $where = "WHERE (MaPhong LIKE $like OR MoTa LIKE $like OR TrangThai LIKE $like)";
    if (ctype_digit($q)) {
        $where = "WHERE (MaPhong LIKE $like OR MoTa LIKE $like OR TrangThai LIKE $like OR MaSC = " . (int)$q . ")";
    }
}

$orderSql = "ORDER BY MaSC ASC";
$order = strtoupper($order) === "DESC" ? "DESC" : "ASC";
if ($order === "DESC") {
    $orderSql = "ORDER BY MaSC DESC";
}

$start = $ppage * ($p - 1);

// Đếm tổng bản ghi
$totalRows = 0;
$countSql = "SELECT COUNT(*) AS total FROM suco $where";
$countRes = mysqli_query($con, $countSql);
if ($countRes) {
    $rowCnt = mysqli_fetch_assoc($countRes);
    $totalRows = (int)$rowCnt["total"];
}
$total_records = $totalRows; // theo hướng dẫn: tổng số bản ghi
$limit = $ppage;            // số dòng mỗi trang
$totalPage = ($total_records > 0) ? ceil($total_records / $limit) : 1;

// Lấy dữ liệu trang hiện tại
$sql = "SELECT MaSC, MaPhong, MoTa, NgayBao, TrangThai FROM suco $where $orderSql LIMIT $start, $limit";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sự cố</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #050000ff; }
        .pager a { margin: 0 4px; text-decoration: none; }
        .pagination a { padding: 4px 8px; margin: 0 2px; border: 1px solid #ccc; text-decoration: none; }
        .pagination .active-page { background: #007bff; color: #fff; border-color: #007bff; }
    </style>
</head>
<body>
    <h2>Danh sách sự cố</h2>

    <form method="get">
        <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Tìm mã phòng, mô tả...">
        <select name="order">
            <option value="ASC" <?php if ($order==="ASC") echo "selected"; ?>>Tăng dần theo ID</option>
            <option value="DESC" <?php if ($order==="DESC") echo "selected"; ?>>Giảm dần theo ID</option>
        </select>
        <select name="ppage">
            <option value="5"  <?php if ($ppage==5) echo "selected";  ?>>5 dòng/trang</option>
            <option value="10" <?php if ($ppage==10) echo "selected"; ?>>10 dòng/trang</option>
            <option value="20" <?php if ($ppage==20) echo "selected"; ?>>20 dòng/trang</option>
            <option value="30" <?php if ($ppage==30) echo "selected"; ?>>30 dòng/trang</option>
        </select>
        <input type="submit" value="Tìm">
    </form>

    <a href="add_suco.php">Thêm sự cố</a> |
    <a href="edit_suco.php">Sửa/Xóa sự cố</a> |
    <a href="themsuco.php">Thêm sự cố ngẫu nhiên</a>
    <br><br>

    <p>
        Tổng bản ghi: <?php echo $total_records; ?> |
        Trang hiện tại: <?php echo $p; ?>/<?php echo $totalPage; ?> |
        Số bản ghi/trang: <?php echo $limit; ?>
    </p>

    <!-- Phân trang hiển thị ngay dưới thông tin (kiểu đơn giản như ảnh) -->
    <div class="pagination" style="margin:6px 0;">
        <?php
        $base = "?q=" . urlencode($q) . "&order=$order&ppage=$ppage&page=";
        if ($p > 1) {
            echo "<a href='{$base}" . ($p-1) . "'>&laquo; Trước</a> ";
        } else {
            echo "<span style='color:gray;'>&laquo; Trước</span> ";
        }
        for ($k = 1; $k <= $totalPage; $k++) {
            if ($k == $p) {
                echo "<a class='active-page' href='{$base}{$k}'>{$k}</a> ";
            } else {
                echo "<a href='{$base}{$k}'>{$k}</a> ";
            }
        }
        if ($p < $totalPage) {
            echo "<a href='{$base}" . ($p+1) . "'>Sau &raquo;</a>";
        } else {
            echo "<span style='color:gray;'>Sau &raquo;</span>";
        }
        ?>
    </div>

    <table>
        <tr>
            <th>STT</th>
            <th>MaSC</th>
            <th>MaPhong</th>
            <th>MoTa</th>
            <th>NgayBao</th>
            <th>TrangThai</th>
        </tr>
        <?php
        $i = 1 + $start;
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . htmlspecialchars($row["MaSC"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["MaPhong"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["MoTa"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["NgayBao"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["TrangThai"]) . "</td>";
                echo "</tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='6'>Không có dữ liệu.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php mysqli_close($con); ?>
