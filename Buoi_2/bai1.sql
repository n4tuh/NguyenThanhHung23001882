CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

-- 1. Tạo bảng cart_items
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

-- 2.1. Thêm ít nhất 5 sản phẩm vào bảng
INSERT INTO cart_items (name, price, quantity) VALUES
('Áo thun nam', 150000.00, 10),
('Quần jean', 350000.00, 4),
('Mũ lưỡi trai', 80000.00, 15),
('Giày thể thao', 550000.00, 2),
('Balo laptop', 250000.00, 7);

-- 2.2. Hiển thị toàn bộ sản phẩm
SELECT * FROM cart_items;

-- 2.3. Hiển thị sản phẩm có giá lớn hơn 100000
SELECT * FROM cart_items WHERE price > 100000;

-- 2.4. Hiển thị sản phẩm có số lượng lớn hơn 5
SELECT * FROM cart_items WHERE quantity > 5;

-- 2.5. Sắp xếp sản phẩm theo giá giảm dần
SELECT * FROM cart_items ORDER BY price DESC;

-- 2.6. Cập nhật giá của một sản phẩm (Ví dụ: Cập nhật giá của sản phẩm có id = 1)
UPDATE cart_items SET price = 160000.00 WHERE id = 1;

-- 2.7. Cập nhật số lượng của một sản phẩm (Ví dụ: Cập nhật số lượng của sản phẩm có id = 2)
UPDATE cart_items SET quantity = 6 WHERE id = 2;

-- 2.8. Xóa một sản phẩm (Ví dụ: Xóa sản phẩm có id = 3)
DELETE FROM cart_items WHERE id = 3;

-- 2.9. Hiển thị tên sản phẩm, giá, số lượng và thành tiền (price x quantity)
SELECT 
    name, 
    price, 
    quantity, 
    (price * quantity) AS total_amount 
FROM cart_items;

-- 2.10. Tính tổng tiền của toàn bộ giỏ hàng
SELECT SUM(price * quantity) AS cart_total FROM cart_items;
