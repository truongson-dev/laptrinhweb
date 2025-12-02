<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 1: Nhập dãy số</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f9;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Bài 1: Xử lý mảng số</h2>
    <p>Nhập các số nguyên, cách nhau bằng dấu phẩy (ví dụ: 12,45,23,67,89)</p>
    
    <?php
    // Hiển thị thông báo lỗi nếu có từ trang trước
    if (isset($_GET['error'])) {
        echo "<div class='error'>" . htmlspecialchars(urldecode($_GET['error'])) . "</div>";
    }
    if (isset($_GET['success'])) {
        echo "<div class='success'>" . htmlspecialchars(urldecode($_GET['success'])) . "</div>";
    }
    ?>
    
    <form action="result.php" method="POST">
        <label for="numbers">Chuỗi số:</label>
        <input type="text" id="numbers" name="numbers" required placeholder="12,45,23,67,89">
        <input type="submit" value="Xử lý">
    </form>
</body>
</html>