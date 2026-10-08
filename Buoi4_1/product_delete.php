<?php
// product_delete.php
require_once 'model/product.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Kiểm tra sản phẩm có tồn tại không trước khi xóa[cite: 2]
    $product = getProductById($id);
    
    if ($product) {
        deleteProduct($id); //[cite: 2]
        header("Location: product_list.php");
        exit();
    } else {
        echo "Sản phẩm không tồn tại."; // Thông báo nếu sản phẩm không tồn tại[cite: 2]
        echo '<br><a href="product_list.php">Quay lại danh sách</a>';
    }
} else {
    echo "Không tìm thấy ID sản phẩm.";
}
?>
