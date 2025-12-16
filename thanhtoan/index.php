<?php include "../menu.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Danh sách thanh toán</title>
    <meta charset="utf-8">
</head>
<body>

<form method="GET">
    <input type="text" name="q" value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>">
    
    <select name="order">
        <option value="ASC" <?php if(isset($_GET['order']) && $_GET['order']=="ASC") echo "selected"; ?>>
            Sắp xếp theo số tiền tăng dần
        </option>
        <option value="DESC" <?php if(isset($_GET['order']) && $_GET['order']=="DESC") echo "selected"; ?>>
            Sắp xếp theo số tiền giảm dần
        </option>
    </select>

    <select name="ppage">
        <?php 
        $opts = [5,10,20,30];
        foreach($opts as $o){
            $sel = (isset($_GET['ppage']) && $_GET['ppage']==$o) ? "selected" : "";
            echo "<option value='$o' $sel>$o bản ghi / trang</option>";
        }
        ?>
    </select>

    <input type="submit" name="btnSubmit" value="Tìm">
</form>

<br>

<a href="add.php">  Thêm thanh toán</a><br><br>
<a href="themthanhtoan.php">  Thêm 50 bản thanh toán</a><br><br>
<a href="edit.php">  Giao diện sửa & xóa</a><br><br>

<?php
// KẾT NỐI CSDL
$con = mysqli_connect("localhost", "root", "", "ktx_management", 3306);
if (!$con) {
    die("Lỗi kết nối CSDL: " . mysqli_connect_error());
}

// --- NHẬN THAM SỐ ---
$q = isset($_GET['q']) ? $_GET['q'] : "";

$order = "";
if (isset($_GET['order'])) {
    if ($_GET['order'] == "ASC")  $order = "ORDER BY SoTien ASC";
    if ($_GET['order'] == "DESC") $order = "ORDER BY SoTien DESC";
}

$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$ppage = isset($_GET['ppage']) ? (int)$_GET['ppage'] : 10;

$start = ($p - 1) * $ppage;
$limit = "LIMIT $start, $ppage";

// --- TRUY VẤN ĐỂ LẤY TỔNG TRANG ---
$sqlPage = "
    SELECT MaTT 
    FROM thanhtoan 
    WHERE MaTT LIKE '%$q%' OR MaSV LIKE '%$q%'
";

$resultPage = mysqli_query($con, $sqlPage);
$totalRecords = mysqli_num_rows($resultPage);
$totalPage = ceil($totalRecords / $ppage);

// --- HIỂN THỊ NÚT PHÂN TRANG ---
for ($i = 1; $i <= $totalPage; $i++) {
    $od = isset($_GET['order']) ? $_GET['order'] : "";
    $color = ($i == $p) ? "red;font-size:150%" : "blue;text-decoration:none";
    
    echo "<a href='?q={$q}&order={$od}&p={$i}&ppage={$ppage}' 
          style='color:$color'> $i </a> ";
}

echo "<br><br>";

// --- TRUY VẤN LẤY DỮ LIỆU THEO TRANG ---
$sql = "
    SELECT MaTT, MaSV, SoTien, NgayTT, NoiDung
    FROM thanhtoan
    WHERE MaTT LIKE '%$q%' OR MaSV LIKE '%$q%' 
    $order 
    $limit
";

// DEBUG (nếu muốn xem SQL):
// echo $sql;

$result = mysqli_query($con, $sql);

// --- HIỂN THỊ BẢNG ---
echo "<table border='1' width='100%'>
<tr>
    <th>STT</th>
    <th>Mã thanh toán</th>
    <th>Mã sinh viên</th>
    <th>Số tiền</th>
    <th>Ngày thanh toán</th>
    <th>Nội dung</th>
</tr>";

$stt = $start + 1;

while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$stt}</td>
        <td>{$row['MaTT']}</td>
        <td>{$row['MaSV']}</td>
        <td>{$row['SoTien']}</td>
        <td>{$row['NgayTT']}</td>
        <td>{$row['NoiDung']}</td>
    </tr>";
    $stt++;
}

echo "</table>";

// ĐÓNG KẾT NỐI
mysqli_close($con);
?>

<br><br>
<a href='../index.php' style='
    display:inline-block;
    padding:8px 12px;
    background:#3498db;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
'>  Quay về trang chủ </a>

</body>
</html>

