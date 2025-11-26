<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vòng lặp FOR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
        }
        
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        
        input[type="text"] {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 120px;
            text-align: center;
        }
        
        input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
        }
        
        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .back-button {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin: 10px 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        
        .back-button:hover {
            background-color: #5a6268;
        }
        
        .result {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            border-left: 4px solid #3498db;
            margin-top: 20px;
        }
        
        .result b {
            color: #e74c3c;
            font-size: 18px;
        }
        
        .error {
            background-color: #fadbd8;
            border-left: 4px solid #e74c3c;
        }
        
        .info {
            background-color: #e2e3e5;
            border-left: 4px solid #6c757d;
        }
        
        .user-input {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }
        
        .calculation {
            margin-top: 10px;
            font-family: 'Courier New', monospace;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tổng các số từ 1 đến N</h2>
        <form method="post">
            Nhập N: <input type="text" name="n" required placeholder="Nhập số nguyên">
            <br>
            <button type="submit">Tính tổng</button>
            <a href="Bai7.php" class="back-button">Quay lại Menu chính</a>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy giá trị từ form
            $input = $_POST["n"];
            
            // Kiểm tra xem có phải là số nguyên dương không
            if (preg_match('/^\d+$/', $input)) {
                $n = intval($input);
                
                if ($n > 0) {
                    $sum = 0;
                    $calculation = "";
                    
                    // Tính tổng và xây dựng chuỗi tính toán
                    for ($i = 1; $i <= $n; $i++) {
                        $sum += $i;
                        $calculation .= $i;
                        if ($i < $n) {
                            $calculation .= " + ";
                        }
                    }
                    
                    echo "<div class='result'>";
                    echo "Tổng các số từ 1 đến <strong>$n</strong> là: <b>$sum</b>";
                    // echo "<div class='calculation'>$calculation = $sum</div>";
                    echo "</div>";
                    
                } else {
                    echo "<div class='result error'>";
                    echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> phải là số nguyên lớn hơn 0!";
                    echo "<div class='user-input'>Vui lòng nhập số nguyên dương (ví dụ: 5, 10, 100)</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='result error'>";
                echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> không phải là số nguyên!";
                echo "<div class='user-input'>Vui lòng nhập số nguyên dương (ví dụ: 5, 10, 100)</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>