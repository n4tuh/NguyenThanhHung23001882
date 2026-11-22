<?php
require __DIR__ . '/common.php';

$method = $_SERVER['REQUEST_METHOD'];

// GET api/products.php?page=1&limit=5
if ($method === 'GET') {
    $pageInput = $_GET['page'] ?? '1';
    $limitInput = $_GET['limit'] ?? '5';

    if (!is_string($pageInput) || !preg_match('/^[1-9][0-9]*$/D', $pageInput)) {
        fail('page phải là số nguyên dương.');
    }

    if ($limitInput !== '5') {
        fail('limit phải bằng 5.');
    }

    $pdo = connectDB();
    $limit = 5;

    // Hai truy vấn đếm và lấy dữ liệu cùng nhìn thấy một trạng thái của bảng.
    $pdo->exec('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ');
    $pdo->beginTransaction();

    $total = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    $totalPages = max(1, (int) ceil($total / $limit));
    $page = min((int) $pageInput, $totalPages);
    $offset = ($page - 1) * $limit;

    $stmt = $pdo->prepare(
        'SELECT id, name, price, image
         FROM products
         ORDER BY id DESC
         LIMIT ? OFFSET ?'
    );

    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();

    $products = $stmt->fetchAll();
    $pdo->commit();

    respond([
        'success' => true,
        'data' => $products,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'total_pages' => $totalPages
        ]
    ]);
}

if (!in_array($method, ['POST', 'PUT', 'DELETE'], true)) {
    fail('Phương thức không được hỗ trợ.', 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    fail('Dữ liệu gửi lên phải là JSON.');
}

$id = $method === 'POST' ? null : productId($input['id'] ?? null);

if ($method !== 'DELETE') {
    $name = is_string($input['name'] ?? null) ? trim($input['name']) : '';
    $price = $input['price'] ?? null;

    if (!preg_match('/^.{1,150}$/usD', $name)) {
        fail('Tên sản phẩm phải có từ 1 đến 150 ký tự.');
    }

    if ((!is_string($price) && !is_int($price))
        || !preg_match('/^[0-9]{1,12}$/D', (string) $price)) {
        fail('Giá phải là số nguyên không âm, tối đa 12 chữ số.');
    }
}

$pdo = connectDB();

if ($method === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO products (name, price) VALUES (?, ?)');
    $stmt->execute([$name, $price]);

    respond([
        'success' => true,
        'id' => (int) $pdo->lastInsertId(),
        'message' => 'Đã thêm sản phẩm.'
    ], 201);
}

$pdo->beginTransaction();

$stmt = $pdo->prepare('SELECT image FROM products WHERE id = ? FOR UPDATE');
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $pdo->rollBack();
    fail('Không tìm thấy sản phẩm.', 404);
}

if ($method === 'PUT') {
    // Cột image chỉ được cập nhật trong upload.php khi lưu ảnh thành công.
    $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ? WHERE id = ?');
    $stmt->execute([$name, $price, $id]);
} else {
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$id]);
}

$pdo->commit();

if ($method === 'DELETE') {
    removeImage($product['image']);
}

respond(['success' => true, 'id' => $id]);
