<?php include "../menu.php"; ?>
<?php
include "../db.php";

$MaHD = $_GET["MaHD"];

mysqli_query($conn, "DELETE FROM HopDong WHERE MaHD='$MaHD'");

header("Location: index.php");
?>
