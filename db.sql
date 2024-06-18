-- User
-- create database nguyenvantu;

-- use nguyenvantu;

-- -- Bảng loại hàng
-- CREATE TABLE loaihang (
--     maloai INT AUTO_INCREMENT PRIMARY KEY,
--     tenloai VARCHAR(150) NOT NULL
-- );

-- -- Bảng hàng hóa
-- CREATE TABLE hanghoa (
--     mahh INT AUTO_INCREMENT PRIMARY KEY,
--     tenhh TEXT NOT NULL,
--     gia FLOAT NOT NULL,
--     soluong INT NOT NULL,
--     hinh VARCHAR(50) NOT NULL,
--     ngaytao DATE NOT NULL,
--     mota TEXT NOT NULL,
--     trangthai INT NOT NULL,
--     ngaysua DATE NOT NULL,
--     ma_loai INT NOT NULL,
--     FOREIGN KEY (ma_loai) REFERENCES loaihang(maloai)
-- );
-- -- Bảng tài khoản
-- CREATE TABLE taikhoan (
--     matk INT AUTO_INCREMENT PRIMARY KEY,
--     tentk VARCHAR(50) NOT NULL,
--     email VARCHAR(50) NOT NULL,
--     matkhau VARCHAR(191) NOT NULL,
--     rolename  VARCHAR(50) NOT NULL
-- );

-- CREATE TABLE giohang (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT NOT NULL,
--     hanghoa_id INT NOT NULL,
--     soluong INT NOT NULL,
--     ngaythem DATE NOT NULL,
--     FOREIGN KEY (user_id) REFERENCES taikhoan(matk),
--     FOREIGN KEY (hanghoa_id) REFERENCES hanghoa(mahh)
-- );



-- -- Thêm dữ liệu vào bảng tài khoản với mật khẩu được tạo từ tên
-- INSERT INTO taikhoan (tentk, email, matkhau,rolename) VALUES
-- ('admin', 'admin@gmail.com', 'admin123','admin'),
-- ('toi', 'toi@gmail.com', 'toi123','users'),
-- ('truong', 'truong@gmail.com', 'truong123','users'),
-- ('tai', 'tai@gmail.com', 'tai123','users'),
-- ('hau', 'hau@gmail.com', 'hau123','users'),
-- ('bach', 'bach@gmail.com', 'bach123','users');

-- select * from taikhoan;

-- INSERT INTO loaihang (tenloai) VALUES
-- ('Điện thoại di động'),
-- ('Laptop'),
-- ('Máy tính bảng'),
-- ('Phụ kiện điện tử'),
-- ('Đồ gia dụng'),
-- ('Thời trang'),
-- ('Giày dép'),
-- ('Túi xách'),
-- ('Trang sức'),
-- ('Sức khỏe & Làm đẹp');

-- select * from hanghoa;



create database dtt_examphp;

use dtt_examphp;

-- Bảng loại hàng
CREATE TABLE brands (
    brand_id INT AUTO_INCREMENT PRIMARY KEY,
    brand_name VARCHAR(150) NOT NULL
);

-- Bảng hàng hóa
CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name TEXT NOT NULL,
    price FLOAT NOT NULL,
    quantity INT NOT NULL,
    images VARCHAR(50) NOT NULL,
    date_create DATE NOT NULL,
    description TEXT NOT NULL,
    status INT NOT NULL,
    date_update DATE NOT NULL,
    brand_id INT NOT NULL,
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id)
);
-- Bảng tài khoản
CREATE TABLE taikhoan (
    matk INT AUTO_INCREMENT PRIMARY KEY,
    tentk VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    matkhau VARCHAR(191) NOT NULL,
    rolename  VARCHAR(50) NOT NULL
);

CREATE TABLE giohang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hanghoa_id INT NOT NULL,
    soluong INT NOT NULL,
    ngaythem DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES taikhoan(matk),
    FOREIGN KEY (hanghoa_id) REFERENCES hanghoa(mahh)
);



-- Thêm dữ liệu vào bảng tài khoản với mật khẩu được tạo từ tên
INSERT INTO taikhoan (tentk, email, matkhau,rolename) VALUES
('admin', 'admin@gmail.com', 'admin123','admin'),
('toi', 'toi@gmail.com', 'toi123','users'),
('truong', 'truong@gmail.com', 'truong123','users'),
('tai', 'tai@gmail.com', 'tai123','users'),
('hau', 'hau@gmail.com', 'hau123','users'),
('bach', 'bach@gmail.com', 'bach123','users');

select * from taikhoan;

INSERT INTO loaihang (tenloai) VALUES
('Điện thoại di động'),
('Laptop'),
('Máy tính bảng'),
('Phụ kiện điện tử'),
('Đồ gia dụng'),
('Thời trang'),
('Giày dép'),
('Túi xách'),
('Trang sức'),
('Sức khỏe & Làm đẹp');

select * from hanghoa;
