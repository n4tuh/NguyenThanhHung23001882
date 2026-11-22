CREATE DATABASE IF NOT EXISTS bai9
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE bai9;

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(12, 0) UNSIGNED NOT NULL,
    image VARCHAR(255) NULL DEFAULT NULL
) ENGINE=InnoDB;

INSERT INTO products (name, price) VALUES
('Sổ tay A5', 35000),
('Bút bi xanh', 5000),
('Bút chì 2B', 7000),
('Thước kẻ 20 cm', 8000),
('Tẩy trắng', 6000),
('Hộp bút vải', 45000),
('Giấy ghi chú', 12000),
('Kẹp giấy', 10000),
('Bìa hồ sơ', 15000),
('Bút dạ quang', 18000),
('Băng dính giấy', 14000),
('Vở ô ly', 11000);
