<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

function fail(string $message, int $status = 400): void
{
    respond(['success' => false, 'message' => $message], $status);
}

set_exception_handler(function (Throwable $error) {
    error_log((string) $error);
    fail('Lỗi máy chủ. Hãy kiểm tra kết nối MySQL và nhật ký PHP.', 500);
});

function connectDB(): PDO
{
    return new PDO(
        'mysql:host=localhost;dbname=bai9;charset=utf8mb4',
        'root',
        '', // Điền mật khẩu nếu tài khoản MySQL của bạn có mật khẩu.
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
}

function productId($value): int
{
    if (!is_string($value) && !is_int($value)) {
        fail('Mã sản phẩm không hợp lệ.');
    }

    $id = filter_var($value, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);

    if ($id === false) {
        fail('Mã sản phẩm phải là số nguyên dương.');
    }

    return $id;
}

// Chỉ xóa những file có tên do ứng dụng này tạo.
function removeImage(?string $path): void
{
    if (!$path || !preg_match('~^uploads/[a-f0-9]{32}\.(jpg|png)$~D', $path)) {
        return;
    }

    $file = dirname(__DIR__) . '/' . $path;

    if (is_file($file) && !@unlink($file)) {
        error_log('Không thể xóa ảnh: ' . $file);
    }
}
