<?php
// common/dbConnect.php
$servername = "localhost";
$username = "root"; // Thay đổi nếu cấu hình MySQL của bạn khác
$password = "";     // Thay đổi nếu MySQL của bạn có mật khẩu
$dbname = "shopping_cart"; //[cite: 1]

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Xử lý trường hợp kết nối thất bại[cite: 1]
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
