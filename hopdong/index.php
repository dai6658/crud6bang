<?php include "../menu.php"; ?>
<?php include "../db.php"; ?>

<h2>Danh sách hợp đồng</h2>

<form method="GET">
    <input type="text" name="q" placeholder="Tìm kiếm..." value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>">

    <select name="order">
        <option value="ASC"  <?php if(isset($_GET['order']) && $_GET['order']=="ASC") echo "selected"; ?>>Ngày bắt đầu tăng</option>
        <option value="DESC" <?php if(isset($_GET['order']) && $_GET['order']=="DESC") echo "selected"; ?>>Ngày bắt đầu giảm</option>
    </select>

    <select name="ppage">
        <?php 
            $opts = [5, 10, 20, 30];
            foreach($opts as $o){
                $sel = (isset($_GET['ppage']) && $_GET['ppage'] == $o) ? "selected" : "";
                echo "<option value='$o' $sel>$o bản ghi/trang</option>";
            }
        ?>
    </select>

    <input type="submit" name="btnSubmit" value="Tìm">
</form>

<a href="add.php">Thêm hợp đồng</a><br><br>
<a href="themhopdong.php">Thêm nhiều hợp đồng ngẫu nhiên</a><br><br>

<?php
$order = "ORDER BY NgayBD ASC";
/* ========================= SẮP XẾP ======================= */
if(isset($_GET['order'])){
    if($_GET['order'] == "ASC")  $order = "ORDER BY NgayBD ASC";
    if($_GET['order'] == "DESC") $order = "ORDER BY NgayBD DESC";
}else{
    $order = "ORDER BY NgayBD ASC";
}

/* ========================= PHÂN TRANG ======================= */
$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$ppage = isset($_GET['ppage']) ? (int)$_GET['ppage'] : 10;

$start = ($p - 1) * $ppage;
$limit = "LIMIT $start, $ppage";

/* ========================= TÌM KIẾM ======================= */
$q = isset($_GET['q']) ? str_replace("'","", $_GET['q']) : "";

/* ========================= LẤY TỔNG TRANG ======================= */
$sqlPage = "
SELECT MaHD FROM HopDong
WHERE MaHD LIKE '%$q%' OR MaSV LIKE '%$q%' OR MaPhong LIKE '%$q%'
";

$resultPage = $conn->query($sqlPage);
$totalPage = ceil($resultPage->num_rows / $ppage);

$od = isset($_GET['order']) ? $_GET['order'] : "";

/* ========================= HIỂN THỊ SỐ TRANG ======================= */
for($i=1; $i<=$totalPage; $i++){
    if($i == $p){
        echo "<a href='?q=$q&order=$od&p=$i&ppage=$ppage' style='color:red;font-size:150%'>$i</a> ";
    }else{
        echo "<a href='?q=$q&order=$od&p=$i&ppage=$ppage' style='color:blue;text-decoration:none'>$i</a> ";
    }
}

/* ========================= LẤY DỮ LIỆU ======================= */
$sql = "
SELECT MaHD, MaSV, MaPhong, NgayBD, NgayKT, TinhTrang
FROM HopDong
WHERE MaHD LIKE '%$q%' OR MaSV LIKE '%$q%' OR MaPhong LIKE '%$q%'
$order
$limit
";

$result = $conn->query($sql);

echo "<table border='1' width='100%' cellpadding='8'>
<tr>
    <th>STT</th>
    <th>Mã HĐ</th>
    <th>Mã SV</th>
    <th>Mã phòng</th>
    <th>Ngày bắt đầu</th>
    <th>Ngày kết thúc</th>
    <th>Tình trạng</th>
    <th>Hành động</th>
</tr>
";

$stt = $start + 1;

/* ========================= HIỂN THỊ BẢNG ======================= */
while($row = $result->fetch_assoc()){
    echo "
    <tr>
        <td>$stt</td>
        <td>{$row['MaHD']}</td>
        <td>{$row['MaSV']}</td>
        <td>{$row['MaPhong']}</td>
        <td>{$row['NgayBD']}</td>
        <td>{$row['NgayKT']}</td>
        <td>{$row['TinhTrang']}</td>
        <td>
            <a href='edit.php?MaHD={$row['MaHD']}'>Sửa</a>
            <a href='delete.php?MaHD={$row['MaHD']}' onclick=\"return confirm('Xóa hợp đồng?')\" style='color:red;'>Xóa</a>
        </td>
    </tr>
    ";
    $stt++;
}

echo "</table>";

$conn->close();
?>

<br>
<a href="../index.php" style="
    display: inline-block;
    padding: 8px 12px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
">Quay về trang chủ</a>
<br><br>