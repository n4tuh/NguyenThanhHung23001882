<?php
// product_list.php
require_once 'model/product.php';
$products = getAllProducts();
include 'view/header.php'; //[cite: 2]
?>

<h3>Danh sách sản phẩm</h3>
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
        <td><?php echo $p['id']; ?></td>
        <td><?php echo $p['name']; ?></td>
        <td><?php echo number_format($p['price'], 2); ?></td>
        <td><?php echo $p['quantity']; ?></td>
        <td>
            <a href="product_edit.php?id=<?php echo $p['id']; ?>">[Sửa]</a> <!--[cite: 2] -->
            <a href="product_delete.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">[Xóa]</a> <!--[cite: 2] -->
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'view/footer.php'; //[cite: 2] ?>
