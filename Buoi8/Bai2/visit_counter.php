<?php
/**
 * Cookie Visit Counter
 * Đếm số lần người dùng truy cập trang
 */

// Thiết lập múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Hàm tăng bộ đếm
function incrementVisitCounter() {
    $counter_name = 'visit_counter';
    $last_visit_name = 'last_visit';
    
    // Kiểm tra cookie đếm số lần truy cập
    if (isset($_COOKIE[$counter_name])) {
        // Đã từng truy cập - tăng lên 1
        $visit_count = (int)$_COOKIE[$counter_name] + 1;
    } else {
        // Lần đầu truy cập
        $visit_count = 1;
    }
    
    // Lấy thời gian hiện tại
    $current_time = date('Y-m-d H:i:s');
    
    // Thiết lập cookie (30 ngày)
    $expiry_time = time() + (30 * 24 * 60 * 60); // 30 ngày
    
    setcookie($counter_name, $visit_count, $expiry_time, '/');
    setcookie($last_visit_name, $current_time, $expiry_time, '/');
    
    // Cập nhật biến $_COOKIE để sử dụng ngay trong phiên hiện tại
    $_COOKIE[$counter_name] = $visit_count;
    $_COOKIE[$last_visit_name] = $current_time;
    
    return [
        'count' => $visit_count,
        'last_visit' => $current_time
    ];
}

// Gọi hàm để tăng bộ đếm
$visit_data = incrementVisitCounter();
$visit_count = $visit_data['count'];
$last_visit = $visit_data['last_visit'];

// Lấy thời gian đầu tiên truy cập (nếu có)
$first_visit = isset($_COOKIE['first_visit']) 
    ? $_COOKIE['first_visit'] 
    : $last_visit;

// Lưu thời gian đầu tiên nếu chưa có
if (!isset($_COOKIE['first_visit'])) {
    $first_visit_cookie_expiry = time() + (365 * 24 * 60 * 60); // 1 năm
    setcookie('first_visit', $first_visit, $first_visit_cookie_expiry, '/');
    $_COOKIE['first_visit'] = $first_visit;
}

// Tính số ngày từ lần đầu truy cập
$first_date = new DateTime($first_visit);
$current_date = new DateTime();
$days_since_first = $first_date->diff($current_date)->days;

