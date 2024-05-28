<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    /* Style cho form */
    form {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    /* Style cho các nhãn */
    form label {
        display: block;
        margin-bottom: 5px;
    }

    /* Style cho các input và textarea */
    form input[type="text"],
    form input[type="file"],
    form select,
    form textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Style cho nút gửi */
    form button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Style cho nút gửi khi di chuột vào */
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

    <h1>Thêm sản phẩm</h1>
    <form action="add_product_process.php" method="post" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br>
        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" required><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select><br>
        <label for="ma_loai">Category:</label>
        <select id="ma_loai" name="ma_loai">
            <?php
            // Kết nối đến cơ sở dữ liệu
            $servername = "localhost";
            $username = "root";
            $password = "123456";
            $dbname = "nguyenvantu";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Truy vấn dữ liệu từ bảng loaihang
            $sql = "SELECT * FROM loaihang";
            $result = $conn->query($sql);

            // Kiểm tra số lượng hàng trả về
            if ($result->num_rows > 0) {
                // In dữ liệu từ hàng truy vấn
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["maloai"] . "'>" . $row["tenloai"] . "</option>";
                }
            } else {
                echo "<option value=''>No categories available</option>";
            }
            $conn->close();
            ?>
        </select><br>
        <button type="submit">Add Product</button>
    </form>
</body>

</html>