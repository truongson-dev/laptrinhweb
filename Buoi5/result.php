<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả xử lý mảng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f9;
        }
        .result {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        h3 {
            color: #333;
        }
        p {
            margin: 10px 0;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-weight: bold;
            background-color: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid red;
        }
        .warning {
            color: #ff9900;
            font-weight: bold;
            background-color: #fff9e6;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #ff9900;
        }
        .success {
            color: green;
            font-weight: bold;
            background-color: #e6ffe6;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid green;
        }
        pre {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h2>Kết quả xử lý mảng</h2>
    <div class="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numbers'])) {
            // Lấy chuỗi từ form
            $input = trim($_POST['numbers']);
            echo "<p><strong>Chuỗi đã nhập:</strong> " . htmlspecialchars($input) . "</p>";
            
            // Kiểm tra xem chuỗi có trống không
            if (empty($input)) {
                echo "<div class='error'>Lỗi: Bạn chưa nhập dữ liệu!</div>";
                echo "<a href='Bai1.php' class='back-link'>Quay lại trang nhập liệu</a>";
                exit();
            }
            
            // Kiểm tra xem có dấu cách không hợp lệ không (dấu cách thừa giữa các số)
            if (preg_match('/\s*,\s*,\s*/', $input)) {
                echo "<div class='error'>Lỗi: Có dấu phẩy liên tiếp hoặc khoảng cách không hợp lệ trong chuỗi!</div>";
                echo "<div class='warning'>Gợi ý: Hãy nhập đúng định dạng: số1,số2,số3,số4,số5 (không có khoảng trắng thừa giữa các dấu phẩy)</div>";
                echo "<a href='Bai1.php' class='back-link'>Quay lại trang nhập liệu</a>";
                exit();
            }
            
            // Thay thế dấu cách và dấu chấm phẩy bằng dấu phẩy để hỗ trợ nhiều định dạng
            $input = str_replace([' ', ';', '，', '、'], ',', $input);
            
            // Tách chuỗi thành mảng
            $numbers = explode(',', $input);
            
            // Kiểm tra xem có ít nhất một phần tử không
            if (count($numbers) === 0) {
                echo "<div class='error'>Lỗi: Không tìm thấy số nào trong chuỗi đã nhập!</div>";
                echo "<a href='Bai1.php' class='back-link'>Quay lại trang nhập liệu</a>";
                exit();
            }
            
            // Kiểm tra từng phần tử
            $validNumbers = [];
            $invalidElements = [];
            
            foreach ($numbers as $index => $element) {
                $element = trim($element);
                
                // Bỏ qua phần tử rỗng
                if ($element === '') {
                    continue;
                }
                
                // Kiểm tra xem phần tử có phải là số nguyên không
                // is_numeric kiểm tra cả số nguyên và số thực
                // Thêm kiểm tra để đảm bảo không phải là số thực (không có dấu chấm)
                if (is_numeric($element) && strpos($element, '.') === false) {
                    // Kiểm tra thêm để loại bỏ các chuỗi bắt đầu bằng 0 nhưng có chữ (ví dụ: 0abc)
                    if (preg_match('/^-?\d+$/', $element)) {
                        $validNumbers[] = (int)$element;
                    } else {
                        $invalidElements[] = $element;
                    }
                } else {
                    $invalidElements[] = $element;
                }
            }
            
            // Kiểm tra xem có phần tử không hợp lệ không
            if (!empty($invalidElements)) {
                echo "<div class='error'>Lỗi: Tìm thấy " . count($invalidElements) . " phần tử không phải số nguyên:</div>";
                echo "<ul>";
                foreach ($invalidElements as $invalid) {
                    echo "<li>" . htmlspecialchars($invalid) . "</li>";
                }
                echo "</ul>";
                echo "<div class='warning'>Chỉ chấp nhận số nguyên (không có dấu chấm, không có ký tự chữ, không có ký tự đặc biệt)</div>";
                echo "<a href='Bai1.php' class='back-link'>Quay lại trang nhập liệu</a>";
                exit();
            }
            
            // Kiểm tra xem có ít nhất một số hợp lệ không
            if (count($validNumbers) === 0) {
                echo "<div class='error'>Lỗi: Không tìm thấy số nguyên hợp lệ nào!</div>";
                echo "<a href='Bai1.php' class='back-link'>Quay lại trang nhập liệu</a>";
                exit();
            }
            
            
            // 1. In ra mảng vừa nhập
            echo "<p><strong>Mảng số đã nhập:</strong></p>";
            echo "<pre>";
            print_r($validNumbers);
            echo "</pre>";
            
            // 2. Tính tổng
            $sum = array_sum($validNumbers);
            echo "<p><strong>Tổng các phần tử:</strong> " . $sum . "</p>";
            
            // 3. Đếm số phần tử
            $count = count($validNumbers);
            echo "<p><strong>Số lượng phần tử:</strong> " . $count . "</p>";
            
            // 4. Tìm phần tử lớn nhất và nhỏ nhất
            $max = max($validNumbers);
            $min = min($validNumbers);
            echo "<p><strong>Phần tử lớn nhất:</strong> " . $max . "</p>";
            echo "<p><strong>Phần tử nhỏ nhất:</strong> " . $min . "</p>";
            
            // 5. Tính trung bình cộng
            $average = $sum / $count;
            echo "<p><strong>Trung bình cộng:</strong> " . number_format($average, 2) . "</p>";
            
            // 6. In các phần tử chẵn
            $evenNumbers = array_filter($validNumbers, function($value) {
                return $value % 2 == 0;
            });
            echo "<p><strong>Các phần tử chẵn:</strong> ";
            if (!empty($evenNumbers)) {
                echo implode(', ', $evenNumbers);
                echo " (" . count($evenNumbers) . " số)";
            } else {
                echo "Không có số chẵn";
            }
            echo "</p>";
            
            // 7. In các phần tử lẻ
            $oddNumbers = array_filter($validNumbers, function($value) {
                return $value % 2 != 0;
            });
            echo "<p><strong>Các phần tử lẻ:</strong> ";
            if (!empty($oddNumbers)) {
                echo implode(', ', $oddNumbers);
                echo " (" . count($oddNumbers) . " số)";
            } else {
                echo "Không có số lẻ";
            }
            echo "</p>";
            
        } else {
            echo "<div class='error'>Không có dữ liệu được gửi lên.</div>";
        }
        ?>
        <a href="Bai1.php" class="back-link">Quay lại trang nhập liệu</a>
    </div>
</body>
</html>