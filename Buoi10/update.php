<?php
require_once 'ketnoi.php';
// Kiểm tra id_sinhvien có được truyền qua GET không
if (isset($_GET['id_sinhvien'])) {
    $id_sinhvien = $_GET['id_sinhvien'];
    
    // Lấy thông tin sinh viên cần cập nhật
    $sql = "SELECT * FROM sinhvien WHERE id_sinhvien = '$id_sinhvien'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Không tìm thấy sinh viên với ID: $id_sinhvien");
    }
} else {
    die("Không có ID sinh viên được cung cấp");
}

// Xử lý cập nhật dữ liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sinhvien'])) {
    $id_sinhvien = $_POST['id_sinhvien'];
    $hoten = $_POST['hoten'];
    $lop = $_POST['lop'];
    
    // Kiểm tra dữ liệu
    if (!empty($hoten) && !empty($lop)) {
        // Câu lệnh UPDATE
        $update_sql = "UPDATE sinhvien SET hoten = '$hoten', lop = '$lop' WHERE id_sinhvien = '$id_sinhvien'";
        
        if ($conn->query($update_sql) === TRUE) {
            echo "<p style='color: green;'>Cập nhật dữ liệu thành công!</p>";
            // Lấy lại dữ liệu mới
            $sql = "SELECT * FROM sinhvien WHERE id_sinhvien = '$id_sinhvien'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        } else {
            echo "<p style='color: red;'>Lỗi cập nhật: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Vui lòng nhập đầy đủ thông tin</p>";
    }
}
?>

<html>
<head>
    <title>Cập nhật thông tin sinh viên</title>
</head>
<body>
    <h2>CẬP NHẬT THÔNG TIN SINH VIÊN</h2>
    <form action="update.php?id_sinhvien=<?php echo $id_sinhvien; ?>" method="POST">
        <input type="hidden" id="id_sinhvien" name="id_sinhvien" value="<?php echo $row['id_sinhvien']; ?>">
        
        <label for="hoten">Họ tên sinh viên:</label><br>
        <input type="text" id="hoten" name="hoten" value="<?php echo htmlspecialchars($row['hoten']); ?>"><br><br>
        
        <label for="lop">Lớp:</label><br>
        <input type="text" id="lop" name="lop" value="<?php echo htmlspecialchars($row['lop']); ?>"><br><br>
        
        <button type="submit">Cập nhật</button>
    </form>
    <br>
    <a href="javascript:history.back()">Quay lại</a>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>