<?php
session_start();

// Nếu đã có tên trong session, chuyển thẳng đến result
if (isset($_SESSION['name'])) {
    header('Location: result.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bài 1 - Nhập tên</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 50px;
            background: #f0f0f0;
        }
        form {
            display: inline-block;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            padding: 10px;
            margin: 10px 0;
            width: 200px;
        }
        button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Nhập tên của bạn</h2>
    <form method="POST" action="process.php">
        <input type="text" name="name" placeholder="Nhập tên..." required>
        <br>
        <button type="submit">Gửi</button>
    </form>
</body>
</html>