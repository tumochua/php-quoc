<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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

/* Style cho container chứa các card */
.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
}

/* Style cho card */
.card {
    width: 250px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Style cho hình ảnh trong card */
.card img {
    width: 100%;
    height: 200px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    object-fit: cover;
}

/* Style cho nội dung của card */
.card-content {
    padding: 20px;
}

/* Style cho tiêu đề */
.card-content h3 {
    margin-top: 0;
}

/* Style cho giá */
.card-content .price {
    font-weight: bold;
    color: #ff5733;
}

/* Style cho mô tả */
.card-content p {
    margin: 10px 0;
    line-height: 1.5;
}
</style>

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
    $sql = "SELECT * FROM hanghoa";
    $result = $conn->query($sql);

    // Kiểm tra số lượng hàng trả về
    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        // In dữ liệu từ hàng truy vấn dưới dạng các card
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>
                    <img src='uploads/" . $row["hinh"] . "' alt='" . $row["tenhh"] . "'>
                    <div class='card-content'>
                        <h3>" . $row["tenhh"] . "</h3>
                        <p class='price'>$" . $row["gia"] . "</p>
                        <a href='detai_product.php?id=" . $row["mahh"] . "'>Chi tiết</a>
                    </div>
                </div>";
        }
        // Đóng container sau khi kết thúc vòng lặp
        echo "</div>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>

</body>

</html>