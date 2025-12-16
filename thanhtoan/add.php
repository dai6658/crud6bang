<?php include "../menu.php"; ?>
<?php
// KẾT NỐI DATABASE THEO CẤU TRÚC CỦA BẠN
$con = mysqli_connect("localhost", "root", "", "ktx_management", 3306);
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

// XỬ LÝ KHI NHẤN NÚT LƯU
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $MaSV     = $_POST['MaSV'];
    $SoTien   = $_POST['SoTien'];
    $NgayTT   = $_POST['NgayTT'];
    $NoiDung  = $_POST['NoiDung'];

    $sql = "INSERT INTO thanhtoan(MaSV, SoTien, NgayTT, NoiDung)
            VALUES ('$MaSV', '$SoTien', '$NgayTT', '$NoiDung')";

    if (mysqli_query($con, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi SQL: " . mysqli_error($con);
    }
}
?>

<h2>Thêm thanh toán</h2>

<form method="post">
    Mã sinh viên:  
    <input name="MaSV" required><br><br>

    Số tiền:  
    <input name="SoTien" type="number" required><br><br>

    Ngày thanh toán: 
    <input type="date" name="NgayTT" required><br><br>

    Nội dung: 
    <input name="NoiDung" required><br><br>

    <button type="submit">Lưu</button>
</form>

<a href="index.php" style="
    display: inline-block;
    padding: 8px 12px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
">Quay về trang chủ</a>

<?php mysqli_close($con); ?>
