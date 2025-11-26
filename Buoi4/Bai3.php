<!DOCTYPE html>
<html>
<head>
    <title>Tra cứu thứ trong tuần</title>
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
            text-align: center;
        }
        
        input[type="text"]:focus {
            border-color: #9b59b6;
            outline: none;
        }
        
        button {
            background-color: #9b59b6;
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
            background-color: #8e44ad;
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
        
        .success {
            background-color: #e8f4f8;
            color: #2c3e50;
            border: 2px solid #3498db;
        }
        
        .error {
            background-color: #fadbd8;
            color: #78281f;
            border: 2px solid #e74c3c;
        }
        
        .user-input {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }

        
        .days-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }
        
        .day-item {
            padding: 8px;
            background-color: #f0f0f0;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tra Cứu Thứ Trong Tuần</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="soThu">Nhập số thứ tự (1-7):</label>
                <input type="text" name="soThu" id="soThu" required 
                       placeholder="Nhập số từ 1 đến 7">
                <small style="color: #666;">Chỉ chấp nhận số nguyên từ 1 đến 7</small>
            </div>
            <button type="submit">Hiển thị thứ</button>
            <a href="Bai7.php" class="back-button">Quay lại Menu chính</a>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy số thứ tự từ form
            $input = $_POST["soThu"];
            
            // Kiểm tra tính hợp lệ
            if (preg_match('/^\d+$/', $input)) {
                $soThu = intval($input);
                
                if ($soThu >= 1 && $soThu <= 7) {
                    // Dùng cấu trúc switch-case để xác định thứ
                    switch ($soThu) {
                        case 1:
                            $thu = "Chủ nhật";
                            break;
                        case 2:
                            $thu = "Thứ hai";
                            break;
                        case 3:
                            $thu = "Thứ ba";
                            break;
                        case 4:
                            $thu = "Thứ tư";
                            break;
                        case 5:
                            $thu = "Thứ năm";
                            break;
                        case 6:
                            $thu = "Thứ sáu";
                            break;
                        case 7:
                            $thu = "Thứ bảy";
                            break;
                        default:
                            $thu = "Không xác định";
                            break;
                    }
                    
                    echo "<div class='result success'>";
                    echo "Số <strong>$soThu</strong> tương ứng với: <strong>$thu</strong>";
                    echo "</div>";
                    
                } else {
                    echo "<div class='result error'>";
                    echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> không nằm trong khoảng từ 1 đến 7!";
                    echo "<div class='user-input'>Vui lòng nhập số từ 1 đến 7</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='result error'>";
                echo "Lỗi: <strong>" . htmlspecialchars($input) . "</strong> không phải là số nguyên!";
                echo "<div class='user-input'>Vui lòng nhập số nguyên từ 1 đến 7</div>";
                echo "</div>";
            }
        }
        ?>

        </div>
    </div>
</body>
</html>