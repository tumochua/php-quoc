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

        /* Style cho container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Style cho hình ảnh */
        .product-image {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        /* Style cho tiêu đề */
        h1 {
            margin-top: 0;
        }

        /* Style cho giá */
        .price {
            font-weight: bold;
            color: #ff5733;
        }

        /* Style cho mô tả */
        .description {
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Style cho nút */
        .btn {
            display: inline-block;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #555;
        }

        /* Style cho modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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

        // Kiểm tra xem có tham số id được truyền từ URL không
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $product_id = $_GET['id'];

            // Truy vấn dữ liệu sản phẩm từ bảng hanghoa
            $sql = "SELECT * FROM hanghoa WHERE mahh = $product_id";
            $result = $conn->query($sql);

            // Kiểm tra số lượng hàng trả về
            if ($result->num_rows > 0) {
                // Hiển thị thông tin chi tiết của sản phẩm
                while ($row = $result->fetch_assoc()) {
                    echo "<h1>" . $row["tenhh"] . "</h1>";
                    echo "<img class='product-image' src='uploads/" . $row["hinh"] . "' alt='" . $row["tenhh"] . "'>";
                    echo "<p class='price'>$" . $row["gia"] . "</p>";
                    echo "<p class='description'>" . $row["mota"] . "</p>";
                    echo "<a class='btn' href='#' onclick='openModal(" . $row["mahh"] . ")'>Thêm vào giỏ hàng</a>";
                }
            } else {
                echo "Không tìm thấy sản phẩm.";
            }
        } else {
            echo "Không có ID sản phẩm được cung cấp.";
        }

        $conn->close();
        ?>
    </div>

    <!-- Modal -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Thêm vào giỏ hàng</h2>
            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="hanghoa_id" id="product_id">
                <label for="soluong">Số lượng:</label>
                <input type="number" name="soluong" id="soluong" value="1" min="1" required>
                <button type="submit" class="btn">Xác nhận</button>
            </form>
        </div>
    </div>

    <script>
        // Mở modal
        function openModal(productId) {
            document.getElementById('product_id').value = productId;
            document.getElementById('cartModal').style.display = "block";
        }

        // Đóng modal
        function closeModal() {
            document.getElementById('cartModal').style.display = "none";
        }

        // Đóng modal khi click ngoài modal
        window.onclick = function (event) {
            if (event.target == document.getElementById('cartModal')) {
                document.getElementById('cartModal').style.display = "none";
            }
        }
    </script>
</body>

</html>