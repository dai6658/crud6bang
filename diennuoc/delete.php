<?php include "../menu.php"; ?>
<?php
$con = mysqli_connect("localhost", "root", "", "ktx_management");
if (!$con) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

$ID = $_GET["ID"];
$sql = "DELETE FROM diennuoc WHERE ID='$ID'";

if (mysqli_query($con, $sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Lỗi khi xóa: " . mysqli_error($con);
}

mysqli_close($con);
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
