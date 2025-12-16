<?php include "../menu.php"; ?>
<?php
include "../db.php";

$ID = $_GET["ID"];
$conn->query("DELETE FROM diennuoc WHERE ID='$ID'");
header("Location: index.php");
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
