<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>In số nguyên chẵn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
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
            border-color: #9b59b6;
            outline: none;
        }
        
        button {
            background-color: #9b59b6;
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
            background-color: #8e44ad;
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
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .info {
            background-color: #e2e3e5;
            border-left: 4px solid #6c757d;
            text-align: center;
        }
        
        .success {
            background-color: #e8f4f8;
            border-left: 4px solid #3498db;
        }
        
        .error {
            background-color: #fadbd8;
            border-left: 4px solid #e74c3c;
            text-align: center;
        }
        
        .numbers {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            justify-content: center;
        }
        
        .even-number {
            background-color: #3498db;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: bold;
        }
        
        .no-result {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .user-input {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }
        
        .summary {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>In các số nguyên chẵn từ 1 đến N</h2>
        <form method="post">
            Nhập N: <input type="text" name="n" required placeholder="Nhập số nguyên">
            <br>
            <button type="submit">Hiển thị số chẵn</button>
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
                    echo "<div class='result success'>";
                    echo "<p><strong>Các số nguyên chẵn từ 1 đến $n:</strong></p>";
                    
                    $evenNumbers = [];
                    for ($i = 1; $i <= $n; $i++) {
                        if ($i % 2 == 0) {
                            $evenNumbers[] = $i;
                        }
                    }
                    
                    if (count($evenNumbers) > 0) {
                        echo "<div class='numbers'>";
                        foreach ($evenNumbers as $number) {
                            echo "<span class='even-number'>$number</span>";
                        }
                        echo "</div>";
                        
                        // Hiển thị tổng số chẵn
                        echo "<div class='summary'>Tổng cộng có <strong>" . count($evenNumbers) . "</strong> số chẵn.</div>";
                    } else {
                        echo "<p class='no-result'>Không có số chẵn nào trong khoảng từ 1 đến $n</p>";
                    }
                    
                    echo "</div>";
                } else {
                    echo "<div class='result error'>";
                    echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> phải là số nguyên lớn hơn hoặc bằng 1!";
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