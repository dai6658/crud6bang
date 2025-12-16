<?php include "../menu.php"; ?>
<?php
include "../db.php";

$MaHD = $_GET["MaHD"];
$conn->query("DELETE FROM HopDong WHERE MaHD='$MaHD'");
header("Location: index.php");
?>