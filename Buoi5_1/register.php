<?php
require_once 'common/dbConnect.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Tên đăng nhập đã tồn tại!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($insert->execute([$username, $hashed_password])) {
                echo "<script>alert('Đăng ký thành công!'); window.location.href='login.php';</script>";
                exit;
            }
        }
    }
}
include 'view/header.php';
?>
<h2>Đăng Ký</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    Tên đăng nhập: <input type="text" name="username"><br><br>
    Mật khẩu: <input type="password" name="password"><br><br>
    <button type="submit">Đăng Ký</button>
    <a href="login.php">Đã có tài khoản? Đăng nhập</a>
</form>
<?php include 'view/footer.php'; ?>
