<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 20px;
    }

    .login-container label {
        display: block;
        margin-bottom: 5px;
        text-align: left;
    }

    .login-container input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .login-container button {
        width: 100%;
        padding: 10px;
        background-color: #007BFF;
        border: none;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .login-container button:hover {
        background-color: #0056b3;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <?php

        // Thông tin kết nối
        $servername = "localhost";
        $username = "root";
        $password = "123456";
        $database = "nguyenvantu";

        // Tạo kết nối
        $conn = new mysqli($servername, $username, $password, $database);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Thực hiện kiểm tra đăng nhập (giả sử sử dụng thông tin tĩnh để minh họa)
            $sql = "SELECT * FROM taikhoan WHERE email='$email' AND matkhau='$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Đăng nhập thành công
                while ($row = $result->fetch_assoc()) {
                    // Lấy vai trò của người dùng từ cơ sở dữ liệu
                    $role = $row['rolename'];
                    $userid = $row['matk'];
                    // Lưu vai trò vào cookies
                    setcookie("user_role", $role);
                    setcookie("user_id", $userid);
                    // Chuyển hướng đến trang home
                    header("Location: home.php");
                    exit(); // Đảm bảo không có mã PHP nào được thực thi sau header
                }
                // Thực hiện các hành động sau khi đăng nhập thành công
            } else {
                // Đăng nhập không thành công
                echo "<p class='error'>Thông tin tài khoản hoặc mật khẩu ko đúng</p>";
            }

        }
        ?>
    </div>
</body>

</html>