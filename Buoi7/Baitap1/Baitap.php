<?php
// Xử lý upload file cho Bài 4 và Bài 6
$uploadMessage = '';
$fileInfo = '';

// Xử lý upload file đơn giản (Bài 4)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_simple'])) {
    if (isset($_FILES['simple_file']) && $_FILES['simple_file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['simple_file']['name'];
        $fileSize = $_FILES['simple_file']['size'];
        $fileTmp = $_FILES['simple_file']['tmp_name'];
        $uploadDir = 'uploads/';
        
        // Tạo thư mục uploads nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $destination = $uploadDir . basename($fileName);
        
        if (move_uploaded_file($fileTmp, $destination)) {
            $uploadMessage = '<div class="message success">Upload thành công!</div>';
            $fileInfo = '
                <div class="file-info">
                    <h4>Thông tin file:</h4>
                    <p><strong>Tên file:</strong> ' . htmlspecialchars($fileName) . '</p>
                    <p><strong>Dung lượng:</strong> ' . formatBytes($fileSize) . '</p>
                    <p><strong>Đường dẫn:</strong> ' . htmlspecialchars($destination) . '</p>
                </div>';
        } else {
            $uploadMessage = '<div class="message error">Upload thất bại!</div>';
        }
    } else {
        $uploadMessage = '<div class="message error">Vui lòng chọn file để upload!</div>';
    }
}

// Xử lý upload ảnh (Bài 6)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_image'])) {
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['image_file']['name'];
        $fileSize = $_FILES['image_file']['size'];
        $fileTmp = $_FILES['image_file']['tmp_name'];
        $fileType = $_FILES['image_file']['type'];
        $uploadDir = 'uploads/';
        
        // Kiểm tra định dạng file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if (!in_array($fileType, $allowedTypes) && !in_array($fileExt, ['jpg', 'jpeg', 'png'])) {
            $uploadMessage = '<div class="message error">Chỉ cho phép file JPG hoặc PNG!</div>';
        } elseif ($fileSize > 2 * 1024 * 1024) { // 2MB
            $uploadMessage = '<div class="message error">File quá lớn! Giới hạn 2MB.</div>';
        } else {
            // Tạo thư mục uploads nếu chưa tồn tại
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Tạo tên file mới để tránh trùng lặp
            $newFileName = time() . '_' . basename($fileName);
            $destination = $uploadDir . $newFileName;
            
            if (move_uploaded_file($fileTmp, $destination)) {
                $uploadMessage = '<div class="message success">Upload ảnh thành công!</div>';
                $fileInfo = '
                    <div class="file-info">
                        <h4>Thông tin ảnh:</h4>
                        <p><strong>Tên file:</strong> ' . htmlspecialchars($fileName) . '</p>
                        <p><strong>Dung lượng:</strong> ' . formatBytes($fileSize) . '</p>
                        <p><strong>Định dạng:</strong> ' . strtoupper($fileExt) . '</p>
                        <p><strong>Đường dẫn:</strong> ' . htmlspecialchars($destination) . '</p>
                        <div class="image-preview">
                            <h5>Xem trước ảnh:</h5>
                            <img src="' . htmlspecialchars($destination) . '" alt="Ảnh đã upload" style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                    </div>';
            } else {
                $uploadMessage = '<div class="message error">Upload thất bại!</div>';
            }
        }
    } else {
        $uploadMessage = '<div class="message error">Vui lòng chọn ảnh để upload!</div>';
    }
}

// Hàm định dạng byte
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

// Xử lý ghi file cho Bài 2
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['write_content'])) {
    $content = $_POST['content'] ?? '';
    
    if (!empty(trim($content))) {
        $filename = "note.txt";
        $timestamp = date('Y-m-d H:i:s');
        $separator = "\n" . str_repeat("=", 50) . "\n";
        $entry = "Thời gian: $timestamp\n" . "Nội dung:\n$content\n$separator";
        
        if ($handle = fopen($filename, 'a')) {
            fwrite($handle, $entry);
            fclose($handle);
            $writeMessage = '<div class="message success">Đã ghi nội dung vào file note.txt!</div>';
        } else {
            $writeMessage = '<div class="message error">Không thể ghi vào file!</div>';
        }
    } else {
        $writeMessage = '<div class="message error">Vui lòng nhập nội dung!</div>';
    }
}

