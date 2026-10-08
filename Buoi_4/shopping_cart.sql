
CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);


INSERT INTO products (name, price, quantity) VALUES
('Sản phẩm A', 150000.00, 10),
('Sản phẩm B', 200000.00, 15),
('Sản phẩm C', 50000.00, 100),
('Sản phẩm D', 320000.00, 5),
('Sản phẩm E', 120000.00, 20);
