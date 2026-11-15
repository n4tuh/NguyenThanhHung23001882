<?php
header('Content-Type: application/json; charset=utf-8');

$host = '127.0.0.1';
$db   = 'vue_php_crud';
$user = 'root'; // Sửa tài khoản DB của bạn tại đây
$pass = '';     // Sửa mật khẩu DB của bạn tại đây

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Lỗi kết nối CSDL"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$input = json_decode(file_get_contents('php://input'), true);

// Hàm Validate dữ liệu
function validateData($data) {
    $name = trim($data['name'] ?? '');
    $price = $data['price'] ?? 0;
    $stock = $data['stock'] ?? -1;

    if (mb_strlen($name) < 1 || mb_strlen($name) > 100) return "Tên sản phẩm phải từ 1 đến 100 ký tự.";
    if (!filter_var($price, FILTER_VALIDATE_INT) || $price <= 0) return "Đơn giá phải là số nguyên lớn hơn 0.";
    if (!filter_var($stock, FILTER_VALIDATE_INT) || $stock < 0) return "Số lượng tồn phải là số nguyên không âm.";
    
    return ["name" => $name, "price" => $price, "stock" => $stock];
}

// Hàm kiểm tra ID tồn tại
function checkIdExists($pdo, $id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn() > 0;
}

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $data]);
        break;

    case 'POST':
        $validated = validateData($input);
        if (is_string($validated)) {
            echo json_encode(["success" => false, "message" => $validated]);
            break;
        }
        $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        $stmt->execute([$validated['name'], $validated['price'], $validated['stock']]);
        echo json_encode(["success" => true]);
        break;

    case 'PUT':
        if (!$id || !checkIdExists($pdo, $id)) {
            echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);
            break;
        }
        $validated = validateData($input);
        if (is_string($validated)) {
            echo json_encode(["success" => false, "message" => $validated]);
            break;
        }
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$validated['name'], $validated['price'], $validated['stock'], $id]);
        echo json_encode(["success" => true]);
        break;

    case 'DELETE':
        if (!$id || !checkIdExists($pdo, $id)) {
            echo json_encode(["success" => false, "message" => "Sản phẩm không tồn tại."]);
            break;
        }
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["success" => true]);
        break;

    default:
        echo json_encode(["success" => false, "message" => "Phương thức không hợp lệ."]);
        break;
}
