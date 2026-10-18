<?php
include 'view/header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'model/product.php';

$id = $_GET['id'] ?? 0;
$product = getProductById($id);

if (!$product) {
    echo "<p>Sản phẩm không tồn tại!</p>";
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['confirm'])) {
            deleteProduct($id);
        }
        header("Location: product_list.php");
        exit;
    }
    ?>
    <h2>Xác Nhận Xóa</h2>
    <p>Bạn có chắc chắn muốn xóa sản phẩm <b><?= htmlspecialchars($product['name']) ?></b>?</p>
    <form method="POST">
        <button type="submit" name="confirm">Có, Xóa</button>
        <a href="product_list.php">Hủy</a>
    </form>
    <?php
}
include 'view/footer.php'; 
?>
