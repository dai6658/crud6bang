<!DOCTYPE html>
<html>
<head>
    <title>Quản lý ký túc xá</title>
    <meta charset="utf-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            padding: 20px;
            background: #2c7be5;
            color: white;
            margin: 0;
        }

        ul {
            width: 350px;
            margin: 40px auto;
            padding: 0;
            list-style: none;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        li {
            border-bottom: 1px solid #ddd;
        }

        li:last-child {
            border-bottom: none;
        }

        a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: background 0.3s;
        }

        a:hover {
            background: #e9f0ff;
            color: #2c7be5;
        }
    </style>
</head>

<body>

<h2>Hệ thống quản lý ký túc xá</h2>

<ul>
    <li><a href="sinhvien/index.php">Quản lý Sinh viên</a></li>
    <li><a href="phong/index.php">Quản lý Phòng</a></li>
    <li><a href="hopdong/index.php">Quản lý Hợp đồng</a></li>
    <li><a href="diennuoc/index.php">Quản lý Điện Nước</a></li>
    <li><a href="thanhtoan/index.php">Quản lý Thanh toán</a></li>
    <li><a href="suco/index_suco.php">Quản lý Sự cố</a></li>
    <li><a href="setup.php">Chạy file setup.php, chỉ chạy 1 lần thôi</a></li>
</ul>

</body>
</html>
