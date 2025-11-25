  <?php
    // Khởi tạo biến
    $email = $password = "";
    $emailErr = $passwordErr = "";
    $valid = false;

    // Xử lý khi form được gửi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu và xử lý khoảng trắng
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        // Kiểm tra email
        if (empty($email)) {
            $emailErr = "Email không được để trống";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Email không đúng định dạng";
        }
        
        // Kiểm tra mật khẩu
        if (empty($password)) {
            $passwordErr = "Mật khẩu không được để trống";
        } elseif (strlen($password) < 6) {
            $passwordErr = "Mật khẩu phải có ít nhất 6 ký tự";
        }
        
        // Nếu không có lỗi
        if (empty($emailErr) && empty($passwordErr)) {
            $valid = true;
        }
    }
    ?>

    <?php if ($valid): ?>
        <div class="success">
            <h3>Thông tin hợp lệ!</h3>
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
        </div>
    <?php else: ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <?php if (!empty($emailErr)): ?>
                    <span class="error"><?php echo $emailErr; ?></span>
                <?php endif; ?>
            </div>
            <br>
            <div>
                <label for="password">Mật khẩu:</label><br>
                <input type="password" id="password" name="password">
                <?php if (!empty($passwordErr)): ?>
                    <span class="error"><?php echo $passwordErr; ?></span>
                <?php endif; ?>
            </div>
            <br>
            <input type="submit" value="Kiểm tra">
        </form>
    <?php endif; 
?>
</body>
</html>