<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sản Phẩm</title>
</head>
<body>
    <header>
        <h1>Hệ Thống Quản Lý Giỏ Hàng</h1>
        <?php if(isset($_SESSION['user_id'])): ?>
            <p>Xin chào, <b><?= htmlspecialchars($_SESSION['username']) ?></b> | 
            <a href="product_list.php">Danh sách</a> | 
            <a href="logout.php">Đăng xuất</a></p>
        <?php endif; ?>
        <hr>
    </header>
    <main>
