-- Tạo database
CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

-- Tạo bảng products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

-- Thêm 5 sản phẩm mẫu
INSERT INTO products (name, price, quantity) VALUES 
('Sản phẩm A', 150000.00, 10),
('Sản phẩm B', 250000.00, 5),
('Sản phẩm C', 50000.00, 20),
('Sản phẩm D', 300000.00, 8),
('Sản phẩm E', 120000.00, 15);

-- Tạo bảng users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Thêm 1 tài khoản mẫu (username: admin, password: 123 - đã được hash bằng password_hash)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
