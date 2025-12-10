<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = $_POST['remember'] ?? '';

// Giả lập delay xử lý 1.5 giây
sleep(1);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đang xử lý đăng nhập...</title>
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
        
        .processing-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: fadeIn 0.5s ease;
        }
        
        .processing-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 25px;
            animation: spin 1.5s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }
        
        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
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
            animation: loading 1.5s ease-in-out forwards;
        }
        
        @keyframes loading {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        
        .details-box {
            background: #f8f9ff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 25px;
            text-align: left;
        }
        
        .details-box h4 {
            color: #555;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .details-row:last-child {
            border-bottom: none;
        }
        
        .label {
            color: #777;
            font-weight: 500;
        }
        
        .value {
            color: #333;
            font-weight: 600;
        }
        
        .remember-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 10px;
            background: <?php echo $remember ? '#e8f5e9' : '#fff3cd'; ?>;
            color: <?php echo $remember ? '#2e7d32' : '#856404'; ?>;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php
    if ($username === 'Son' && $password === '123') {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
        
        if ($remember == '1') {
            setcookie('remembered_user', $username, time() + (7 * 24 * 60 * 60));
            $remember_text = 'Đã kích hoạt (7 ngày)';
        } else {
            setcookie('remembered_user', '', time() - 3600);
            $remember_text = 'Không kích hoạt';
        }
        
        echo '<script>
            setTimeout(function() {
                window.location.href = "admin.php";
            }, 1500);
        </script>';
    } else {
        echo '<script>
            setTimeout(function() {
                window.location.href = "login.php?error=1";
            }, 1500);
        </script>';
    }
    ?>
</head>
<body>
    <div class="processing-container">
        <div class="processing-icon">
            <i class="fas fa-cog"></i>
        </div>
        
        <h2>Đang xử lý đăng nhập...</h2>
        <p>Vui lòng chờ trong giây lát trong khi hệ thống xác thực thông tin của bạn.</p>
        
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
        
        <div class="details-box">
            <h4><i class="fas fa-info-circle"></i> Thông tin đăng nhập:</h4>
            <div class="details-row">
                <span class="label">Username:</span>
                <span class="value"><?php echo htmlspecialchars($username); ?></span>
            </div>
            <div class="details-row">
                <span class="label">Remember Me:</span>
                <span class="remember-status">
                    <?php 
                    if ($remember == '1') {
                        echo '<i class="fas fa-check-circle"></i> Đã bật';
                    } else {
                        echo '<i class="fas fa-times-circle"></i> Đã tắt';
                    }
                    ?>
                </span>
            </div>
        </div>
        
        <p style="margin-top: 20px; font-size: 0.9rem; color: #888;">
            <i class="fas fa-sync-alt"></i> Tự động chuyển hướng sau 1.5 giây...
        </p>
    </div>
</body>
</html>