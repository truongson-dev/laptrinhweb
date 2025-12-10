<?php
/**
 * File đăng xuất
 */
session_start();

// Ghi log đăng xuất
if (isset($_SESSION['username'])) {
    $log_entry = date('Y-m-d H:i:s') . " - User '{$_SESSION['username']}' logged out\n";
    file_put_contents('login_log.txt', $log_entry, FILE_APPEND);
}

// Xóa tất cả biến session
$_SESSION = array();

// Nếu muốn hủy session hoàn toàn, xóa cả cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập với thông báo
$logout_param = 'logout=success';
if (isset($_GET['timeout']) && $_GET['timeout'] == 1) {
    $logout_param = 'error=4'; // Timeout
}

header('Location: login.php?' . $logout_param);
exit();
?>