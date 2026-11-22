<?php
require __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail('API upload chỉ chấp nhận POST.', 405);
}

if (!$_POST && !$_FILES && !empty($_SERVER['CONTENT_LENGTH'])) {
    fail('Dữ liệu tải lên không hợp lệ hoặc vượt giới hạn máy chủ.');
}

$id = productId($_POST['id'] ?? null);
$file = $_FILES['image'] ?? null;

if (!$file || is_array($file['error'])) {
    fail('Vui lòng chọn một ảnh.');
}

if (in_array($file['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
    fail('Ảnh vượt giới hạn tải lên. Dung lượng tối đa là 2 MB.');
}

if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
    fail('Không nhận được file ảnh hoàn chỉnh.');
}

$tmp = $file['tmp_name'];
$size = filesize($tmp);

if (!$size || $size > 2 * 1024 * 1024) {
    fail('Ảnh phải có dữ liệu và dung lượng tối đa 2 MB.');
}

$allowedTypes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png'
];

$mime = (new finfo(FILEINFO_MIME_TYPE))->file($tmp);
$imageInfo = @getimagesize($tmp);
$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($extension === 'jpeg') {
    $extension = 'jpg';
}

if (!isset($allowedTypes[$mime])
    || !$imageInfo
    || $imageInfo['mime'] !== $mime
    || $extension !== $allowedTypes[$mime]) {
    fail('File phải là ảnh JPG, JPEG hoặc PNG đúng định dạng.');
}

$pdo = connectDB();
$pdo->beginTransaction();

$stmt = $pdo->prepare('SELECT image FROM products WHERE id = ? FOR UPDATE');
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $pdo->rollBack();
    fail('Không tìm thấy sản phẩm cần tải ảnh.', 404);
}

$fileName = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mime];
$relativePath = 'uploads/' . $fileName;
$absolutePath = dirname(__DIR__) . '/' . $relativePath;

if (!move_uploaded_file($tmp, $absolutePath)) {
    $pdo->rollBack();
    fail('Không thể ghi ảnh. Hãy kiểm tra quyền ghi của thư mục uploads.', 500);
}

try {
    $stmt = $pdo->prepare('UPDATE products SET image = ? WHERE id = ?');
    $stmt->execute([$relativePath, $id]);
    $pdo->commit();
} catch (Throwable $error) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
        removeImage($relativePath);
    }
    throw $error;
}

removeImage($product['image']);

respond([
    'success' => true,
    'message' => 'Đã tải ảnh thành công.',
    'image' => $relativePath
]);
