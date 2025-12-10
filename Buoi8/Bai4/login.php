<?php
session_start();

// Kiểm tra nếu đã login thì redirect
// if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
//     header('Location: admin.php');
//     exit;
// }

// Lấy username từ cookie remember nếu có
$remembered_username = $_COOKIE['remembered_user'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Remember Me</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 480px;
            animation: slideIn 0.6s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }
        
        .logo h1 {
            color: #333;
            font-size: 2.2rem;
            font-weight: 700;
        }
        
        .tagline {
            color: #666;
            font-size: 1rem;
            margin-top: 5px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.2rem;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 16px 16px 16px 50px;
            border: 2px solid #e1e5ee;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .remember-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 25px 0;
            padding: 15px;
            background: #f0f3ff;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        
        .remember-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #667eea;
        }
        
        .remember-group label {
            color: #555;
            font-weight: 600;
            cursor: pointer;
        }
        
        .remember-hint {
            font-size: 0.85rem;
            color: #888;
            margin-top: 5px;
            display: block;
        }
        
        .btn-login {
            width: 100%;
            padding: 18px;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .error-message {
            background: #ffeaea;
            color: #d32f2f;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #d32f2f;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .demo-info {
            background: linear-gradient(135deg, #e8f4fd 0%, #d4edda 100%);
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
            border: 2px dashed #667eea;
        }
        
        .demo-info h3 {
            color: #2e7d32;
            margin-bottom: 10px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .demo-info p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        
        .credentials {
            display: flex;
            gap: 30px;
            margin-top: 15px;
        }
        
        .credential-item {
            flex: 1;
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        
        .credential-item strong {
            color: #667eea;
            font-size: 1.2rem;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.9rem;
        }
        
        .cookie-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: <?php echo $remembered_username ? '#e8f5e9' : '#fff3cd'; ?>;
            color: <?php echo $remembered_username ? '#2e7d32' : '#856404'; ?>;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 15px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-user-lock"></i>
                </div>
                <h1>Login System</h1>
            </div>
            <p class="tagline">Với tính năng Remember Me</p>
        </div>
        
        <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span>Sai tên đăng nhập hoặc mật khẩu!</span>
        </div>
        <?php endif; ?>
        
        <?php if ($remembered_username): ?>
        <div class="cookie-status">
            <i class="fas fa-cookie-bite"></i>
            <span>Đã tìm thấy username: <strong><?php echo htmlspecialchars($remembered_username); ?></strong></span>
        </div>
        <?php endif; ?>
        
        <form action="check.php" method="post">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" 
                           value="<?php echo htmlspecialchars($remembered_username); ?>" 
                           required 
                           placeholder="Nhập username của bạn">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" 
                           required 
                           placeholder="Nhập mật khẩu">
                </div>
            </div>
            
            <div class="remember-group">
                <input type="checkbox" name="remember" id="remember" value="1"
                       <?php echo $remembered_username ? 'checked' : ''; ?>>
                <div>
                    <label for="remember">Remember Me</label>
                    <span class="remember-hint">Lưu username trong 7 ngày</span>
                </div>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                <span>Đăng nhập ngay</span>
            </button>
        </form>
        
        <div class="demo-info">
            <h3><i class="fas fa-info-circle"></i> Thông tin đăng nhập demo</h3>
            <div class="credentials">
                <div class="credential-item">
                    <div>Username</div>
                    <strong>Khue</strong>
                </div>
                <div class="credential-item">
                    <div>Password</div>
                    <strong>123</strong>
                </div>
            </div>
            <p style="margin-top: 15px; font-size: 0.9rem;">
                <i class="fas fa-lightbulb"></i> Thử tính năng Remember Me: Đăng nhập với checkbox checked, 
                sau đó refresh hoặc đăng nhập lại để thấy username tự động điền
            </p>
        </div>
        
        <div class="footer">
            <p>© 2024 Login System với Cookie Remember Me</p>
            <p>Phiên bản 2.0 - Lưu trữ thông tin an toàn</p>
        </div>
    </div>
</body>
</html>