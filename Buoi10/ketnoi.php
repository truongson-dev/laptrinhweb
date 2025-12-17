<?php
// Thông tin kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "Son@2006";
$dbname = "php_khue"; // tên CSDL

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>