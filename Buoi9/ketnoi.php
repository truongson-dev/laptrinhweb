<?php
// =======================
// 1. KẾT NỐI CƠ SỞ DỮ LIỆU
// =======================
$servername = "localhost";
$username   = "root";
$password   = "Son@2006";
$dbname     = "php_khue"; // tên CSDL

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// =======================
// 2. TRUY VẤN DỮ LIỆU
// =======================
$sql = "SELECT * FROM sinhvien";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
</head>
<body>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID SV</th>
        <th>Họ tên SV</th>
        <th>Lớp</th>
    </tr>

    <?php
    // =======================
    // 3. HIỂN THỊ DỮ LIỆU
    // =======================
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id_sinhvien']}</td>";
            echo "<td>{$row['hoten']}</td>";
            echo "<td>{$row['lop']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
    }
    ?>

</table>

</body>
</html>

<?php
// =======================
// 4. ĐÓNG KẾT NỐI
// =======================
$conn->close();
?>
