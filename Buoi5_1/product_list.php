<?php
include 'view/header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'model/product.php';
$products = getAllProducts();
?>
<h2>Danh Sách Sản Phẩm</h2>
<a href="product_add.php">Thêm sản phẩm mới</a><br><br>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Chức năng</th>
    </tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= number_format($p['price']) ?> VNĐ</td>
        <td><?= $p['quantity'] ?></td>
        <td>
            <a href="product_edit.php?id=<?= $p['id'] ?>">[Sửa]</a>
            <a href="product_delete.php?id=<?= $p['id'] ?>">[Xóa]</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include 'view/footer.php'; ?>
