<?php
// Kiểm tra phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "123456";
    $database = "nguyenvantu";

    $conn = new mysqli($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    // Nhận dữ liệu từ biểu mẫu
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $ma_loai = isset($_POST['ma_loai']) ? $_POST['ma_loai'] : '';

    // Kiểm tra các biến đã được thiết lập đúng cách
    if ($name && $price && $quantity && $image && $description && $status && $ma_loai) {
        // Upload hình ảnh vào thư mục trên server
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Thực hiện truy vấn để thêm hàng hóa
        $sql = "INSERT INTO hanghoa (tenhh, gia, soluong, hinh, mota, trangthai, ngaytao, ngaysua, ma_loai) 
                VALUES ('$name', '$price', '$quantity', '$image', '$description', '$status', NOW(), NOW(), '$ma_loai')";
        if ($conn->query($sql) === TRUE) {
            echo "Thêm hàng hóa thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }

    // Đóng kết nối
    $conn->close();
} else {
    echo "Phương thức không hợp lệ.";
}
?>