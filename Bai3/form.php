<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập - Kiểm tra thông tin</title>
</head>
<body>
    <h1>Đăng nhập hệ thống</h1>
    
    <form method="POST" action="result.php">
        <div>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required>
        </div>
        
        <div>
            <label for="password">Mật khẩu:</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        
        <br>
        <button type="submit">Kiểm tra</button>
    </form>
    
    <h3>Yêu cầu:</h3>
    <ul>
        <li>Email phải đúng định dạng</li>
        <li>Mật khẩu ít nhất 6 ký tự</li>
    </ul>
</body>
</html>