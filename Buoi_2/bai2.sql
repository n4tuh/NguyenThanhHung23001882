-- 1. Tạo bảng movies
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

-- 2.1. Thêm ít nhất 5 bộ phim
INSERT INTO movies (title, price, total_seats, available_seats) VALUES
('Lật Mặt 7', 120000.00, 200, 45),
('Mai', 110000.00, 150, 10),
('Dune 2', 150000.00, 250, 120),
('Godzilla x Kong', 130000.00, 200, 60),
('Kung Fu Panda 4', 90000.00, 180, 100);

-- 2.2. Hiển thị toàn bộ danh sách phim
SELECT * FROM movies;

-- 2.3. Hiển thị phim có giá vé lớn hơn 100000
SELECT * FROM movies WHERE price > 100000;

-- 2.4. Hiển thị phim còn nhiều hơn 50 ghế
SELECT * FROM movies WHERE available_seats > 50;

-- 2.5. Sắp xếp phim theo giá vé giảm dần
SELECT * FROM movies ORDER BY price DESC;

-- 2.6. Cập nhật số ghế còn lại của một phim (Ví dụ: Cập nhật phim có id = 1)
UPDATE movies SET available_seats = 30 WHERE id = 1;

-- 2.7. Xóa một phim (Ví dụ: Xóa phim có id = 5)
DELETE FROM movies WHERE id = 5;

-- 2.8. Hiển thị số vé đã bán của từng phim: total_seats - available_seats
SELECT 
    title, 
    (total_seats - available_seats) AS sold_tickets 
FROM movies;

-- 2.9. Tính doanh thu của từng phim: (total_seats - available_seats) x price
SELECT 
    title, 
    ((total_seats - available_seats) * price) AS revenue 
FROM movies;

-- 2.10. Tính tổng doanh thu của tất cả các phim
SELECT SUM((total_seats - available_seats) * price) AS total_revenue FROM movies;

-- 2.11. Tìm phim có số vé bán ra nhiều nhất (Sử dụng MAX)
SELECT 
    title, 
    (total_seats - available_seats) AS sold_tickets 
FROM movies 
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats) FROM movies
);
