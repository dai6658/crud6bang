<?php include "../menu.php"; ?>
<html>
	<head>
		<title>Bài tập xây dựng trang tìm kiếm với PHP & MySQL</title>
		<meta charset = 'utf-8'>
		 
	</head>
	<body>
		<form method = 'GET'>
			<input type = text name = 'q'>
			<select name = 'order'>
				<option value = 'ASC' selected>Sắp xếp tăng dần theo tên</option>
				<option value = 'DESC'>Sắp xếp giảm dần theo tên</option>
			</select>
			<select name = 'ppage'>
				<option value = 5>05 bản ghi/trang</option>
				<option value = 10 selected>10 bản ghi/trang</option>
				<option value = 20>20 bản ghi/trang</option>
				<option value = 30>30 bản ghi/trang</option>				
			</select>
			<input type = 'submit' name = 'btnSubmit' value = 'Tìm'>
		</form>
        <a href="add.php"> Thêm sinh viên</a><br><br>
<a href="index.php"> Vào giao diện xem</a><br><br>
<?php
	//SHOW TOÀN BỘ CÁC BẢN GHI TRONG BẢNG USERS
	//Bước 1: Kết nối đến CSDL, lựa chọn CSDL
	$con = mysqli_connect("localhost", "root", "", "ktx_management");		
	//Bước 2: Xây dựng truy vấn và thực hiện truy vấn.
	$OK = 1;

	if(isset($_REQUEST['MaSV'])&&isset($_REQUEST['sbtDel'])){
		$sql = "DELETE FROM sinhvien WHERE MaSV = '{$_REQUEST['MaSV']}'";
		echo $sql;
		if(mysqli_query($con,$sql)){
			echo "Xoá thành công 1 bản ghi";
		}else{
			echo "Có lỗi khi xóa bản ghi".mysqli_error($con);
		}
		$OK = 0;
	}
	   // XỬ LÝ SỬA DỮ LIỆU
    if (isset($_REQUEST['sbtEdit']) && isset($_REQUEST['MaSV'])) {

        $sql = "
        UPDATE sinhvien SET
            HoTen = '{$_REQUEST['HoTen']}',
            NgaySinh = '{$_REQUEST['NgaySinh']}',
            GioiTinh = '{$_REQUEST['GioiTinh']}',
            Lop = '{$_REQUEST['Lop']}',
            SDT = '{$_REQUEST['SoDienThoai']}',
            DiaChi = '{$_REQUEST['DiaChi']}'
        WHERE MaSV = '{$_REQUEST['MaSV']}'
        ";

        if (mysqli_query($con, $sql)) {
            echo "Sửa thành công 1 bản ghi";
        } else {
            echo "Có lỗi khi sửa bản ghi: " . mysqli_error($con);
        }
    }
	$order = "ORDER BY HoTen ASC";
	if(isset($_REQUEST['order'])){
    if($_REQUEST['order'] == 'ASC'){
        $order = "ORDER BY HoTen ASC";
    }else if($_REQUEST['order'] == 'DESC'){
        $order = "ORDER BY HoTen DESC";
    }
}else{
    $order = "ORDER BY HoTen ASC";
}

	if(isset($_REQUEST['p'])){
		$p = (int) $_REQUEST['p'];
	}else{
		$p=1;
	}
	if(isset($_REQUEST['ppage'])){
		$ppage = (int) $_REQUEST['ppage'];
	}else{
		$ppage=10;
	}
	if(isset($_REQUEST['NgaySinh'])){
		$dob = $_REQUEST['NgaySinh'];
		$dob = date($dob);
	}else{
		$dob=date('01/01/1970');
	}
	$start = $ppage*($p-1);
	$limit = "LIMIT $start, $ppage";
	if(isset($_REQUEST['q'])){
		$q = $_REQUEST['q'];
		$q = str_replace("'","",$q);
	}else{
		$q = "";
	}
	$sqlPage="SELECT
