<?php
require_once 'common/dbConnect.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: product_list.php");
        exit;
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
    }
}
include 'view/header.php';
?>
<h2>Đăng Nhập</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    Tên đăng nhập: <input type="text" name="username"><br><br>
    Mật khẩu: <input type="password" name="password"><br><br>
    <button type="submit">Đăng Nhập</button>
    <a href="register.php">Chưa có tài khoản? Đăng ký</a>
</form>
<?php include 'view/footer.php'; ?>
