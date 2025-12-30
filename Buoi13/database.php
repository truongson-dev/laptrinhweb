<?php
// Thông tin kết nối MySQL
define('DB_HOST', 'localhost');
define('DB_USER', 'root');    
define('DB_PASS', 'Son@2006');         
define('DB_NAME', 'Computer30.12.2025');

// Hàm kết nối database
function connectDB() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối database thất bại: " . mysqli_connect_error());
    }
    
    // Thiết lập charset
    mysqli_set_charset($conn, "utf8mb4");
    
    return $conn;
}

// Hàm đóng kết nối
function closeDB($conn) {
    mysqli_close($conn);
}
?>