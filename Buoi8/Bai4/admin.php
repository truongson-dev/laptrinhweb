<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .welcome-header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .welcome-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
        }
        
        .welcome-text h2 {
            color: #333;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        .welcome-text p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 15px;
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 4px solid #667eea;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .card-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .card h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .btn-card {
            background: #f0f4ff;
            color: #667eea;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-card:hover {
            background: #667eea;
            color: white;
        }
        
        .session-info {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 15px;
            margin-top: 40px;
            border-left: 5px solid #764ba2;
        }
        
        .session-info h3 {
            color: #555;
            margin-bottom: 20px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        
        .info-label {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #333;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .remember-status {
            margin-top: 30px;
            padding: 20px;
            border-radius: 12px;
            background: <?php echo isset($_COOKIE['remembered_user']) ? '#e8f5e9' : '#fff3cd'; ?>;
            border-left: 5px solid <?php echo isset($_COOKIE['remembered_user']) ? '#4CAF50' : '#FFC107'; ?>;
        }
        
        .remember-status h4 {
            color: <?php echo isset($_COOKIE['remembered_user']) ? '#2e7d32' : '#856404'; ?>;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cookie-details {
            background: rgba(255, 255, 255, 0.7);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .debug-info {
            margin-top: 40px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 12px;
            font-family: monospace;
            font-size: 0.9rem;
            overflow-x: auto;
        }
        
        .debug-info h4 {
            color: #ecf0f1;
            margin-bottom: 15px;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .debug-section {
            margin-bottom: 20px;
        }
        
        .footer {
            text-align: center;
            padding: 30px;
            color: #777;
            font-size: 0.9rem;
            margin-top: 50px;
            border-top: 1px solid #e0e0e0;
        }
        
        .quick-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .quick-btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .quick-btn-primary {
            background: #667eea;
            color: white;
        }
        
        .quick-btn-secondary {
            background: #f0f4ff;
            color: #667eea;
            border: 1px solid #667eea;
        }
        
        .quick-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>Admin Dashboard</h1>
        </div>
        
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <strong style="font-size: 1.1rem;"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                <div style="font-size: 0.85rem; opacity: 0.9;">Administrator</div>
            </div>
            <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    </nav>
    
    <div class="container">
        <div class="welcome-card">
            <div class="welcome-header">
                <div class="welcome-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <div class="welcome-text">
                    <h2>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>! 👋</h2>
                    <p>Bạn đã đăng nhập thành công vào hệ thống quản trị</p>
                    <span class="user-badge">
                        <i class="fas fa-crown"></i> Quyền truy cập: Administrator
                    </span>
                </div>
            </div>
            
            <div class="quick-actions">
                <a href="login.php" class="quick-btn quick-btn-secondary">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập lại
                </a>
                <a href="logout.php" class="quick-btn quick-btn-primary">
                    <i class="fas fa-power-off"></i> Đăng xuất ngay
                </a>
                <a href="#" class="quick-btn quick-btn-secondary">
                    <i class="fas fa-user-cog"></i> Cài đặt tài khoản
                </a>
            </div>
        </div>
        
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Quản lý Người dùng</h3>
                <p>Quản lý tất cả người dùng trong hệ thống, phân quyền và theo dõi hoạt động.</p>
                <button class="btn-card">
                    <i class="fas fa-arrow-right"></i> Truy cập
                </button>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Thống kê & Báo cáo</h3>
                <p>Xem báo cáo thống kê, biểu đồ và phân tích dữ liệu hệ thống.</p>
                <button class="btn-card">
                    <i class="fas fa-arrow-right"></i> Xem báo cáo
                </button>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3>Cài đặt Hệ thống</h3>
                <p>Cấu hình các thông số hệ thống, cài đặt và tùy chỉnh tính năng.</p>
                <button class="btn-card">
                    <i class="fas fa-arrow-right"></i> Cấu hình
                </button>
            </div>
        </div>
        
        <div class="session-info">
            <h3><i class="fas fa-info-circle"></i> Thông tin Phiên làm việc</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Session ID</div>
                    <div class="info-value"><?php echo session_id(); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Thời gian đăng nhập</div>
                    <div class="info-value"><?php echo date('H:i:s d/m/Y'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Trạng thái</div>
                    <div class="info-value" style="color: #4CAF50;">● Đang hoạt động</div>
                </div>
            </div>
            
            <div class="remember-status">
                <h4>
                    <i class="fas fa-cookie-bite"></i>
                    Trạng thái Remember Me
                </h4>
                <?php if (isset($_COOKIE['remembered_user'])): ?>
                    <p>✅ <strong>Remember Me đang hoạt động!</strong></p>
                    <div class="cookie-details">
                        <p>Username được lưu: <strong><?php echo htmlspecialchars($_COOKIE['remembered_user']); ?></strong></p>
                        <p>Cookie sẽ hết hạn sau 7 ngày kể từ khi đăng nhập</p>
                        <p style="margin-top: 10px; font-size: 0.9rem;">
                            <i class="fas fa-lightbulb"></i> Lần đăng nhập tiếp theo, username sẽ tự động điền vào form
                        </p>
                    </div>
                <?php else: ?>
                    <p>⚠️ <strong>Remember Me chưa được kích hoạt</strong></p>
                    <div class="cookie-details">
                        <p>Tính năng lưu username chưa được bật</p>
                        <p>Lần đăng nhập sau bạn sẽ cần nhập lại username</p>
                        <p style="margin-top: 10px; font-size: 0.9rem;">
                            <i class="fas fa-lightbulb"></i> Để kích hoạt, hãy check "Remember Me" khi đăng nhập
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="debug-info">
            <h4><i class="fas fa-bug"></i> Debug Information</h4>
            
            <div class="debug-section">
                <strong>SESSION Data:</strong>
                <pre><?php print_r($_SESSION); ?></pre>
            </div>
            
            <div class="debug-section">
                <strong>COOKIE Data:</strong>
                <pre><?php print_r($_COOKIE); ?></pre>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>© 2024 Hệ thống Quản trị với Session & Cookie | Phiên bản 2.0</p>
        <p>Được phát triển với PHP Session và Cookie Remember Me</p>
    </div>
</body>
</html>