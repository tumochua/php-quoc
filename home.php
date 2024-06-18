<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
    /* Style cho thanh header */
    header {
        background-color: #333;
        color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Style cho các item trong header */
    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
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
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    nav ul li a:hover {
        background-color: #575757;
    }

    /* Style cho form tìm kiếm */
    .search-form {
        display: flex;
        align-items: center;
    }

    .search-form input[type="text"] {
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    .search-form button {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        background-color: #ff5733;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .search-form button:hover {
        background-color: #e74c3c;
    }

    /* Style cho thông tin người dùng và nút logout */
    .user-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .user-info span {
        font-weight: bold;
    }

    .logout-button {
        color: white;
        text-decoration: none;
        background-color: #ff5733;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .logout-button:hover {
        background-color: #e74c3c;
    }

    /* Style cho container chứa các card */
    .container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
    }

    /* Style cho card */
    .card {
        width: 250px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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

    /* Style cho phân trang */
    .pagination {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .pagination a {
        color: #333;
        padding: 10px 15px;
        margin: 0 5px;
        text-decoration: none;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination a:hover {
        background-color: #f1f1f1;
    }

    .pagination a.active {
        background-color: #333;
        color: white;
        border: 1px solid #333;
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
        <form class="search-form" method="GET" action="">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Tìm kiếm</button>
        </form>
        <div class="user-info">
            <span>
                <?php
                // Kiểm tra xem người dùng đã đăng nhập hay chưa
                if (isset($_COOKIE['user_role'])) {
                    echo htmlspecialchars($_COOKIE['user_role']);
                } else {
                    echo "Default";
                }
                ?>
            </span>
            <a class="logout-button" href="login.php">Thoát</a>
        </div>
    </header>
    <?php
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "123456";
    $dbname = "dtt_examphp";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Lấy giá trị tìm kiếm từ form
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Thiết lập các biến phân trang
    $results_per_page = 10; // Số lượng sản phẩm mỗi trang
    $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $start_from = ($current_page - 1) * $results_per_page;

    // Truy vấn dữ liệu từ bảng sản phẩm
    $sql = "SELECT * FROM product";
    if ($search) {
        $sql .= " WHERE product_name LIKE '%" . $conn->real_escape_string($search) . "%'";
    }
    $sql .= " LIMIT $start_from, $results_per_page";
    $result = $conn->query($sql);

    // Kiểm tra số lượng hàng trả về
    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        // In dữ liệu từ hàng truy vấn dưới dạng các card
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>
                    <img src='uploads/" . htmlspecialchars($row["images"]) . "' alt='" . htmlspecialchars($row["product_name"]) . "'>
                    <div class='card-content'>
                        <h3>" . htmlspecialchars($row["product_name"]) . "</h3>
                        <p class='price'>$" . htmlspecialchars($row["price"]) . "</p>
                        <a href='detail_product.php?id=" . htmlspecialchars($row["product_id"]) . "'>Chi tiết</a>
                    </div>
                </div>";
        }
        // Đóng container sau khi kết thúc vòng lặp
        echo "</div>";

        // Tạo phân trang
        $sql = "SELECT COUNT(product_id) AS total FROM product";
        if ($search) {
            $sql .= " WHERE product_name LIKE '%" . $conn->real_escape_string($search) . "%'";
        }
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_pages = ceil($row["total"] / $results_per_page);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                echo "<a class='active' href='?search=" . htmlspecialchars($search) . "&page=" . $i . "'>" . $i . "</a>";
            } else {
                echo "<a href='?search=" . htmlspecialchars($search) . "&page=" . $i . "'>" . $i . "</a>";
            }
        }
        echo "</div>";
    } else {
        echo "Không tìm thấy kết quả nào.";
    }
    $conn->close();
    ?>
</body>

</html>