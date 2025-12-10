<?php
// ==============================
// PHẦN 1: BẮT ĐẦU SESSION
// ==============================
session_start();

// Biến để hiển thị thông báo
$message = "";
$action = $_GET['action'] ?? '';

// ==============================
// XỬ LÝ CÁC HÀNH ĐỘNG
// ==============================

if ($action == 'create_session') {
    // Tạo Session
    $_SESSION['username'] = "admin";
    $_SESSION['role'] = "editor";
    $_SESSION['cart'] = [];
    $message = "✅ Đã tạo session: username='admin', role='editor'";
}

elseif ($action == 'get_session') {
    // Lấy dữ liệu Session
    if (isset($_SESSION['username'])) {
        $message = "📋 Session hiện tại:<br>";
        $message .= "- Username: " . $_SESSION['username'] . "<br>";
        $message .= "- Role: " . $_SESSION['role'] . "<br>";
        $message .= "- Cart: " . print_r($_SESSION['cart'] ?? [], true);
    } else {
        $message = "⚠️ Không có session nào được tạo";
    }
}

elseif ($action == 'delete_session') {
    // Xóa một Session
    unset($_SESSION['username']);
    $message = "🗑️ Đã xóa session 'username'";
}

elseif ($action == 'destroy_session') {
    // Huỷ toàn bộ Session
    session_destroy();
    $message = "💥 Đã huỷ toàn bộ session!";
}

elseif ($action == 'create_cookie') {
    // Tạo Cookie
    setcookie("username", "admin", time() + 3600); // tồn tại 1 giờ
    setcookie("theme", "dark", time() + 7*24*3600); // 7 ngày
    $message = "🍪 Đã tạo cookie!";
}

elseif ($action == 'read_cookie') {
    // Đọc Cookie
    if (isset($_COOKIE['username'])) {
        $message = "📖 Cookie hiện tại:<br>";
        $message .= "- Username: " . $_COOKIE['username'] . "<br>";
        if (isset($_COOKIE['theme'])) {
            $message .= "- Theme: " . $_COOKIE['theme'];
        }
    } else {
        $message = "⚠️ Không có cookie nào";
    }
}

elseif ($action == 'delete_cookie') {
    // Xóa Cookie
    setcookie("username", "", time() - 3600);
    setcookie("theme", "", time() - 3600);
    $message = "🗑️ Đã xóa cookie!";
}

// ==============================
// ỨNG DỤNG 1: ĐĂNG NHẬP (SESSION)
// ==============================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Kiểm tra đăng nhập đơn giản
    if ($username == "admin" && $password == "123") {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $username;
        
        // Ghi nhớ đăng nhập bằng cookie nếu được chọn
        if (isset($_POST['remember'])) {
            setcookie("remember_user", $username, time() + 7*24*3600);
        }
        
        $message = "🎉 Đăng nhập thành công!";
    } else {
        $message = "❌ Sai tên đăng nhập hoặc mật khẩu";
    }
}

// ==============================
// ỨNG DỤNG 2: GIỎ HÀNG (SESSION)
// ==============================
if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];
    
    // Tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Thêm sản phẩm vào giỏ hàng
    $_SESSION['cart'][] = $product_id;
    $message = "🛒 Đã thêm sản phẩm ID: $product_id vào giỏ hàng!";
}

// ==============================
// ỨNG DỤNG 3: THEME (COOKIE)
// ==============================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_theme'])) {
    $theme = $_POST['theme'];
    // Lưu theme vào cookie trong 30 ngày
    setcookie("theme", $theme, time() + 30*24*3600);
    $message = "🎨 Đã đổi theme thành: $theme";
}

