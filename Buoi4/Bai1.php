<!DOCTYPE html>
<html>
<head>
    <title>Kiểm tra số dương</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
            margin-bottom: 10px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        .back-button {
            background-color: #6c757d;
            display: block;
            text-align: center;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .back-button:hover {
            background-color: #5a6268;
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        
        .positive {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .negative {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background-color: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
        }
        
        .user-input {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kiểm tra số dương</h1>
        
        <!-- Form nhập số với method POST -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="number">Nhập một số:</label>
                <input type="text" name="number" id="number" required 
                       placeholder="Nhập số nguyên cần kiểm tra...">
                <small style="color: #666;">Chỉ chấp nhận số nguyên (ví dụ: 5, -3, 10, ...)</small>
            </div>
            <button type="submit">Kiểm tra</button>
            <a href="Bai7.php" class="back-button">Quay lại Menu chính</a>
        </form>

        <?php
        // Kiểm tra nếu form được submit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy giá trị từ form
            $input = $_POST["number"];
            
            // // Hiển thị thông tin về dữ liệu người dùng nhập
            // echo "<div class='result info'>";
            // echo "Bạn đã nhập: <strong>" . htmlspecialchars($input) . "</strong>";
            // echo "</div>";
            
            // Kiểm tra xem có phải là số nguyên không
            if (preg_match('/^-?\d+$/', $input)) {
                $number = intval($input);
                
                if ($number > 0) {
                    echo "<div class='result positive'>";
                    echo "Kết quả: Số <strong>$number</strong> là số dương.";
                    echo "</div>";
                } else if ($number == 0) {
                    echo "<div class='result negative'>";
                    echo "Kết quả: Số <strong>$number</strong> không phải là số dương (bằng 0).";
                    echo "</div>";
                } else {
                    echo "<div class='result negative'>";
                    echo "Kết quả: Số <strong>$number</strong> không phải là số dương (số âm).";
                    echo "</div>";
                }
            } else {
                echo "<div class='result negative'>";
                echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> không phải là số nguyên!";
                echo "<div class='user-input'>Vui lòng nhập số nguyên (ví dụ: 5, -3, 10, ...)</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>