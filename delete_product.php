<?php
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

// Kiểm tra xem có tham số id được truyền từ URL không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Xóa sản phẩm từ bảng hanghoa
    $sql = "DELETE FROM hanghoa WHERE mahh = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa sản phẩm thành công.";
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
}

$conn->close();
?>