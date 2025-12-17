<?php
// Thông tin kết nối CSDL
$servername = "localhost";
$username = "root";
$password   = "Son@2006";
$dbname     = "php_khue";// Tên CSDL

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$id_sinhvien = $_POST['id_sinhvien'];
$hoten = $_POST['hoten'];
$lop = $_POST['lop'];

// Chuẩn bị câu lệnh SQL để chèn dữ liệu
$sql = "INSERT INTO sinhvien (id_sinhvien, hoten, lop) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id_sinhvien, $hoten, $lop);

// Thực thi và kiểm tra
if ($stmt->execute()) {
    echo "Thêm sinh viên thành công!";
    echo "<br><a href='form.php'>Thêm sinh viên khác</a>";
    echo "<br><a href='display.php'>Xem danh sách sinh viên</a>";
} else {
    echo "Lỗi: " . $stmt->error;
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>