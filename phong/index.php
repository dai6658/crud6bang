<?php include "../menu.php"; ?>
<html>
    <head>
        <title>xay dung tim kiem  </title>
        <meta charset ='utf-8'>
      
</head>
<body>
    <form method ='GET'>
        <input type =text name='q'>
        <select name ='order'>
            <option value= 'ASC'> sắp xếp tăng dần theo Mã phòng</option>
            <option value= 'DESC'>sắp xếp giảm dần theo Mã phòng</option>
</select>
<select name ='ppage'>
    <option value =5>5 bản ghi /trang</option>
  <option value =10>10 bản ghi /trang</option>
    <option value =20>20 bản ghi /trang</option>
    <option value =30>30 bản ghi /trang</option>
</select>
<input type= 'submit' name='btnSubmit' value='tìm'>
</form>
<a href="add.php"> Thêm phòng</a><br><br>
<a href="themphong.php"> Thêm phòng ngẫu nhiên</a><br><br>
<a href="edit.php"> Vào giao diện sửa xóa</a><br><br>
<p>Lưu ý:Loại phòng A là phòng cho Nam, B cho Nữ,C cho Nam<p><br>
<?php
//buoc 1ket noi CSDL
$con =mysqli_connect("localhost","root","","ktx_management");
// $sql="SELECT * FROM users";
$order="ORDER BY MaPhong ASC";
if (isset($_GET['order'])){
    if($_GET['order']=="ASC"){
        $order = "ORDER BY MaPhong ASC";
    }else if($_GET['order']=="DESC"){
        $order = "ORDER BY MaPhong DESC";
    }
    else{
        $order="ORDER BY MaPhong ASC";
    }
}
if(isset($_GET['p'])){
    $p=(int)$_GET['p'];
}
else{
    $p=1;
}

if(isset($_GET['ppage'])){
    $ppage=(int)$_GET['ppage'];
}
else{
    $ppage=10;
}
$start=$ppage*($p-1);
$limit="LIMIT $start,$ppage";
if (isset($_GET['q'])){
    $q=$_GET['q'];
}
else{
    $q="";
}
$sqlPage="SELECT
MaPhong, LoaiPhong, SoNguoiToiDa, TinhTrang
FROM phong
WHERE MaPhong LIKE '%$q%' OR LoaiPhong LIKE '%$q%'  ";
$resultPage=mysqli_query($con,$sqlPage);
$totalPage=ceil(mysqli_num_rows($resultPage)/$ppage);
for($i=1;$i<=$totalPage;$i++){
    if ($i==$p){
    $od=isset($_GET['order'])?$_GET['order']:"";
    echo"<a href='?q={$q}&&order={$od}&p={$i}&ppage={$ppage}'target='_self'
    style='color:red;font-size:150%'>$i</a>";
}else{$od=isset($_GET['order'])?$_GET['order']:"";
    echo"<a href='?q={$q}&&order={$od}&p={$i}&ppage={$ppage}'target='_self'
    style='color:blue;text-decoration:none'>$i</a>";
}
}
$sql="SELECT
MaPhong, LoaiPhong, SoNguoiToiDa, TinhTrang
FROM Phong
WHERE MaPhong LIKE '%$q%' OR LoaiPhong LIKE '%$q%'  $order $limit";
//echo $sql;
//echo $sqlPage;
//buoc 2 xay dung cau truy van
$result=mysqli_query($con,$sql);
$i=1;
//print_r($result);
//buoc 3 xu ly du lieu tra ve
//trinh bay vao table
echo "<table border='1' width=100%> 
<tr>
<th>STT</th>
<th>Mã Phòng</th>
<th>Loại Phòng</th>
<th>Số người tối đa</th>
<th>Tình trạng</th>
</tr>";
while($row=mysqli_fetch_array($result)){
    // echo $i." ". $row['uid']. $row['fullname']. $row['password']. $row['dob']."<br>";
    echo "<tr>
    <td>".$i."</td>
    <td>".$row['MaPhong']."</td>
    <td>".$row['LoaiPhong']."</td>
    <td>".$row['SoNguoiToiDa']."</td>
    <td>".$row['TinhTrang']."</td>
    </tr>";
    $i++;
}

    echo "</table>";

//buoc 4 dong ket noi
mysqli_close($con);
unset($sql,$sqlPage,$result,$row,$i,$p,$ppage,$start,$limit,$order);
?>
<br><br>
<a href="../index.php" style="
    display: inline-block;
    padding: 8px 12px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
"> Quay về trang chủ</a>
<br><br>
</body>
</html>