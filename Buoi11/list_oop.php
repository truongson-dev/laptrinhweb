<?php
require_once "database.php";
require_once "sinhvien.php";

$db = new Database();
$sv = new SinhVien($db);

if (isset($_GET['delete'])) {
    $sv->delete($_GET['delete']);
    header("Location: List_oop.php");
    exit();
}

$result = $sv->getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .actions a {
            color: #4CAF50;
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            border: 1px solid #4CAF50;
            border-radius: 4px;
        }
        .actions a:hover {
            background-color: #4CAF50;
            color: white;
        }
        .delete-link {
            color: #f44336;
            border-color: #f44336;
        }
        .delete-link:hover {
            background-color: #f44336;
            color: white;
        }
        .add-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .add-button:hover {
            background-color: #45a049;
        }
        .empty-message {
            text-align: center;
            color: #777;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>DANH SÁCH SINH VIÊN</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Lớp</th>
                <th>Hành động</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_sinhvien']); ?></td>
                        <td><?php echo htmlspecialchars($row['hoten']); ?></td>
                        <td><?php echo htmlspecialchars($row['lop']); ?></td>
                        <td class="actions">
                            <a href="edit_oop.php?id=<?php echo $row['id_sinhvien']; ?>">Sửa</a>
                            <a class="delete-link" href="List_oop.php?delete=<?php echo $row['id_sinhvien']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="empty-message">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </table>
        <a href="add_oop.php" class="add-button">Thêm sinh viên</a>
    </div>
</body>
</html>

<?php
$db->close();
?>