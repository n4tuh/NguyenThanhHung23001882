<?php
// product_edit.php
require_once 'model/product.php';

$error = "";
if (!isset($_GET['id'])) {
    die("Thiếu ID sản phẩm.");
}
$id = $_GET['id'];
$product = getProductById($id); //[cite: 2]

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Kiểm tra dữ liệu[cite: 2, 3]
    if (empty($name)) {
        $error = "Tên sản phẩm không được rỗng.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá phải lớn hơn 0.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Số lượng phải lớn hơn hoặc bằng 0.";
    } else {
        if (updateProduct($id, $name, $price, $quantity)) { //[cite: 2]
            header("Location: product_list.php");
            exit();
        } else {
            $error = "Có lỗi xảy ra khi cập nhật.";
        }
    }
}
include 'view/header.php';
?>

<h3>Sửa Sản Phẩm</h3>
<p style="color:red;"><?php echo $error; ?></p>
<form method="POST" action="">
    <label>Tên sản phẩm:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>"><br><br>

    <label>Giá:</label><br>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>"><br><br>

    <label>Số lượng:</label><br>
    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>"><br><br>

    <button type="submit">Cập nhật</button>
    <a href="product_list.php">Hủy</a>
</form>

<?php include 'view/footer.php'; ?>
