<!DOCTYPE html>
<html>
<head>
    <title>Xếp loại học lực</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f0f8ff;
        }
        
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
        }
        
        button {
            background-color: #3498db;
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
            background-color: #2980b9;
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
            margin-top: 25px;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }
        
        .info {
            background-color: #e2e3e5;
            color: #383d41;
            border: 2px solid #d6d8db;
        }
        
        .excellent {
            background-color: #d4efdf;
            color: #186a3b;
            border: 2px solid #27ae60;
        }
        
        .good {
            background-color: #d6eaf8;
            color: #1a5276;
            border: 2px solid #3498db;
        }
        
        .average {
            background-color: #fcf3cf;
            color: #7d6608;
            border: 2px solid #f1c40f;
        }
        
        .weak {
            background-color: #fadbd8;
            color: #78281f;
            border: 2px solid #e74c3c;
        }
        
        .error {
            background-color: #f2f3f4;
            color: #566573;
            border: 2px solid #85929e;
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
        <h1>XẾP LOẠI HỌC LỰC</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="diem">Nhập điểm trung bình:</label>
                <input type="text" name="diem" id="diem" required 
                       placeholder="Nhập điểm từ 0 đến 10">
                <!-- <small style="color: #666;">Có thể nhập số nguyên hoặc số thập phân (ví dụ: 7.5, 8.0, 6.25)</small> -->
            </div>
            <button type="submit">Xếp loại</button>
            <a href="Bai7.php" class="back-button">Quay lại Menu chính</a>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy điểm từ form
            $input = $_POST["diem"];
            
            // Kiểm tra tính hợp lệ của điểm
            if (is_numeric($input)) {
                $diem = floatval($input);
                
                if ($diem >= 0 && $diem <= 10) {
                    // Xếp loại theo điểm
                    if ($diem >= 8.0) {
                        $xeploai = "GIỎI";
                        $class = "excellent";
                    } elseif ($diem >= 6.5) {
                        $xeploai = "KHÁ";
                        $class = "good";
                    } elseif ($diem >= 5.0) {
                        $xeploai = "TRUNG BÌNH";
                        $class = "average";
                    } else {
                        $xeploai = "YẾU";
                        $class = "weak";
                    }
                    
                    echo "<div class='result $class'>";
                    echo "Điểm: <strong>$diem</strong><br>";
                    echo "Xếp loại: <strong>$xeploai</strong>";
                    echo "</div>";
                    
                } else {
                    echo "<div class='result error'>";
                    echo "Lỗi: Điểm phải nằm trong khoảng từ 0 đến 10!";
                    echo "<div class='user-input'>Bạn đã nhập: $diem</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='result error'>";
                echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> không phải là số hợp lệ!";
                echo "<div class='user-input'>Vui lòng nhập số hợp lệ (ví dụ: 7.5, 8.0, 6.25)</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>