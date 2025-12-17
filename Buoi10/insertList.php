<?php
require_once 'ketnoi.php';
// Lấy dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra dữ liệu gửi lên
    if (isset($_POST['hoten']) && isset($_POST['lop']) && isset($_POST['id_sinhvien'])) {
        $idsv = $_POST['id_sinhvien'];
        $hoten = $_POST['hoten'];
        $lop = $_POST['lop'];

        if (!empty($hoten) && !empty($lop)) {
            // Tên bảng và tên cột dữ liệu giống như trong CSDL
            $sql = "INSERT INTO sinhvien (id_sinhvien, hoten, lop) VALUES ('$idsv', '$hoten', '$lop')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p>Thêm dữ liệu thành công</p>";
            } else {
                echo "<p>Lỗi thêm dữ liệu: " . $conn->error . "</p>";
            }
        }
    }
}
?>

<?php
// Truy xuất dữ liệu từ bảng sinhvien
$sql = "SELECT * FROM sinhvien";
$result = $conn->query($sql);
?>

<html>
<head>
    <title>Danh sách sinh viên</title>
</head>
<body>
    <h2>DANH SÁCH SINH VIÊN</h2>
    <table border="1">
        <tr>
            <th>id_sinhvien</th>
            <th>Họ tên SV</th>
            <th>Lớp</th>
            <th>Hành động</th>
        </tr>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_sinhvien']; ?></td>
                    <td><?php echo $row['hoten']; ?></td>
                    <td><?php echo $row['lop']; ?></td>
                    <td>
                        <a href="update.php?id_sinhvien=<?php echo $row['id_sinhvien']; ?>">Cập nhật</a>
                        <a href="delete.php?id_sinhvien=<?php echo $row['id_sinhvien']; ?>">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan='4'>Không có dữ liệu</td></tr>
        <?php endif; ?>
    </table>
<a href="form.php"><button type="button">Thêm sinh viên</button></a>
</body>
</html>
<?php
// Đóng kết nối
$conn->close();
?>
