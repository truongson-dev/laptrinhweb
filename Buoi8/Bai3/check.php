<?php
/**
 * File xử lý đăng nhập
 */
session_start();

// Chống tấn công CSRF đơn giản
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php?error=1');
    exit();
}

// Lấy dữ liệu từ form
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Kiểm tra dữ liệu đầu vào
if (empty($username) || empty($password)) {
    header('Location: login.php?error=1&user=' . urlencode($username));
    exit();
}

// Thông tin đăng nhập cố định (trong thực tế nên lưu trong database)
$valid_username = 'admin';
$valid_password = '123';

// Kiểm tra thông tin đăng nhập
if ($username === $valid_username && $password === $valid_password) {
    // Đăng nhập thành công
    // Tạo session và lưu thông tin
    $_SESSION['logged'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['login_time'] = time();
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    
    // Chống session fixation
    session_regenerate_id(true);
    
    // Ghi log đăng nhập (trong thực tế nên ghi vào file/database)
    $log_entry = date('Y-m-d H:i:s') . " - User '{$username}' logged in from {$_SERVER['REMOTE_ADDR']}\n";
    file_put_contents('login_log.txt', $log_entry, FILE_APPEND);
    
    // Chuyển hướng đến trang admin
    header('Location: admin.php');
    exit();
} else {
    // Đăng nhập thất bại
    // Ghi log failed attempt
    $log_entry = date('Y-m-d H:i:s') . " - Failed login attempt for user '{$username}' from {$_SERVER['REMOTE_ADDR']}\n";
    file_put_contents('login_log.txt', $log_entry, FILE_APPEND);
    
    // Chuyển hướng về trang đăng nhập với thông báo lỗi
    header('Location: login.php?error=2&user=' . urlencode($username));
    exit();
}
?>  