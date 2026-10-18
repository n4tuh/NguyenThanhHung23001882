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
    die("Sản phẩm không tồn tại!");
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    if (empty($name) || $price <= 0 || $quantity < 0) {
        $error = "Dữ liệu không hợp lệ!";
    } else {
        updateProduct($id, $name, $price, $quantity);
        header("Location: product_list.php");
        exit;
    }
}
?>
<h2>Sửa Sản Phẩm</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    Tên sản phẩm: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"><br><br>
    Giá: <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"><br><br>
    Số lượng: <input type="number" name="quantity" value="<?= $product['quantity'] ?>"><br><br>
    <button type="submit">Cập nhật</button>
</form>
<?php include 'view/footer.php'; ?>
