<?php include "../menu.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bài tập xây dựng trang tìm kiếm với PHP & MySQL</title>
    <meta charset="utf-8">
</head>
<body>

<form method="GET">
    <input type="text" name="q" value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>">

    <select name="order">
        <option value="ASC"  <?php if(isset($_GET['order']) && $_GET['order']=="ASC") echo "selected"; ?>>Số tiền tăng</option>
        <option value="DESC" <?php if(isset($_GET['order']) && $_GET['order']=="DESC") echo "selected"; ?>>Số tiền giảm</option>
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

<a href="index.php">Vào giao diện xem</a><br><br>
<p>Lưu ý: phải load lại trang mới hiện ra bảng sau khi sửa</p><br>

<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management", 3306);
if(!$con){ die("Lỗi kết nối CSDL"); }

$OK = 1;

/* ========================= XÓA ======================= */
if(isset($_POST['sbtDel'])){
    $MaTT = $_POST['MaTT'];
    $sql = "DELETE FROM thanhtoan WHERE MaTT = '$MaTT'";

    if(mysqli_query($con, $sql)){
        echo "Đã xoá thành công!";
    }else{
        echo "Lỗi xoá: " . mysqli_error($con);
    }
    $OK = 0;
}

/* ========================= XỬ LÝ SỬA ======================= */
if(isset($_POST['sbtEdit'])){
    $sql = "
    UPDATE thanhtoan SET
        MaSV = '{$_POST['MaSV']}',
        SoTien = '{$_POST['SoTien']}',
        NgayTT = '{$_POST['NgayTT']}',
        NoiDung = '{$_POST['NoiDung']}'
    WHERE MaTT = '{$_POST['MaTT']}'
    ";

    if(mysqli_query($con, $sql)){
        echo "Cập nhật thành công!";
    }else{
        echo "Lỗi sửa: " . mysqli_error($con);
    }
}
/* ========================= SẮP XẾP ======================= */
if(isset($_GET['order'])){
    if($_GET['order'] == "ASC")  $order = "ORDER BY SoTien ASC";
    if($_GET['order'] == "DESC") $order = "ORDER BY SoTien DESC";
}else{
    $order = "ORDER BY SoTien ASC";
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
SELECT MaTT FROM thanhtoan
WHERE MaTT LIKE '%$q%' OR MaSV LIKE '%$q%'
";

$resultPage = mysqli_query($con, $sqlPage);
$totalPage = ceil(mysqli_num_rows($resultPage) / $ppage);

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
SELECT MaTT, MaSV, SoTien, NgayTT, NoiDung
FROM thanhtoan
WHERE MaTT LIKE '%$q%' OR MaSV LIKE '%$q%'
$order
$limit
";

$result = mysqli_query($con, $sql);

echo "<table border='1' width='100%'>
<tr>
    <th>STT</th>
    <th>Mã thanh toán</th>
    <th>Mã SV</th>
    <th>Số tiền</th>
    <th>Ngày thanh toán</th>
    <th>Nội dung</th>
   
</tr>
";

$stt = $start + 1;

/* ========================= HIỂN THỊ BẢNG + FORM SỬA ======================= */
while($row = mysqli_fetch_assoc($result)){

    echo "
    <tr>
        <form method='POST'>
        <td>$stt</td>

        <td><input type='text' name='MaTT' value='{$row['MaTT']}' readonly></td>

        <td><input type='text' name='MaSV' value='{$row['MaSV']}' required></td>

        <td><input type='number' name='SoTien' value='{$row['SoTien']}' required></td>

        <td><input type='date' name='NgayTT' value='{$row['NgayTT']}' required></td>

        <td><input type='text' name='NoiDung' value='{$row['NoiDung']}' required></td>

        <td>
            <input type='submit' name='sbtEdit' value='Sửa'>
        </td>

        <input type='hidden' name='p' value='$p'>
        <input type='hidden' name='ppage' value='$ppage'>
        <input type='hidden' name='q' value='$q'>
        <input type='hidden' name='order' value='$od'>
        </form>

        <td>
            <form method='POST'>
                <input type='hidden' name='MaTT' value='{$row['MaTT']}'>
                <input type='submit' name='sbtDel' value='Xoá' style='color:red;'>
            </form>
        </td>
    </tr>
    ";

    $stt++;
}




echo "</table>";

mysqli_close($con);
?>
</body>
</html>
