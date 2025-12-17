<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">DANH SÁCH SINH VIÊN</h2>
    
    <?php
    // Thông tin kết nối CSDL
    $servername = "localhost";
    $username = "root";
    $password = "Son@2006";
    $dbname = "php_khue";
    
    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    // Truy xuất dữ liệu từ bảng sinhvien
    $sql = "SELECT * FROM sinhvien";
    $result = $conn->query($sql);
    ?>
    
    <table>
        <tr>
            <th>ID SV</th>
            <th>Họ tên</th>
            <th>Lớp</th>
        </tr>
        
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_sinhvien"] . "</td>";
                echo "<td>" . $row["hoten"] . "</td>";
                echo "<td>" . $row["lop"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Không có dữ liệu sinh viên</td></tr>";
        }
        
        // Đóng kết nối
        $conn->close();
        ?>
    </table>
    
    <div style="text-align: center;">
        <a href="form.php">Thêm sinh viên mới</a>
    </div>
</body>
</html>