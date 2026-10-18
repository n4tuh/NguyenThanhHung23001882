<?php
include 'view/header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'model/product.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    if (empty($name)) {
        $error = "Tên sản phẩm không được rỗng.";
    } elseif ($price <= 0) {
        $error = "Giá phải lớn hơn 0.";
    } elseif ($quantity < 0) {
        $error = "Số lượng phải lớn hơn hoặc bằng 0.";
    } else {
        addProduct($name, $price, $quantity);
        header("Location: product_list.php");
        exit;
    }
}
?>
<h2>Thêm Sản Phẩm</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    Tên sản phẩm: <input type="text" name="name"><br><br>
    Giá: <input type="number" step="0.01" name="price"><br><br>
    Số lượng: <input type="number" name="quantity"><br><br>
    <button type="submit">Thêm</button>
</form>
<?php include 'view/footer.php'; ?>
