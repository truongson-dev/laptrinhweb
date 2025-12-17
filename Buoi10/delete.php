<?php
require_once 'ketnoi.php';

// Kiểm tra id_sinhvien được truyền vào hay không?
if (isset($_GET['id_sinhvien'])) {
    $id = $_GET['id_sinhvien'];
    
    // Bảo vệ khỏi SQL Injection
    $id = $conn->real_escape_string($id);
    
    // Xác nhận trước khi xóa (tùy chọn - có thể thêm form xác nhận)
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql = "DELETE FROM sinhvien WHERE id_sinhvien = '$id'";
        
        if ($conn->query($sql) === TRUE) {
            // Chuyển hướng về trang danh sách sau khi xóa thành công
            header("Location: insertList.php");
            exit();
        } else {
            echo "Lỗi khi xóa dữ liệu: " . $conn->error;
        }
    } else {
        // Hiển thị form xác nhận
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Xác nhận xóa</title>
        </head>
        <body>
            <h2>XÁC NHẬN XÓA</h2>
            <p>Bạn có chắc chắn muốn xóa sinh viên này?</p>
            <p>
                <a href="delete.php?id_sinhvien=<?php echo $id; ?>&confirm=yes" style="color: red; font-weight: bold;">CÓ, XÓA</a> | 
                <a href="insertList.php">KHÔNG, QUAY LẠI</a>
            </p>
        </body>
        </html>
        <?php
        exit();
    }
} else {
    die("Không có ID sinh viên được cung cấp");
}

// Đóng kết nối
$conn->close();
?>