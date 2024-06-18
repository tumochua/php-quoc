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

    // Truy vấn dữ liệu sản phẩm từ bảng hanghoa
    $sql = "SELECT * FROM hanghoa WHERE mahh = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy dữ liệu sản phẩm
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy sản phẩm.";
        exit();
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit();
}

// Truy vấn dữ liệu từ bảng loaihang
$sql_loaihang = "SELECT * FROM loaihang";
$result_loaihang = $conn->query($sql_loaihang);

// Truy vấn dữ liệu từ bảng trạng thái
$sql_trangthai = "SELECT DISTINCT trangthai FROM hanghoa";
$result_trangthai = $conn->query($sql_trangthai);

// Kiểm tra xem form có được submit hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenhh = $_POST['tenhh'];
    $gia = $_POST['gia'];
    $soluong = $_POST['soluong'];
    $trangthai = $_POST['trangthai'];
    $mota = $_POST['mota'];
    $ma_loai = $_POST['ma_loai'];

    // Cập nhật dữ liệu sản phẩm
    $sql_update = "UPDATE hanghoa SET tenhh='$tenhh', gia='$gia', soluong='$soluong', trangthai='$trangthai', mota='$mota', ma_loai='$ma_loai' WHERE mahh='$product_id'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Cập nhật sản phẩm thành công.";
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <style>
    /* Style cho thanh header */
    header {
        background-color: #333;
        color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
    }

    /* Style cho các item trong header */
    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    nav ul li {
        margin-right: 20px;
    }

    nav ul li:last-child {
        margin-right: 0;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
    }

    nav ul li a:hover {
        text-decoration: underline;
    }

    h1 {
        margin-left: 20px;
        color: #333;
    }

    form {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    form input[type="text"],
    form select {
        width: calc(100% - 22px);
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    form textarea {
        width: calc(100% - 22px);
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    form button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    form button[type="submit"]:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">Sản Phẩm</a></li>
                <?php
                // Kiểm tra xem người dùng đã đăng nhập và có quyền admin hay không
                if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin') {
                    echo '<li><a href="admin.php">Quản Lý</a></li>';
                }
                ?>
                <li><a href="cart.php">Giỏ Hàng</a></li>
            </ul>
        </nav>
        <div>
            <?php
            // Kiểm tra xem người dùng đã đăng nhập hay chưa
            if (isset($_COOKIE['user_role'])) {
                $user_role = $_COOKIE['user_role'];
                echo $user_role;
            } else {
                echo "Default";
            }
            ?>
            <a href="login.php">Thoát</a>
        </div>
    </header>


    <h1>Chỉnh sửa sản phẩm</h1>
    <form action="edit_product.php?id=<?php echo $product_id; ?>" method="post">
        <label for="tenhh">Tên Hàng Hóa:</label><br>
        <input type="text" id="tenhh" name="tenhh" value="<?php echo $row['tenhh']; ?>"><br><br>

        <label for="gia">Giá:</label><br>
        <input type="text" id="gia" name="gia" value="<?php echo $row['gia']; ?>"><br><br>

        <label for="soluong">Số Lượng:</label><br>
        <input type="text" id="soluong" name="soluong" value="<?php echo $row['soluong']; ?>"><br><br>

        <label for="trangthai">Trạng Thái:</label><br>
        <select id="trangthai" name="trangthai">
            <option value="1" <?php if ($row['trangthai'] == 1)
                echo "selected"; ?>>Active</option>
            <option value="0" <?php if ($row['trangthai'] == 0)
                echo "selected"; ?>>Inactive</option>
        </select><br><br>

        <label for="mota">Mô Tả:</label><br>
        <textarea id="mota" name="mota" rows="4" cols="50"><?php echo $row['mota']; ?></textarea><br><br>

        <label for="ma_loai">Mã Loại:</label><br>
        <select id="ma_loai" name="ma_loai">
            <?php
            if ($result_loaihang->num_rows > 0) {
                while ($row_loaihang = $result_loaihang->fetch_assoc()) {
                    echo "<option value='" . $row_loaihang["maloai"] . "'";
                    if ($row_loaihang['maloai'] == $row['ma_loai'])
                        echo " selected";
                    echo ">" . $row_loaihang["tenloai"] . "</option>";
                }
            } else {
                echo "<option value=''>Không có loại hàng</option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Cập nhật</button>
    </form>
</body>

</html>

<?php
$conn->close();
?>