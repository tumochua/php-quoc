<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
//$password = "123456";
$dbname = "nguyenvantu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$hanghoa_id = $_POST['hanghoa_id'];
$soluong = $_POST['soluong'];
$user_id = $_COOKIE['user_id'];
$ngaythem = date('Y-m-d');

// Thêm sản phẩm vào giỏ hàng
$sql = "INSERT INTO giohang (user_id, hanghoa_id, soluong, ngaythem) VALUES ('$user_id', '$hanghoa_id', '$soluong', '$ngaythem')";

if ($conn->query($sql) === TRUE) {
    // Chuyển hướng về trang giỏ hàng
    header("Location: cart.php");
    exit();
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>