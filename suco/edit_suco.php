<?php include "../menu.php"; ?>
<?php
// Trang sửa / xóa sự cố (đơn giản)
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

$msg = "";
$err = "";

// Lấy tham số lọc
$q      = trim($_REQUEST["q"] ?? "");
$order  = $_REQUEST["order"] ?? "ASC";
$ppage  = (int)($_REQUEST["ppage"] ?? 10);
$p      = isset($_REQUEST["page"]) ? (int)$_REQUEST["page"] : (int)($_REQUEST["p"] ?? 1); // chấp nhận cả page hoặc p
if ($p < 1) $p = 1;
$validPpage = [5, 10, 20, 30];
if (!in_array($ppage, $validPpage)) $ppage = 10;

// Xử lý xóa
if (isset($_POST["sbtDel"]) && isset($_POST["MaSC"])) {
    $id = (int)$_POST["MaSC"];
    $sqlDel = "DELETE FROM suco WHERE MaSC = $id";
    if (mysqli_query($con, $sqlDel)) {
        $msg = "Đã xóa 1 bản ghi (MaSC = $id).";
    } else {
        $err = "Lỗi xóa: " . mysqli_error($con);
    }
}

// Xử lý cập nhật
if (isset($_POST["sbtEdit"]) && isset($_POST["MaSC"])) {
    $id        = (int)$_POST["MaSC"];
    $MaPhong   = trim($_POST["MaPhong"] ?? "");
    $MoTa      = trim($_POST["MoTa"] ?? "");
    $NgayBao   = trim($_POST["NgayBao"] ?? "");
    $TrangThai = trim($_POST["TrangThai"] ?? "");

    if ($MaPhong === "" || $NgayBao === "" || $TrangThai === "") {
        $err = "Mã phòng, Ngày báo và Trạng thái không được trống.";
    } else {
        $mp = mysqli_real_escape_string($con, $MaPhong);
        $mt = mysqli_real_escape_string($con, $MoTa);
        $nb = mysqli_real_escape_string($con, $NgayBao);
        $tt = mysqli_real_escape_string($con, $TrangThai);

        $sqlUp = "UPDATE suco SET MaPhong='$mp', MoTa='$mt', NgayBao='$nb', TrangThai='$tt' WHERE MaSC=$id";
        if (mysqli_query($con, $sqlUp)) {
            $msg = "Đã cập nhật (MaSC = $id).";
        } else {
            $err = "Lỗi cập nhật: " . mysqli_error($con);
        }
    }
}

// Chuẩn bị truy vấn danh sách
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

// Tổng trang
$totalRows = 0;
$countSql = "SELECT COUNT(*) AS total FROM suco $where";
$countRes = mysqli_query($con, $countSql);
if ($countRes) {
    $rowCnt = mysqli_fetch_assoc($countRes);
    $totalRows = (int)$rowCnt["total"];
}
$total_records = $totalRows;
$limit = $ppage;
$totalPage = ($total_records > 0) ? ceil($total_records / $limit) : 1;

$sql = "SELECT MaSC, MaPhong, MoTa, NgayBao, TrangThai FROM suco $where $orderSql LIMIT $start, $limit";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa / Xóa sự cố</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f3f3f3; }
        .pager a { margin: 0 4px; text-decoration: none; }
        .pagination a { padding: 4px 8px; margin: 0 2px; border: 1px solid #ccc; text-decoration: none; }
        .pagination .active-page { background: #007bff; color: #fff; border-color: #007bff; }
    </style>
</head>
<body>
    <h2>Sửa / Xóa sự cố</h2>

    <?php if ($msg !== ""): ?>
        <p style="color:green;"><?php echo htmlspecialchars($msg); ?></p>
    <?php endif; ?>
    <?php if ($err !== ""): ?>
        <p style="color:red;"><?php echo htmlspecialchars($err); ?></p>
    <?php endif; ?>

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
    <a href="index_suco.php">Xem danh sách</a>
    <br><br>

    <p>
        Tổng bản ghi: <?php echo $total_records; ?> |
        Trang hiện tại: <?php echo $p; ?>/<?php echo $totalPage; ?> |
        Số bản ghi/trang: <?php echo $limit; ?>
    </p>

    <!-- Thanh phân trang đặt ngay sau thông tin, kiểu đơn giản -->
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
            <th>Thao tác</th>
        </tr>
        <?php
        $i = 1 + $start;
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <form method="post">
                        <td><?php echo $i; ?></td>
                        <td><input type="text" name="MaSC" value="<?php echo htmlspecialchars($row["MaSC"]); ?>" readonly></td>
                        <td><input type="text" name="MaPhong" value="<?php echo htmlspecialchars($row["MaPhong"]); ?>"></td>
                        <td><input type="text" name="MoTa" value="<?php echo htmlspecialchars($row["MoTa"]); ?>"></td>
                        <td><input type="date" name="NgayBao" value="<?php echo htmlspecialchars($row["NgayBao"]); ?>"></td>
                        <td><input type="text" name="TrangThai" value="<?php echo htmlspecialchars($row["TrangThai"]); ?>"></td>
                        <td>
                            <input type="submit" name="sbtEdit" value="Sửa">
                            <input type="submit" name="sbtDel" value="Xóa" onclick="return confirm('Xóa bản ghi này?');">
                            <input type="hidden" name="q" value="<?php echo htmlspecialchars($q); ?>">
                            <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
                            <input type="hidden" name="ppage" value="<?php echo htmlspecialchars($ppage); ?>">
                            <input type="hidden" name="page" value="<?php echo htmlspecialchars($p); ?>">
                        </td>
                    </form>
                </tr>
                <?php
                $i++;
            }
        } else {
            echo "<tr><td colspan='7'>Không có dữ liệu.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php mysqli_close($con); ?>
