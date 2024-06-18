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
$password = "123456";
//$password = "";
$dbname = "nguyenvantu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy user_id từ cookie
$user_id = $_COOKIE['user_id'];

// Kiểm tra xem có tham số id được truyền từ URL không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Xóa sản phẩm khỏi giỏ hàng
    $sql = "DELETE FROM giohang WHERE user_id = '$user_id' AND hanghoa_id = '$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Sản phẩm đã được xóa khỏi giỏ hàng.";
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
}

$conn->close();

// Chuyển hướng về trang giỏ hàng
header("Location: cart.php");
exit();
?>