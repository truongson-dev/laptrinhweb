<?php
require_once "database.php";
require_once "sinhvien.php";

$db = new Database();
$sv = new SinhVien($db);

if (isset($_POST['add'])) {
    $sv->insert($_POST['IDSV'], $_POST['hoten'], $_POST['lop']);
    header("Location: List_oop.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h3 {
            color: #333;
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>THÊM SINH VIÊN</h3>
        <form method="post">
            <input type="text" name="IDSV" placeholder="ID SV" required>
            <input type="text" name="hoten" placeholder="Họ tên" required>
            <input type="text" name="lop" placeholder="Lớp" required>
            <button type="submit" name="add">Thêm</button>
        </form>
        <a href="List_oop.php" class="back-link">← Quay lại danh sách</a>
    </div>
</body>
</html>