// Xử lý xóa file note.txt
if (isset($_GET['clear_note'])) {
    if (file_exists("note.txt")) {
        file_put_contents("note.txt", "");
    }
    header("Location: " . str_replace("?clear_note=1", "", $_SERVER['REQUEST_URI']));
    exit;
}

// Tạo file data.txt nếu chưa tồn tại (cho Bài 1)
if (!file_exists("data.txt")) {
    file_put_contents("data.txt", "Đây là nội dung mẫu của file data.txt.\nFile này được sử dụng cho Bài 1: Đọc nội dung file.\nBạn có thể chỉnh sửa nội dung file này theo ý muốn.\n\nChúc các bạn học tập tốt môn Lập trình Web!");
}

// Tạo file header.php và footer.php cho Bài 5 nếu chưa tồn tại
if (!file_exists("header.php")) {
    file_put_contents("header.php", '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Bài tập PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; min-height: 400px; }
        .footer { background: #34495e; color: white; text-align: center; padding: 15px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Chào mừng đến với trang web PHP</h1>
        <p>Đây là phần header được include từ file header.php</p>
    </div>
    <div class="content">');
}

if (!file_exists("footer.php")) {
    file_put_contents("footer.php", '
    </div>
    <div class="footer">
        <p>&copy; 2023 - Bài thực hành Lập trình Web với PHP</p>
        <p>GVBM: Trần Thị Hà Khuê</p>
        <p>Sử dụng include và require trong PHP</p>
    </div>
</body>
</html>');
}

// Tạo file home.php cho Bài 5 nếu chưa tồn tại
if (!file_exists("home.php")) {
    file_put_contents("home.php", '<?php include "header.php"; ?>
<h2>Trang Chủ</h2>
<p>Đây là nội dung chính của trang home.php</p>
<p>Trang này sử dụng include để nhúng header và footer từ các file riêng biệt.</p>
<ul>
    <li>Header được include từ file header.php</li>
    <li>Footer được include từ file footer.php</li>
    <li>Trang này là home.php</li>
</ul>
<p>Đây là cách tổ chức code PHP chuyên nghiệp, dễ bảo trì và tái sử dụng.</p>
<?php include "footer.php"; ?>');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>6 Bài Tập Thực Hành PHP - Quản Lý File</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #dfe6e9 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .main-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 30px;
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .main-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .main-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Tabs */
        .tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .tab-btn {
            padding: 12px 25px;
            background: linear-gradient(to right, #4a6fa5, #6a93cb);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            min-width: 150px;
            justify-content: center;
        }
        
        .tab-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(74, 111, 165, 0.3);
        }
        
        .tab-btn.active {
            background: linear-gradient(to right, #2ecc71, #27ae60);
        }
        
        /* Tab content */
        .tab-content {
            display: none;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease;
        }
        
        .tab-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .tab-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        
        .tab-title i {
            color: #3498db;
            font-size: 1.5rem;
        }
        
        /* Common styles */
        .message {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            animation: fadeIn 0.5s ease;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        
        .file-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #3498db;
        }
        
        .file-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #eaeaea;
        }
        
        textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            resize: vertical;
            min-height: 150px;
            margin: 10px 0;
        }
        
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px 5px 10px 0;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-success {
            background: linear-gradient(to right, #2ecc71, #27ae60);
        }
        
        .btn-danger {
            background: linear-gradient(to right, #e74c3c, #c0392b);
        }
        
        .btn-warning {
            background: linear-gradient(to right, #f39c12, #e67e22);
        }
        
        .exercise-description {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 5px solid #ffc107;
        }
        
        /* Footer */
        footer {
            text-align: center;
            padding: 25px;
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: white;
            border-radius: 15px;
            margin-top: 30px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .tabs {
                flex-direction: column;
            }
            
            .tab-btn {
                width: 100%;
            }
            
            .main-header h1 {
                font-size: 2rem;
            }
        }
        
        /* Specific styles */
        .image-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }
        
        ul.file-lines {
            list-style-type: none;
            padding-left: 0;
        }
        
        ul.file-lines li {
            padding: 8px 15px;
            margin: 5px 0;
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            border-radius: 4px;
        }
        
        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
            overflow-x: auto;
        }
        
        .file-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        
        .file-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="main-header">
            <h1><i class="fas fa-file-code"></i> 6 Bài Tập Thực Hành PHP - Quản Lý File</h1>
            <p>Môn: Lập trình Web - GVBM: Trần Thị Hà Khuê</p>
        </header>
        
        <!-- Tabs Navigation -->
        <div class="tabs">
            <button class="tab-btn active" data-tab="tab1">
                <i class="fas fa-book-open"></i> Bài 1
            </button>
            <button class="tab-btn" data-tab="tab2">
                <i class="fas fa-edit"></i> Bài 2
            </button>
            <button class="tab-btn" data-tab="tab3">
                <i class="fas fa-list"></i> Bài 3
            </button>
            <button class="tab-btn" data-tab="tab4">
                <i class="fas fa-upload"></i> Bài 4
            </button>
            <button class="tab-btn" data-tab="tab5">
                <i class="fas fa-puzzle-piece"></i> Bài 5
            </button>
            <button class="tab-btn" data-tab="tab6">
                <i class="fas fa-image"></i> Bài 6
            </button>
        </div>
        
        <!-- Tab 1: Bài 1 - Đọc file -->
        <div class="tab-content active" id="tab1">
            <div class="tab-title">
                <i class="fas fa-book-open"></i>
                <h2>Bài 1: Đọc nội dung file</h2>
            </div>
            
            <div class="container">
        <header>
            <h1><i class="fas fa-file-code"></i> Đọc File với PHP</h1>
            <p class="subtitle">3 phương pháp đọc file khác nhau với giao diện web hiện đại</p>
        </header>
        
        <div class="methods-container">
            <!-- Cách 1: file_get_contents -->
            <div class="method-card method-1">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h2 class="card-title">Cách 1: file_get_contents()</h2>
                        <p class="card-subtitle">Đọc toàn bộ file một lần</p>
                    </div>
                </div>
                    
                    <div class="content-display">
                        <h4>Nội dung file:</h4>
                        <?php
                        // Cách 1: file_get_contents
                        $file1 = "nho.txt";
                        if (file_exists($file1)) {
                            $content = file_get_contents($file1);
                            echo nl2br($content);
                        } else {
                            echo "<p style='color: #e74c3c;'><i class='fas fa-exclamation-triangle'></i> File $file1 không tồn tại!</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <!-- Cách 2: fgets -->
            <div class="method-card method-2">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-stream"></i>
                    </div>
                    <div>
                        <h2 class="card-title">Cách 2: fgets()</h2>
                        <p class="card-subtitle">Đọc từng dòng với vòng lặp</p>
                    </div>
                </div>
                    
                    <div class="content-display">
                        <h4>Nội dung file từng dòng:</h4>
                        <?php
                        // Cách 2: fgets
                        $file2 = "vua.txt";
                        if (file_exists($file2)) {
                            $handle = fopen($file2, "r");
                            $lineNumber = 1;
                            while (!feof($handle)) {
                                $line = fgets($handle);
                                if (!empty(trim($line))) {
                                    echo "<p><span style='color:#27ae60; font-weight:bold;'>Dòng $lineNumber:</span> " . htmlspecialchars($line) . "</p>";
                                    $lineNumber++;
                                }
                            }
                            fclose($handle);
                        } else {
                            echo "<p style='color: #e74c3c;'><i class='fas fa-exclamation-triangle'></i> File $file2 không tồn tại!</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <!-- Cách 3: file() -->
            <div class="method-card method-3">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-list-ol"></i>
                    </div>
                    <div>
                        <h2 class="card-title">Cách 3: file()</h2>
                        <p class="card-subtitle">Đọc file thành mảng các dòng</p>
                    </div>
                </div>
                    
                    <div class="content-display">
                        <h4>Nội dung file theo mảng:</h4>
                        <?php
                        // Cách 3: file
                        $file3 = "nho.txt";
                        if (file_exists($file3)) {
                            $lines = file($file3);
                            if (!empty($lines)) {
                                echo "<ul style='padding-left: 20px;'>";
                                foreach ($lines as $index => $line) {
                                    if (!empty(trim($line))) {
                                        echo "<li><strong>Dòng " . ($index + 1) . ":</strong> " . htmlspecialchars($line) . "</li>";
                                    }
                                }
                                echo "</ul>";
                                echo "<p><strong>Tổng số dòng:</strong> " . count($lines) . "</p>";
                            } else {
                                echo "<p>File rỗng!</p>";
                            }
                        } else {
                            echo "<p style='color: #e74c3c;'><i class='fas fa-exclamation-triangle'></i> File $file3 không tồn tại!</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        
        <!-- Tab 2: Bài 2 - Ghi file -->
        <div class="tab-content" id="tab2">
            <div class="tab-title">
                <i class="fas fa-edit"></i>
                <h2>Bài 2: Ghi nội dung vào file</h2>
            </div>
            
            
            <?php if (isset($writeMessage)) echo $writeMessage; ?>
            
            <form method="POST" action="">
                <div class="file-info">
                    <p><i class="fas fa-info-circle"></i> <strong>File ghi:</strong> note.txt</p>
                    <p><i class="fas fa-exchange-alt"></i> <strong>Chế độ ghi:</strong> Ghi nối tiếp (append)</p>
                </div>
                
                <textarea name="content" placeholder="Nhập nội dung bạn muốn ghi vào file note.txt..."><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                
                <button type="submit" name="write_content" class="btn btn-success">
                    <i class="fas fa-save"></i> Ghi vào file
                </button>
                
                <?php if (file_exists("note.txt") && filesize("note.txt") > 0): ?>
                <a href="?clear_note=1" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ nội dung file note.txt?')">
                    <i class="fas fa-trash"></i> Xóa file
                </a>
                <?php endif; ?>
            </form>
            
            <div class="file-content">
                <h3><i class="fas fa-file-alt"></i> Nội dung hiện tại của note.txt:</h3>
                <?php
                if (file_exists("note.txt")) {
                    $noteContent = file_get_contents("note.txt");
                    if (!empty(trim($noteContent))) {
                        echo nl2br(htmlspecialchars($noteContent));
                    } else {
                        echo "<p style='color: #7f8c8d; font-style: italic;'>File đang trống. Hãy thêm nội dung đầu tiên!</p>";
                    }
                } else {
                    echo "<p style='color: #e74c3c;'>File note.txt chưa tồn tại. Nó sẽ được tạo khi bạn ghi lần đầu tiên.</p>";
                }
                ?>
            </div>
        </div>
        
        <!-- Tab 3: Bài 3 - Đọc từng dòng -->
        <div class="tab-content" id="tab3">
            <div class="tab-title">
                <i class="fas fa-list"></i>
                <h2>Bài 3: Đọc từng dòng trong file</h2>
            </div>

            <div class="file-content">
                <h3><i class="fas fa-list-ol"></i> Danh sách các dòng trong file note.txt:</h3>
                <?php
                if (file_exists("note.txt")) {
                    $lines = file("note.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    
                    if (!empty($lines)) {
                        echo '<ul class="file-lines">';
                        $lineCount = 0;
                        foreach ($lines as $index => $line) {
                            if (!empty(trim($line))) {
                                $lineCount++;
                                echo '<li><strong>Dòng ' . $lineCount . ':</strong> ' . htmlspecialchars($line) . '</li>';
                            }
                        }
                        echo '</ul>';
                        echo '<p><strong>Tổng số dòng:</strong> ' . $lineCount . '</p>';
                    } else {
                        echo "<p style='color: #7f8c8d; font-style: italic;'>File note.txt đang trống hoặc chỉ chứa dòng trống.</p>";
                        echo "<p>Hãy quay lại <strong>Bài 2</strong> để thêm nội dung vào file.</p>";
                    }
                } else {
                    echo "<p style='color: #e74c3c;'>File note.txt chưa tồn tại.</p>";
                    echo "<p>Hãy quay lại <strong>Bài 2</strong> để tạo và ghi nội dung vào file.</p>";
                }
                ?>
            </div>
            </div>
        </div>
        
        <!-- Tab 4: Bài 4 - Upload file -->
        <div class="tab-content" id="tab4">
            <div class="tab-title">
                <i class="fas fa-upload"></i>
                <h2>Bài 4: Upload file đơn giản</h2>
            </div>
            
            <?php echo $uploadMessage; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                
                <div class="file-info">
                    <label for="simple_file"><i class="fas fa-file"></i> Chọn file để upload:</label>
                    <input type="file" name="simple_file" id="simple_file" required style="padding: 10px; border: 2px dashed #3498db; border-radius: 8px; width: 100%; margin: 10px 0;">
                </div>
                
                <button type="submit" name="upload_simple" class="btn btn-success">
                    <i class="fas fa-upload"></i> Upload File
                </button>
            </form>
            
            <?php echo $fileInfo; ?>
            </div>
        </div>
        
        <!-- Tab 5: Bài 5 - Include -->
        <div class="tab-content" id="tab5">
            <div class="tab-title">
                <i class="fas fa-puzzle-piece"></i>
                <h2>Bài 5: Include header - footer</h2>
            </div>
            
            <div class="file-info">
                <p><i class="fas fa-info-circle"></i> <strong>File được tạo tự động:</strong></p>
                <div class="file-list">
                    <div class="file-item">header.php</div>
                    <div class="file-item">footer.php</div>
                    <div class="file-item">home.php</div>
                </div>
            </div>
            
            <div class="file-content">
                <h3><i class="fas fa-eye"></i> Xem trước trang home.php:</h3>
                <iframe src="home.php" style="width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 8px;"></iframe>
            </div>            
    
        </div>
        
        <!-- Tab 6: Bài 6 - Upload ảnh -->
        <div class="tab-content" id="tab6">
            <div class="tab-title">
                <i class="fas fa-image"></i>
                <h2>Bài 6: Upload ảnh + kiểm tra định dạng</h2>
            </div>
            
            <div class="exercise-description">
                <p><strong>Yêu cầu:</strong></p>
                <ul>
                    <li>Chỉ cho phép JPG hoặc PNG</li>
                    <li>Giới hạn dung lượng dưới 2MB</li>
                    <li>Upload xong hiển thị ảnh</li>
                </ul>
            </div>
            
            <?php echo $uploadMessage; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="file-info">
                    <p><i class="fas fa-info-circle"></i> <strong>Giới hạn:</strong> Chỉ nhận file JPG/PNG, dung lượng ≤ 2MB</p>
                </div>
                
                <div class="file-info">
                    <label for="image_file"><i class="fas fa-image"></i> Chọn ảnh để upload (JPG/PNG, max 2MB):</label>
                    <input type="file" name="image_file" id="image_file" accept=".jpg,.jpeg,.png" required style="padding: 10px; border: 2px dashed #2ecc71; border-radius: 8px; width: 100%; margin: 10px 0;">
                </div>
                
                <button type="submit" name="upload_image" class="btn btn-success">
                    <i class="fas fa-upload"></i> Upload Ảnh
                </button>
            </form>
            
            <?php echo $fileInfo; ?>
            
            </div>
            
            <div class="file-info">
                <h4><i class="fas fa-folder-open"></i> File đã upload:</h4>
                <?php
                $uploadDir = 'uploads/';
                if (is_dir($uploadDir)) {
                    $files = scandir($uploadDir);
                    $imageFiles = array_filter($files, function($file) {
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        return in_array($ext, ['jpg', 'jpeg', 'png']) && $file !== '.' && $file !== '..';
                    });
                    
                    if (!empty($imageFiles)) {
                        echo '<div class="file-list">';
                        foreach ($imageFiles as $file) {
                            echo '<div class="file-item">';
                            echo '<img src="' . $uploadDir . $file . '" alt="' . $file . '" style="width: 100%; height: 100px; object-fit: cover; border-radius: 5px; margin-bottom: 5px;">';
                            echo '<p style="font-size: 0.9rem; text-align: center; word-break: break-all;">' . htmlspecialchars($file) . '</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<p style="color: #7f8c8d; font-style: italic;">Chưa có ảnh nào được upload.</p>';
                    }
                }
                ?>
            </div>
        </div>

         <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            // Show first tab by default
            document.getElementById('tab1').classList.add('active');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    
                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Check if there's a message and scroll to it
            const messages = document.querySelectorAll('.message');
            if (messages.length > 0) {
                messages[messages.length - 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
                
                // Trigger once on load
                textarea.dispatchEvent(new Event('input'));
            });
        });
    </script>
    </x`div>
</body>
</html>