MaSV, HoTen, NgaySinh, GioiTinh, Lop,SDT, DiaChi
FROM sinhvien
WHERE MaSV LIKE '%$q%' OR HoTen LIKE '%$q%'  ";
	//echo $sqlPage;
	$resultPage = mysqli_query($con, $sqlPage);
	$totalPage = ceil(mysqli_num_rows($resultPage)/$ppage);
	for($i=1; $i<=$totalPage; $i++){
		if($i==$p){
		$od = isset($_REQUEST['order'])?$_REQUEST['order']:"";
		echo "<a href = '?q={$q}&&order={$od}&p={$i}&ppage={$ppage}' target = '_self' style = 'color:red; font-size:150%'>$i</a> ";
		}else{
		$od = isset($_REQUEST['order'])?$_REQUEST['order']:"";
		echo "<a href = '?q={$q}&&order={$od}&p={$i}&ppage={$ppage}' target = '_self' style = 'color:blue; text-decoration:none;'>$i</a> ";
		}
	}
	$sql="SELECT
MaSV, HoTen, NgaySinh, GioiTinh, Lop,SDT, DiaChi
FROM sinhvien
WHERE MaSV LIKE '%$q%' OR HoTen LIKE '%$q%'  $order $limit";
	//echo $sql;
	$result = mysqli_query($con, $sql);
	//print_r($result);
	$i = 1;
	//Bước 3: Xử lý kết quả trả về
	//Trình bày vào TABLE
	echo "<table border = 1 width = 100%>
	<tr>
		<th>STT</th>
<th>Mã sinh viên</th>
<th>Họ và tên</th>
<th>Ngày sinh</th>
<th>Giới tính</th>
<th>Lớp</th>
<th>Số điện thoại</th>
<th>Địa chỉ</th>
		<th>Hành động</th>
	</tr>
	";
	while($row = mysqli_fetch_array($result)){
		//echo $i." ".$row[0]. $row[1].$row[2].$row[3]."<br>";
		echo "<form name = 'frmEdit' action = '' method = 'POST'>
		<tr>
			<td>{$i}</td>			
			<td><input type = text value = '{$row[0]}' name = 'MaSV' readonly></td>
			<td><input type = text value = '{$row[1]}' name = 'HoTen'></td>
            <td><input type = date value = '{$row[2]}' name = 'NgaySinh' required></td>
  <td>
<select name='GioiTinh'>
    <option value='Nam' ".($row['GioiTinh']=='Nam'?'selected':'').">Nam</option>
    <option value='Nữ'  ".($row['GioiTinh']=='Nữ'?'selected':'').">Nữ</option>
</select>
</td>
            <td><input type = text value = '{$row[4]}' name = 'Lop' required></td>
            <td><input type = text value = '{$row[5]}' name = 'SoDienThoai' required></td>
            <td><input type = text value = '{$row[6]}' name = 'DiaChi' required></td>
			<td><input type = submit value = 'Sửa' name = 'sbtEdit'>			
			<input type = hidden name = 'p' value = '{$p}'>
			<input type = hidden name = 'ppage' value = '{$ppage}'>
			<input type = hidden name = 'q' value = '{$q}'>
			<input type = hidden name = 'order' value = '{$od}'>			
			</form>
			<form action = '' name = 'frmDel' method = 'POST'>
			<input type = hidden name = 'MaSV' value = '{$row['MaSV']}'>
			<input type = submit value = 'Xoá' name = 'sbtDel'>
			</form>
			</td>			
		</tr>";
		$i++;
	}

    echo "</table>";

    // Đóng kết nối
    mysqli_close($con);
    unset($sql, $sqlPage, $result, $i, $row, $p, $ppage, $order);
?>
<a href="../index.php" style="
    display: inline-block;
    padding: 8px 12px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
"> Quay về trang chủ</a>
    </body>
</html>