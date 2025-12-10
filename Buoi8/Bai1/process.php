<?php
session_start();

// Kiểm tra có dữ liệu POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    
    // Kiểm tra tên không rỗng
    if (!empty($name)) {
        // Làm sạch dữ liệu
        // $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        
        // Lưu vào session
        $_SESSION['name'] = $name;
        $_SESSION['time'] = date('H:i:s d/m/Y');
        
        // Chuyển đến trang kết quả
        header('Location: result.php');
        exit();
    }
}

// Nếu lỗi, quay về trang chủ
header('Location: index.php');
exit();
?>