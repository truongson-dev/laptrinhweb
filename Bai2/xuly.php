<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        echo "Vui lòng nhập đầy đủ thông tin";
    } else {
        echo "Đăng nhập thành công";
    }
} else {
    echo "Phương thức không hợp lệ";
}
?>