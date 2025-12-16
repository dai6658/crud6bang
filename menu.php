<?php ob_start(); ?>
<style>
    :root {
        --primary: #2c82e0;
        --primary-dark: #1f63b3;
        --accent: #2ecc71;
        --text: #2c3e50;
        --muted: #607080;
        --surface: #ffffff;
        --border: #e5e8f0;
        --bg: #f5f7fb;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: "Segoe UI", Arial, sans-serif;
        background: var(--bg);
        color: var(--text);
    }

    a { color: var(--primary); text-decoration: none; }
    a:hover { color: var(--primary-dark); }

    .topbar {
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        color: #fff;
        padding: 14px 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 18px;
    }

    .brand {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .nav {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .nav a {
        display: inline-block;
        padding: 8px 12px;
        background: rgba(255,255,255,0.12);
        color: #fff;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.15s ease, transform 0.1s ease;
    }

    .nav a:hover {
        background: rgba(255,255,255,0.22);
        transform: translateY(-1px);
    }

    h2, h3 {
        margin: 0 0 12px 0;
        color: var(--text);
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        margin-bottom: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: var(--surface);
        border: 1px solid var(--border);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border-radius: 10px;
        overflow: hidden;
    }

    th, td {
        padding: 10px 12px;
        border: 1px solid var(--border);
        text-align: left;
    }

    th {
        background: var(--primary);
        color: #fff;
        letter-spacing: 0.2px;
    }

    tr:nth-child(even) td {
        background: #f8fafe;
    }

    .actions a {
        margin-right: 8px;
        color: var(--primary);
        font-weight: 600;
    }

    .actions a:last-child {
        margin-right: 0;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 700;
        transition: transform 0.1s ease, box-shadow 0.1s ease;
    }

    .btn-primary {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 3px 8px rgba(44,130,224,0.25);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-accent {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 3px 8px rgba(46,204,113,0.25);
    }

    input, button {
        font-family: inherit;
    }

    input, select {
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid var(--border);
        outline: none;
        background: #fff;
    }

    input:focus, select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44,130,224,0.12);
    }

    form label {
        display: inline-block;
        margin-bottom: 6px;
        color: var(--muted);
        font-weight: 600;
    }

    .link-secondary {
        color: var(--muted);
        font-weight: 600;
    }

    .link-secondary:hover {
        color: var(--primary-dark);
    }
</style>

<div class="topbar">
    <div class="brand">Hệ thống quản lý ký túc xá</div>
    <ul class="nav">
        <li><a href="/crud6bang/sinhvien/index.php">Quản lý Sinh viên</a></li>
        <li><a href="/crud6bang/phong/index.php">Quản lý Phòng</a></li>
        <li><a href="/crud6bang/hopdong/index.php">Quản lý Hợp đồng</a></li>
        <li><a href="/crud6bang/diennuoc/index.php">Quản lý Điện Nước</a></li>
        <li><a href="/crud6bang/thanhtoan/index.php">Quản lý Thanh toán</a></li>
        <li><a href="/crud6bang/suco/index_suco.php">Quản lý Sự cố</a></li>
    </ul>
</div>