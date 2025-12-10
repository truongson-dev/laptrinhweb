<?php
session_start();

// Lưu thông tin trước khi xóa
$username = $_SESSION['username'] ?? 'Không xác định';
$had_remember = isset($_COOKIE['remembered_user']);


?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng xuất thành công</title>
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
        
        .logout-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: zoomIn 0.8s ease-out;
        }
        
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .logout-icon {
            font-size: 5rem;
            color: #667eea;
            margin-bottom: 25px;
            animation: spinOut 1s ease-out;
        }
        
        @keyframes spinOut {
            0% {
                transform: rotate(0deg) scale(1);
            }
            50% {
                transform: rotate(180deg) scale(1.2);
            }
            100% {
                transform: rotate(360deg) scale(1);
            }
        }
        
        h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 2.5rem;
        }
        
        .success-text {
            color: #4CAF50;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .message {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .info-card {
            background: #f8f9ff;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
            border-left: 5px solid #667eea;
        }
        
        .info-card h3 {
            color: #555;
            margin-bottom: 20px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            color: #777;
            font-weight: 500;
        }
        
        .info-value {
            color: #333;
            font-weight: 600;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .status-success {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-info {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .loading-bar {
            width: 100%;
            height: 8px;
            background: #f0f0f0;
            border-radius: 4px;
            margin: 30px 0;
            overflow: hidden;
        }
        
        .loading-progress {
            width: 0%;
            height: 100%;
            background: linear-gradient(to right, #667eea, #764ba2);
            border-radius: 4px;
            animation: loading 3s ease-in-out forwards;
        }
        
        @keyframes loading {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        
        .redirect-message {
            background: #f0f3ff;
            padding: 15px;
            border-radius: 10px;
            margin: 25px 0;
            color: #555;
            font-size: 0.95rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 15px 35px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
        }
        
        .btn-secondary {
            background: #f0f4ff;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 3000);
    </script>
</head>
<body>
    <div class="logout-container">
        <div class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        
        <h1>Đăng xuất</h1>
        <div class="success-text">
            <i class="fas fa-check-circle"></i>
            <span>Thành công!</span>
        </div>
        
        <p class="message">
            Bạn đã đăng xuất khỏi hệ thống an toàn.<br>
            Tất cả thông tin phiên làm việc đã được xóa.
        </p>
        
        <div class="info-card">
            <h3><i class="fas fa-clipboard-list"></i> Thông tin đăng xuất</h3>
            
            <div class="info-row">
                <span class="info-label">Username:</span>
                <span class="info-value"><?php echo htmlspecialchars($username); ?></span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Remember Me:</span>
                <span class="status-badge <?php echo $had_remember ? 'status-success' : 'status-info'; ?>">
                    <?php echo $had_remember ? 'Đã lưu cookie' : 'Không có cookie'; ?>
                </span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Session:</span>
                <span class="status-badge status-info">Đã được lưu</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Thời gian:</span>
                <span class="info-value"><?php echo date('H:i:s d/m/Y'); ?></span>
            </div>
        </div>
        
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
        
        <div class="redirect-message">
            <i class="fas fa-sync-alt"></i>
            <span>Đang chuyển hướng về trang đăng nhập sau 3 giây...</span>
        </div>
        
        <div class="action-buttons">
            <a href="login.php" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập lại ngay
            </a>
            
            <a href="admin.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại Admin
            </a>
        </div>
        
        <div class="footer">
            <p>© 2024 Hệ thống Quản trị | Phiên bản với Cookie Remember Me</p>
        </div>
    </div>
</body>
</html>