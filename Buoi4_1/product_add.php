<?php
// product_add.php
require_once 'model/product.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Kiểm tra dữ liệu: Tên không rỗng, Giá > 0, Số lượng >= 0[cite: 2]
    if (empty($name)) {
        $error = "Tên sản phẩm không được rỗng.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá phải lớn hơn 0.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Số lượng phải lớn hơn hoặc bằng 0.";
    } else {
        if (addProduct($name, $price, $quantity)) { //[cite: 2]
            header("Location: product_list.php");
            exit();
        } else {
            $error = "Có lỗi xảy ra khi thêm dữ liệu.";
        }
    }
}
include 'view/header.php';
?>

<h3>Thêm Sản Phẩm</h3>
<p style="color:red;"><?php echo $error; ?></p>
<form method="POST" action="">
    <label>Tên sản phẩm:</label><br>
    <input type="text" name="name" value=""><br><br>

    <label>Giá:</label><br>
    <input type="number" step="0.01" name="price" value=""><br><br>

    <label>Số lượng:</label><br>
    <input type="number" name="quantity" value=""><br><br>

    <button type="submit">Thêm</button>
    <a href="product_list.php">Hủy</a>
</form>

<?php include 'view/footer.php'; ?>