// ==============================
// KIỂM TRA THÔNG TIN HIỆN TẠI
// ==============================
function getCurrentInfo() {
    $info = "<h4>📊 Thông tin hiện tại:</h4>";
    
    // Session
    $info .= "<strong>SESSION:</strong><br>";
    if (isset($_SESSION) && !empty($_SESSION)) {
        foreach ($_SESSION as $key => $value) {
            $info .= "- $key: " . (is_array($value) ? implode(', ', $value) : $value) . "<br>";
        }
    } else {
        $info .= "(Trống)<br>";
    }
    
    // Cookie
    $info .= "<strong>COOKIE:</strong><br>";
    if (isset($_COOKIE) && !empty($_COOKIE)) {
        foreach ($_COOKIE as $key => $value) {
            $info .= "- $key: $value<br>";
        }
    } else {
        $info .= "(Trống)<br>";
    }
    
    return $info;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Session & Cookie Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? '#333' : '#f4f4f4'; ?>;
            color: <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? '#fff' : '#000'; ?>;
        }
        .section {
            background: <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? '#444' : '#fff'; ?>;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #45a049;
        }
        .message {
            padding: 15px;
            background: #e7f3fe;
            border-left: 6px solid #2196F3;
            margin: 15px 0;
            border-radius: 5px;
        }
        form {
            margin: 10px 0;
        }
        input, select {
            padding: 8px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h1>🔄 Session & Cookie Demo</h1>
    
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <!-- PHẦN HIỂN THỊ THÔNG TIN -->
    <div class="section">
        <?php echo getCurrentInfo(); ?>
    </div>
    
    <!-- ============================== -->
    <!-- PHẦN 1: QUẢN LÝ SESSION -->
    <!-- ============================== -->
    <div class="section">
        <h2>📁 QUẢN LÝ SESSION</h2>
        <a class="btn" href="?action=create_session">Tạo Session</a>
        <a class="btn" href="?action=get_session">Xem Session</a>
        <a class="btn" href="?action=delete_session">Xóa Session (username)</a>
        <a class="btn" href="?action=destroy_session">Huỷ toàn bộ Session</a>
    </div>
    
    <!-- ============================== -->
    <!-- PHẦN 2: QUẢN LÝ COOKIE -->
    <!-- ============================== -->
    <div class="section">
        <h2>🍪 QUẢN LÝ COOKIE</h2>
        <a class="btn" href="?action=create_cookie">Tạo Cookie</a>
        <a class="btn" href="?action=read_cookie">Xem Cookie</a>
        <a class="btn" href="?action=delete_cookie">Xóa Cookie</a>
    </div>
    
    <!-- ============================== -->
    <!-- ỨNG DỤNG 1: ĐĂNG NHẬP -->
    <!-- ============================== -->
    <div class="section">
        <h2>🔐 ỨNG DỤNG: ĐĂNG NHẬP</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username (admin)" required>
            <input type="password" name="password" placeholder="Password (123)" required><br>
            <label>
                <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
            </label><br><br>
            <button class="btn" type="submit" name="login">Đăng nhập</button>
            <a class="btn" href="?action=destroy_session">Đăng xuất</a>
        </form>
        
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <p>✅ Bạn đã đăng nhập với tên: <strong><?php echo $_SESSION['user']; ?></strong></p>
        <?php elseif (isset($_COOKIE['remember_user'])): ?>
            <p>📝 Cookie remember: <strong><?php echo $_COOKIE['remember_user']; ?></strong></p>
        <?php endif; ?>
    </div>
    
    <!-- ============================== -->
    <!-- ỨNG DỤNG 2: GIỎ HÀNG -->
    <!-- ============================== -->
    <div class="section">
        <h2>🛒 ỨNG DỤNG: GIỎ HÀNG</h2>
        <p>Thêm sản phẩm vào giỏ hàng:</p>
        <a class="btn" href="?add_to_cart=1">Thêm iPhone 14</a>
        <a class="btn" href="?add_to_cart=2">Thêm Samsung Galaxy</a>
        <a class="btn" href="?add_to_cart=3">Thêm MacBook Pro</a>
        
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <h3>Giỏ hàng của bạn:</h3>
            <?php 
            $products = [
                1 => 'iPhone 14',
                2 => 'Samsung Galaxy',
                3 => 'MacBook Pro'
            ];
            ?>
            <ul>
            <?php foreach ($_SESSION['cart'] as $product_id): ?>
                <li><?php echo $products[$product_id] ?? "Sản phẩm $product_id"; ?></li>
            <?php endforeach; ?>
            </ul>
            <p>Tổng: <?php echo count($_SESSION['cart']); ?> sản phẩm</p>
        <?php else: ?>
            <p>Giỏ hàng trống</p>
        <?php endif; ?>
    </div>
    
    <!-- ============================== -->
    <!-- ỨNG DỤNG 3: THEME -->
    <!-- ============================== -->
    <div class="section">
        <h2>🎨 ỨNG DỤNG: CHỌN THEME</h2>
        <form method="POST">
            <select name="theme">
                <option value="light" <?php echo (isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'light') ? 'selected' : ''; ?>>Light Mode</option>
                <option value="dark" <?php echo (isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') ? 'selected' : ''; ?>>Dark Mode</option>
                <option value="blue" <?php echo (isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'blue') ? 'selected' : ''; ?>>Blue Theme</option>
            </select>
            <button class="btn" type="submit" name="save_theme">Lưu Theme</button>
        </form>
        
        <?php if (isset($_COOKIE['theme'])): ?>
            <p>Theme hiện tại: <strong><?php echo $_COOKIE['theme']; ?></strong></p>
        <?php endif; ?>
    </div>
    
</body>
</html>