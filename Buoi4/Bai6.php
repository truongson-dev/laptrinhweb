<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>In số từ N đến 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        
        form {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        input[type="text"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 100px;
            text-align: center;
        }
        
        button {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }
        
        .back-button {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            margin: 5px;
            display: inline-block;
        }
        
        button:hover, .back-button:hover {
            opacity: 0.9;
        }
        
        .result {
            margin-top: 20px;
        }
        
        .info {
            background-color: #e2e3e5;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 15px;
            border-left: 4px solid #6c757d;
        }
        
        .error {
            background-color: #fadbd8;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
            border-left: 4px solid #e74c3c;
        }
        
        .user-input {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }
        
        .numbers-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 5px;
            gap: 5px;
        }
        
        .number {
            padding: 5px 10px;
            border-radius: 3px;
            text-align: center;
            min-width: 40px;
        }
        
        .first-number {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        
        .other-number {
            background-color: #ecf0f1;
            color: #2c3e50;
        }
        
        .arrow {
            color: #7f8c8d;
            margin: 0 2px;
            align-self: center;
        }
        
        .summary {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background-color: #e8f4f8;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>In các số nguyên từ N đến 1</h2>
        <form method="post">
            Nhập N: <input type="text" name="n" required placeholder="Nhập số nguyên" value="<?php echo isset($_POST['n']) ? htmlspecialchars($_POST['n']) : ''; ?>">
            <br>
            <button type="submit">Hiển thị</button>
            <a href="Bai7.php" class="back-button">Quay lại Menu chính</a>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy giá trị từ form
            $input = $_POST["n"];
            
            
            // Kiểm tra xem có phải là số nguyên dương không
            if (preg_match('/^\d+$/', $input)) {
                $n = intval($input);
                
                if ($n >= 1) {
                    echo "<div class='result'>";
                    echo "<h3>Các số nguyên từ $n đến 1:</h3>";
                    
                    $numbersPerRow = 5; // Số lượng số hiển thị trên mỗi dòng
                    $count = 0;
                    
                    for ($i = $n; $i >= 1; $i--) {
                        // Bắt đầu một dòng mới
                        if ($count % $numbersPerRow == 0) {
                            if ($count > 0) {
                                echo "</div>"; // Đóng dòng trước đó
                            }
                            echo "<div class='numbers-row'>";
                        }
                        
                        // Hiển thị số
                        if ($count % $numbersPerRow == 0) {
                            // Số đầu tiên của dòng - in đậm
                            echo "<div class='number first-number'>$i</div>";
                        } else {
                            // Các số khác trong dòng
                            echo "<span class='arrow'>→</span>";
                            echo "<div class='number other-number'>$i</div>";
                        }
                        
                        $count++;
                    }
                    
                    // Đóng dòng cuối cùng
                    if ($count > 0) {
                        echo "</div>";
                    }
                    
                    // Hiển thị tổng số
                    echo "<div class='summary'>Tổng cộng có $n số</div>";
                    
                    echo "</div>";
                } else {
                    echo "<div class='error'>";
                    echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> phải là số nguyên lớn hơn hoặc bằng 1!";
                    echo "<div class='user-input'>Vui lòng nhập số nguyên dương (ví dụ: 5, 10, 100)</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='error'>";
                echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> không phải là số nguyên!";
                echo "<div class='user-input'>Vui lòng nhập số nguyên dương (ví dụ: 5, 10, 100)</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>