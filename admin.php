<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
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

        /* Style cho bảng */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Style cho tiêu đề cột */
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        /* Style cho dòng chẵn */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style cho ô dữ liệu */
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        /* Style cho ô dữ liệu ở cột hình ảnh */
        td.image {
            max-width: 100px;
        }

        /* Style cho hình ảnh */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Style cho hình ảnh trong bảng */
        td.image img {
            width: 50%;
            margin: 0 auto;
            display: block;
            /* Để căn giữa hình ảnh */
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

    <h1>Quản lý sản phẩm</h1>
    <div>
        <button>
            <a href="add_product.php">Thêm Sản Phẩm</a>
        </button>
        <?php
        // Kết nối đến cơ sở dữ liệu
        $servername = "localhost";
        $username = "root";
        // $password = "123456";
        $password = "";

        $dbname = "nguyenvantu";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Truy vấn dữ liệu từ bảng hanghoa
        $sql = "SELECT hanghoa.*, loaihang.tenloai 
                FROM hanghoa 
                JOIN loaihang ON hanghoa.ma_loai = loaihang.maloai";
        $result = $conn->query($sql);

        // Kiểm tra số lượng hàng trả về
        if ($result->num_rows > 0) {
            // In tiêu đề bảng
            echo "<table border='1'>
            <tr>
                <th>Mã Hàng Hóa</th>
                <th>Tên Hàng Hóa</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Hình Ảnh</th>
                <th>Ngày Tạo</th>
                <th>Trạng Thái</th>
                <th>Ngày Sửa</th>
                <th>Tên Loại</th>
                <th>Chỉnh Sửa</th>
                <th>Xóa</th>
            </tr>";

            // In dữ liệu từ hàng truy vấn
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . $row["mahh"] . "</td>
                <td>" . $row["tenhh"] . "</td>
                <td>" . $row["gia"] . "</td>
                <td>" . $row["soluong"] . "</td>
                <td class='image'><img src='uploads/" . $row["hinh"] . "' alt='" . $row["tenhh"] . "'></td>

                <td>" . $row["ngaytao"] . "</td>
                <td>" . $row["trangthai"] . "</td>
                <td>" . $row["ngaysua"] . "</td>
                <td>" . $row["tenloai"] . "</td>
                <td><a href='edit_product.php?id=" . $row["mahh"] . "'>Sửa</a></td>
                <td><a href='delete_product.php?id=" . $row["mahh"] . "'>Xóa</a></td>
            </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
</body>

</html>