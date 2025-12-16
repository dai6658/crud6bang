<?php include "../menu.php"; ?>
<?php include "../db.php"; ?>

<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
        <h2 style="margin:0;">Danh sách điện nước</h2>
        <a class="btn btn-primary" href="add.php">+ Thêm điện nước</a>
        <a class="btn btn-primary" href="themdiennuoc.php">+ Thêm điện nước ngẫu nhiên</a>
    </div>

    <table>
    <tr>
        <th>ID</th>
        <th>Mã phòng</th>
        <th>Tháng</th>
        <th>Số điện</th>
        <th>Số nước</th>
        <th>Hành động</th>
    </tr>

    <?php
    $q = $conn->query("SELECT * FROM diennuoc");
    while ($r = $q->fetch_assoc()):
    ?>
    <tr>
        <td><?= $r["ID"] ?></td>
        <td><?= $r["MaPhong"] ?></td>
        <td><?= $r["Thang"] ?></td>
        <td><?= $r["SoDien"] ?></td>
        <td><?= $r["SoNuoc"] ?></td>
        <td class="actions">
            <a href="edit.php?ID=<?= $r['ID'] ?>">Sửa</a>
            <a onclick="return confirm('Xóa?')" 
               href="delete.php?ID=<?= $r['ID'] ?>">Xóa</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </table>
</div>

<div class="card" style="display:flex;align-items:center;gap:10px;justify-content:space-between;">
    <div>
        <h3 style="margin:0 0 6px 0;">Tìm kiếm phòng</h3>
        <div style="color: #607080;">Tra cứu nhanh theo mã phòng.</div>
    </div>
    <a href="search.php" class="btn btn-accent">Tìm kiếm phòng</a>
</div>

<a href="../index.php" class="btn btn-primary">Quay về trang chủ</a>
