 <h2>Form Đăng nhập</h2>
    
    <?php
    // Xử lý khi form được gửi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            echo "<p style='color:red'>Vui lòng nhập đầy đủ thông tin</p>";
        } else {
            echo "<p style='color:green'>Đăng nhập thành công</p>";
        }
    }
    ?>
    
    <form method="POST" action="">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        
        <input type="submit" value="Đăng nhập">