// Tính tần suất truy cập trung bình
$avg_frequency = $days_since_first > 0 
    ? round($visit_count / $days_since_first, 2) 
    : 1;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Visit Counter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 800px;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .subtitle {
            color: #666;
            font-size: 18px;
            font-weight: 300;
        }
        
        .counter-display {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }
        
        .counter-number {
            font-size: 120px;
            font-weight: 800;
            color: #667eea;
            text-shadow: 5px 5px 15px rgba(102, 126, 234, 0.3);
            line-height: 1;
            margin: 20px 0;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .counter-label {
            font-size: 24px;
            color: #555;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }
        
        .stat-card {
            background: #f8f9ff;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            border-top: 5px solid #667eea;
            transition: transform 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 40px;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .stat-title {
            font-size: 16px;
            color: #777;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }
        
        .stat-detail {
            font-size: 14px;
            color: #888;
            margin-top: 8px;
        }
        
        .cookie-info {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
            border: 2px dashed #ddd;
        }
        
        .cookie-info h3 {
            color: #667eea;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cookie-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .cookie-item {
            padding: 12px;
            background: #f9f9ff;
            border-radius: 8px;
        }
        
        .cookie-key {
            font-weight: 600;
            color: #555;
        }
        
        .cookie-value {
            color: #333;
            font-family: monospace;
            margin-top: 5px;
        }
        
        .actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 15px 35px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-secondary {
            background: #f0f2ff;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-danger {
            background: linear-gradient(90deg, #ff6b6b, #ff8e53);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .visit-message {
            text-align: center;
            font-size: 22px;
            color: #555;
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 15px;
            font-weight: 500;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .badge-new {
            background: #4cd964;
            color: white;
        }
        
        .badge-regular {
            background: #667eea;
            color: white;
        }
        
        .badge-vip {
            background: #ff9500;
            color: white;
        }
        
        .visit-achievement {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .milestone {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            min-width: 100px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid #f0f0f0;
        }
        
        .milestone.active {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .milestone-number {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
        }
        
        .milestone-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 25px 20px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .counter-number {
                font-size: 80px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            color: #888;
            font-size: 14px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-cookie-bite"></i> Cookie Visit Counter</h1>
            <p class="subtitle">Theo dõi số lần bạn truy cập trang web này</p>
        </header>
        
        <div class="counter-display">
            <div class="counter-label">Bạn đã truy cập trang này</div>
            <div class="counter-number"><?php echo $visit_count; ?></div>
            <div class="counter-label">lần</div>
            
            <?php if ($visit_count == 1): ?>
                <div class="visit-message">
                    👋 Chào mừng lần đầu tiên bạn ghé thăm!
                    <span class="badge badge-new">NGƯỜI MỚI</span>
                </div>
            <?php elseif ($visit_count < 5): ?>
                <div class="visit-message">
                    🎉 Rất vui được gặp lại bạn lần thứ <?php echo $visit_count; ?>!
                    <span class="badge badge-regular">KHÁCH QUEN</span>
                </div>
            <?php elseif ($visit_count < 10): ?>
                <div class="visit-message">
                    🤩 Wow! Bạn đã quay lại lần thứ <?php echo $visit_count; ?> rồi!
                    <span class="badge badge-vip">THÀNH VIÊN TÍCH CỰC</span>
                </div>
            <?php else: ?>
                <div class="visit-message">
                    🏆 Xuất sắc! Bạn thực sự yêu thích trang web này với <?php echo $visit_count; ?> lần ghé thăm!
                    <span class="badge badge-vip">VIP</span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Cột mốc đếm số -->
        <div class="visit-achievement">
            <?php 
            $milestones = [1, 5, 10, 25, 50, 100];
            foreach ($milestones as $milestone): 
                $is_active = $visit_count >= $milestone;
            ?>
                <div class="milestone <?php echo $is_active ? 'active' : ''; ?>">
                    <div class="milestone-number"><?php echo $milestone; ?></div>
                    <div class="milestone-label">lần</div>
                    <?php if ($is_active): ?>
                        <div style="color: #4cd964; font-size: 20px;">✓</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-title">Lần truy cập gần nhất</div>
                <div class="stat-value"><?php echo date('H:i', strtotime($last_visit)); ?></div>
                <div class="stat-detail"><?php echo date('d/m/Y', strtotime($last_visit)); ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-title">Lần đầu tiên ghé thăm</div>
                <div class="stat-value"><?php echo date('d/m/Y', strtotime($first_visit)); ?></div>
                <div class="stat-detail"><?php echo $days_since_first; ?> ngày trước</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-title">Tần suất trung bình</div>
                <div class="stat-value"><?php echo $avg_frequency; ?></div>
                <div class="stat-detail">lần/ngày</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-title">Cookie hết hạn sau</div>
                <div class="stat-value">30 ngày</div>
                <div class="stat-detail"><?php echo date('d/m/Y', time() + (30 * 24 * 60 * 60)); ?></div>
            </div>
        </div>
        
        <div class="cookie-info">
            <h3><i class="fas fa-info-circle"></i> Thông tin Cookie</h3>
            <div class="cookie-details">
                <div class="cookie-item">
                    <div class="cookie-key">visit_counter</div>
                    <div class="cookie-value"><?php echo $visit_count; ?></div>
                </div>
                <div class="cookie-item">
                    <div class="cookie-key">last_visit</div>
                    <div class="cookie-value"><?php echo $last_visit; ?></div>
                </div>
                <div class="cookie-item">
                    <div class="cookie-key">first_visit</div>
                    <div class="cookie-value"><?php echo $first_visit; ?></div>
                </div>
                <div class="cookie-item">
                    <div class="cookie-key">session_id</div>
                    <div class="cookie-value"><?php echo session_id(); ?></div>
                </div>
            </div>
        </div>
        
        <div class="actions">
            <button class="btn btn-primary" onclick="window.location.reload()">
                <i class="fas fa-redo"></i> Tải lại trang (+1 lượt)
            </button>
            
            <button class="btn btn-secondary" onclick="showCookieDetails()">
                <i class="fas fa-eye"></i> Xem chi tiết Cookie
            </button>
            
            <button class="btn btn-danger" onclick="resetCounter()">
                <i class="fas fa-trash-alt"></i> Xóa bộ đếm
            </button>
        </div>
        
        <footer>
            <p>Cookie sẽ được lưu trong 30 ngày. Đóng trình duyệt không làm mất dữ liệu.</p>
            <p>© 2024 Cookie Visit Counter Demo | Sử dụng PHP Cookies</p>
        </footer>
    </div>
    
    <script>
        // Hiển thị chi tiết cookie
        function showCookieDetails() {
            const cookies = document.cookie.split(';');
            let message = '📋 COOKIE HIỆN TẠI:\n\n';
            
            cookies.forEach(cookie => {
                const [key, value] = cookie.trim().split('=');
                message += `${key}: ${value}\n`;
            });
            
            alert(message);
        }
        
        // Reset bộ đếm
        function resetCounter() {
            if (confirm('Bạn có chắc chắn muốn xóa bộ đếm lượt truy cập?\nTất cả dữ liệu sẽ bị mất!')) {
                // Xóa tất cả cookie liên quan đến visit counter
                document.cookie = "visit_counter=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "first_visit=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "last_visit=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                
                // Reload trang
                setTimeout(() => {
                    alert('✅ Đã xóa bộ đếm thành công!');
                    window.location.reload();
                }, 100);
            }
        }
        
        // Hiệu ứng confetti khi đạt mốc
        <?php if (in_array($visit_count, [1, 5, 10, 25, 50, 100])): ?>
        setTimeout(() => {
            alert(`🎊 Chúc mừng! Bạn đã đạt ${<?php echo $visit_count; ?>} lượt truy cập!`);
        }, 500);
        <?php endif; ?>
        
        // Kiểm tra cookie được hỗ trợ
        if (!navigator.cookieEnabled) {
            alert("⚠️ Trình duyệt của bạn đã tắt Cookie! Chức năng đếm lượt truy cập sẽ không hoạt động.");
        }
    </script>
</body>
</html>