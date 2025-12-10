<?php
session_start();

// Nếu đã đăng nhập, chuyển hướng đến admin
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    header('Location: admin.php');
    exit();
}

// Hiển thị thông báo lỗi nếu có
$error = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case '1':
            $error = 'Vui lòng nhập đầy đủ thông tin!';
            break;
        case '2':
            $error = 'Sai tên đăng nhập hoặc mật khẩu!';
            break;
        case '3':
            $error = 'Vui lòng đăng nhập để truy cập!';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: #1e3c72;
            font-size: 32px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .logo p {
            color: #666;
            font-size: 16px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-error {
            background: #ffeaea;
            border-left: 4px solid #ff4757;
            color: #ff4757;
        }
        
        .alert-info {
            background: #e8f4ff;
            border-left: 4px solid #2a5298;
            color: #2a5298;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9f9f9;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2a5298;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 43px;
            color: #666;
            font-size: 20px;
        }
        
        .show-password {
            position: absolute;
            right: 15px;
            top: 43px;
            cursor: pointer;
            color: #666;
        }
        
        .show-password:hover {
            color: #2a5298;
        }
        
        .login-btn {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 60, 114, 0.3);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .demo-credentials {
            background: #f8f9ff;
            border-radius: 10px;
            padding: 15px;
            margin-top: 25px;
            text-align: center;
            border: 1px dashed #2a5298;
        }
        
        .demo-credentials h4 {
            color: #2a5298;
            margin-bottom: 10px;
        }
        
        .demo-credentials p {
            color: #555;
            font-size: 14px;
            margin: 5px 0;
        }
        
        .demo-credentials code {
            background: #e8f4ff;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: monospace;
            color: #1e3c72;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .logo h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1><i class="fas fa-shield-alt"></i> ADMIN LOGIN</h1>
            <p>Vui lòng đăng nhập để tiếp tục</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
            <div class="alert alert-info">
                <i class="fas fa-check-circle"></i>
                Đăng xuất thành công!
            </div>
        <?php endif; ?>
        
        <form action="check.php" method="POST" id="loginForm">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Tên đăng nhập</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                </div>
                <input type="text" 
                       id="username" 
                       name="username" 
                       placeholder="Nhập username" 
                       autocomplete="username"
                       value="<?php echo isset($_GET['user']) ? htmlspecialchars($_GET['user']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Mật khẩu</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Nhập mật khẩu"
                       autocomplete="current-password">
                <span class="show-password" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập
            </button>
        </form>
        
        <div class="demo-credentials">
            <h4><i class="fas fa-info-circle"></i> Thông tin demo</h4>
            <p>Tên đăng nhập: <code>admin</code></p>
            <p>Mật khẩu: <code>123</code></p>
        </div>
        
        <div class="footer">
            <p>© 2024 Hệ thống quản trị | Phiên bản 1.0</p>
        </div>
    </div>
    
    <script>
        // Hiển thị/ẩn mật khẩu
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.show-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'fas fa-eye';
            }
        }
        
        // Thêm hiệu ứng khi nhấn Enter
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && document.activeElement.tagName !== 'BUTTON') {
                document.getElementById('loginForm').submit();
            }
        });
        
        // Tự động focus vào input username
        document.getElementById('username').focus();
    </script>
</body>
</html>