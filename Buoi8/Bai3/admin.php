<?php
/**
 * Trang quản trị - Chỉ truy cập được khi đã đăng nhập
 */
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    // Chưa đăng nhập, chuyển hướng về trang đăng nhập
    header('Location: login.php?error=3');
    exit();
}

// Kiểm tra session hijacking (cơ bản)
if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    // Session có thể bị đánh cắp, hủy session
    session_destroy();
    header('Location: login.php?error=3');
    exit();
}

// Tính thời gian đăng nhập
$login_time = $_SESSION['login_time'] ?? time();
$current_time = time();
$session_duration = $current_time - $login_time;
$formatted_duration = gmdate("H:i:s", $session_duration);

// Thông tin người dùng
$username = htmlspecialchars($_SESSION['username'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .navbar {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .navbar-brand h1 {
            font-size: 24px;
            font-weight: 600;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2a5298;
            font-size: 20px;
            font-weight: bold;
        }
        
        .user-details {
            text-align: right;
        }
        
        .username {
            font-weight: 600;
            font-size: 16px;
        }
        
        .session-time {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-section {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #2a5298;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .welcome-title {
            color: #1e3c72;
            font-size: 32px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .welcome-message {
            color: #555;
            font-size: 18px;
            line-height: 1.8;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            border-top: 5px solid;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .card-1 { border-top-color: #2a5298; }
        .card-2 { border-top-color: #4ecdc4; }
        .card-3 { border-top-color: #ff6b6b; }
        .card-4 { border-top-color: #ffa726; }
        
        .card-icon {
            font-size: 40px;
            margin-bottom: 20px;
        }
        
        .card-1 .card-icon { color: #2a5298; }
        .card-2 .card-icon { color: #4ecdc4; }
        .card-3 .card-icon { color: #ff6b6b; }
        .card-4 .card-icon { color: #ffa726; }
        
        .card-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        
        .card-content {
            color: #666;
            margin-bottom: 20px;
        }
        
        .card-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #f0f4ff;
            color: #2a5298;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .card-btn:hover {
            background: #2a5298;
            color: white;
        }
        
        .session-info {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .session-info h3 {
            color: #1e3c72;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .session-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .session-item {
            padding: 15px;
            background: #f8f9ff;
            border-radius: 10px;
        }
        
        .session-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .session-value {
            color: #333;
            font-weight: 500;
        }
        
        .session-value code {
            background: #e8f4ff;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: monospace;
        }
        
        .security-warning {
            background: #fff5f5;
            border-left: 4px solid #ff6b6b;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        footer {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
            margin-top: 50px;
        }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }
            
            .user-info {
                width: 100%;
                justify-content: space-between;
            }
            
            .container {
                margin: 20px auto;
            }
            
            .welcome-section {
                padding: 25px;
            }
            
            .welcome-title {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fas fa-shield-alt fa-2x"></i>
            <h1>ADMIN CONTROL PANEL</h1>
        </div>
        
        <div class="user-info">
            <div class="user-details">
                <div class="username"><?php echo $username; ?></div>
                <div class="session-time">
                    <i class="far fa-clock"></i> <?php echo $formatted_duration; ?>
                </div>
            </div>
            
            <div class="user-avatar">
                <?php echo strtoupper(substr($username, 0, 1)); ?>
            </div>
            
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h2 class="welcome-title">
                <i class="fas fa-hand-wave"></i> Chào mừng <?php echo $username; ?>!
            </h2>
            <p class="welcome-message">
                Bạn đã đăng nhập thành công vào hệ thống quản trị. Tại đây bạn có thể quản lý tất cả các tính năng của website, 
                theo dõi thống kê, và thực hiện các thao tác quản trị cần thiết. Hãy sử dụng các công cụ bên dưới để bắt đầu.
            </p>
        </div>
        
        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <div class="dashboard-card card-1">
                <div class="card-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="card-title">Thống kê hệ thống</h3>
                <p class="card-content">
                    Xem báo cáo chi tiết về lượt truy cập, người dùng và hoạt động hệ thống.
                </p>
                <a href="#" class="card-btn">Xem báo cáo</a>
            </div>
            
            <div class="dashboard-card card-2">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="card-title">Quản lý người dùng</h3>
                <p class="card-content">
                    Thêm, xóa, sửa thông tin người dùng và phân quyền truy cập.
                </p>
                <a href="#" class="card-btn">Quản lý người dùng</a>
            </div>
            
            <div class="dashboard-card card-3">
                <div class="card-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="card-title">Cài đặt hệ thống</h3>
                <p class="card-content">
                    Tùy chỉnh cấu hình website, giao diện và các thiết lập quan trọng.
                </p>
                <a href="#" class="card-btn">Cấu hình</a>
            </div>
            
            <div class="dashboard-card card-4">
                <div class="card-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3 class="card-title">Thông báo & Cảnh báo</h3>
                <p class="card-content">
                    Xem các thông báo quan trọng và cảnh báo bảo mật từ hệ thống.
                </p>
                <a href="#" class="card-btn">Xem thông báo</a>
            </div>
        </div>
        
        <!-- Session Information -->
        <div class="session-info">
            <h3><i class="fas fa-info-circle"></i> Thông tin phiên đăng nhập</h3>
            <div class="session-details">
                <div class="session-item">
                    <div class="session-label">Tên đăng nhập</div>
                    <div class="session-value"><?php echo $username; ?></div>
                </div>
                
                <div class="session-item">
                    <div class="session-label">Thời gian đăng nhập</div>
                    <div class="session-value"><?php echo date('H:i:s d/m/Y', $login_time); ?></div>
                </div>
                
                <div class="session-item">
                    <div class="session-label">Thời gian phiên</div>
                    <div class="session-value"><?php echo $formatted_duration; ?></div>
                </div>
                
                <div class="session-item">
                    <div class="session-label">Session ID</div>
                    <div class="session-value"><code><?php echo session_id(); ?></code></div>
                </div>
                
                <div class="session-item">
                    <div class="session-label">IP Address</div>
                    <div class="session-value"><?php echo $_SESSION['ip_address']; ?></div>
                </div>
                
                <div class="session-item">
                    <div class="session-label">Trình duyệt</div>
                    <div class="session-value">
                        <?php 
                        $user_agent = $_SESSION['user_agent'];
                        if (strpos($user_agent, 'Chrome') !== false) echo 'Chrome';
                        elseif (strpos($user_agent, 'Firefox') !== false) echo 'Firefox';
                        elseif (strpos($user_agent, 'Safari') !== false) echo 'Safari';
                        elseif (strpos($user_agent, 'Edge') !== false) echo 'Edge';
                        else echo 'Không xác định';
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="security-warning">
                <i class="fas fa-exclamation-triangle" style="color: #ff6b6b;"></i>
                <div>
                    <strong>Lưu ý bảo mật:</strong> Đây là phiên đăng nhập của bạn. 
                    Hãy đảm bảo đăng xuất khi không sử dụng và không chia sẻ thông tin đăng nhập.
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>© 2024 Hệ thống quản trị. Phiên bản 1.0.0</p>
        <p>Thời gian máy chủ: <?php echo date('H:i:s d/m/Y'); ?></p>
    </footer>
    
    <script>
        // Cập nhật thời gian phiên mỗi giây
        function updateSessionTime() {
            const sessionTimeElement = document.querySelector('.session-time');
            if (sessionTimeElement) {
                let timeText = sessionTimeElement.textContent;
                let timeParts = timeText.split(':');
                let hours = parseInt(timeParts[0]) || 0;
                let minutes = parseInt(timeParts[1]) || 0;
                let seconds = parseInt(timeParts[2]) || 0;
                
                seconds++;
                if (seconds >= 60) {
                    seconds = 0;
                    minutes++;
                    if (minutes >= 60) {
                        minutes = 0;
                        hours++;
                    }
                }
                
                // Format lại thời gian
                const formattedTime = 
                    hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0') + ':' +
                    seconds.toString().padStart(2, '0');
                
                sessionTimeElement.innerHTML = `<i class="far fa-clock"></i> ${formattedTime}`;
            }
        }
        
        // Cập nhật mỗi giây
        setInterval(updateSessionTime, 1000);
        
        // Auto logout sau 30 phút không hoạt động (tùy chọn)
        let idleTime = 0;
        setInterval(function() {
            idleTime++;
            if (idleTime > 1800) { // 30 phút = 1800 giây
                window.location.href = 'logout.php?timeout=1';
            }
        }, 1000);
        
        // Reset idle time khi có hoạt động
        ['click', 'mousemove', 'keypress'].forEach(event => {
            document.addEventListener(event, () => {
                idleTime = 0;
            });
        });
        
        // Cảnh báo trước khi đăng xuất
        document.querySelector('.logout-btn').addEventListener('click', function(e) {
            if (!confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html> 