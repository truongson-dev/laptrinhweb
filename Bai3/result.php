<!DOCTYPE html>
<html>
<head>
    <title>Kết quả kiểm tra</title>
</head>
<body>
    <h1>Kết quả kiểm tra</h1>
    
    <?php
    // Kiểm tra nếu form được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ form
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $errors = [];
        
        // Kiểm tra định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không đúng định dạng";
        }
        
        // Kiểm tra độ dài mật khẩu
        if (strlen($password) < 6) {
            $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
        }
        
        // Hiển thị kết quả
        if (empty($errors)) {
            echo "<p><strong>Thông tin hợp lệ.</strong></p>";
            echo "<p>Email: " . htmlspecialchars($email) . "</p>";
        } else {
            echo "<p><strong>Thông tin không hợp lệ:</strong></p>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        }
        
        echo '<br><a href="form.php">Quay lại form</a>';
        
    } else {
        echo "<p>Lỗi: Không có dữ liệu được gửi đi</p>";
        echo '<a href="form.php">Quay lại form</a>';
    }
    ?>
</body>
</html>