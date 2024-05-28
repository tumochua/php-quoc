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
$dbname = "nguyenvantu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy user_id từ cookie
$user_id = $_COOKIE['user_id'];

// Truy vấn giỏ hàng của người dùng
$sql = "SELECT hanghoa.tenhh, hanghoa.gia, giohang.soluong, giohang.hanghoa_id 
        FROM giohang 
        JOIN hanghoa ON giohang.hanghoa_id = hanghoa.mahh 
        WHERE giohang.user_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
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

    /* Style cho container */
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
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


    <div class="container">
        <h1>Giỏ hàng của bạn</h1>
        <table>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["tenhh"] . "</td>";
                    echo "<td>" . $row["gia"] . "</td>";
                    echo "<td>" . $row["soluong"] . "</td>";
                    echo "<td><a href='remove_from_cart.php?id=" . $row["hanghoa_id"] . "'>Xóa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Giỏ hàng trống</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>

<?php
$conn->close();
?>