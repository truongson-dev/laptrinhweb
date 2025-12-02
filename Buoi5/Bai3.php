<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sắp xếp dãy số nguyên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 30px;
            padding: 20px;
            background-color: #e8f5e9;
            border-left: 5px solid #4CAF50;
            border-radius: 5px;
        }
        .error {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .original-array {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sắp xếp dãy số nguyên</h2>
        
        <form method="POST" action="">
            <label for="numbers">Nhập dãy số nguyên (phân cách bằng dấu phẩy):</label>
            <input type="text" 
                   id="numbers" 
                   name="numbers" 
                   placeholder="Ví dụ: 5, -2, 10, 3, 8, 1"
                   required
                   value="<?php echo isset($_POST['numbers']) ? htmlspecialchars($_POST['numbers']) : ''; ?>">
            
            <label for="sort_type">Chọn kiểu sắp xếp:</label>
            <select id="sort_type" name="sort_type">
                <option value="asc" <?php echo (isset($_POST['sort_type']) && $_POST['sort_type'] == 'asc') ? 'selected' : ''; ?>>Tăng dần (sort)</option>
                <option value="desc" <?php echo (isset($_POST['sort_type']) && $_POST['sort_type'] == 'desc') ? 'selected' : ''; ?>>Giảm dần (rsort)</option>
            </select>
            
            <button type="submit" name="submit">Sắp xếp</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $input = $_POST['numbers'];
            $sort_type = $_POST['sort_type'];
            
            // Làm sạch và chuyển đổi chuỗi thành mảng
            $numbers_array = array_map('trim', explode(',', $input));
            $numbers_array = array_filter($numbers_array, 'strlen'); // Loại bỏ giá trị rỗng
            
            // Kiểm tra tính hợp lệ của số nguyên
            $valid_numbers = [];
            $invalid_inputs = [];
            
            foreach ($numbers_array as $value) {
                if (is_numeric($value) && strpos($value, '.') === false) {
                    $valid_numbers[] = (int)$value;
                } else {
                    $invalid_inputs[] = $value;
                }
            }
            
            // Hiển thị kết quả
            echo '<div class="result">';
            echo '<p class="original-array"><strong>Dãy số ban đầu:</strong> ' . htmlspecialchars($input) . '</p>';
            
            if (!empty($invalid_inputs)) {
                echo '<div class="error">';
                echo '<strong>Cảnh báo:</strong> Các giá trị không phải số nguyên đã bị bỏ qua: ';
                echo '<em>' . htmlspecialchars(implode(', ', $invalid_inputs)) . '</em>';
                echo '</div>';
            }
            
            if (count($valid_numbers) > 0) {
                if ($sort_type == 'asc') {
                    sort($valid_numbers);
                    $sort_text = 'TĂNG DẦN';
                } else {
                    rsort($valid_numbers);
                    $sort_text = 'GIẢM DẦN';
                }
                
                echo '<h3>Kết quả sắp xếp ' . $sort_text . ':</h3>';
                echo '<p>' . implode(', ', $valid_numbers) . '</p>';
                
                // Thông tin thêm
                echo '<p><strong>Tổng số phần tử:</strong> ' . count($valid_numbers) . '</p>';
                echo '<p><strong>Số nhỏ nhất:</strong> ' . min($valid_numbers) . '</p>';
                echo '<p><strong>Số lớn nhất:</strong> ' . max($valid_numbers) . '</p>';
            } else {
                echo '<div class="error">';
                echo '<strong>Lỗi:</strong> Không có số nguyên hợp lệ để sắp xếp.';
                echo '</div>';
            }
            
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>