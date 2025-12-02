<?php
session_start();

// Khởi tạo mảng màu trong session nếu chưa tồn tại
if (!isset($_SESSION['colors'])) {
    $_SESSION['colors'] = ['red', 'green', 'blue', 'yellow', 'purple'];
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý thêm màu mới
    if (isset($_POST['new_color']) && !empty(trim($_POST['new_color']))) {
        $newColor = trim($_POST['new_color']);
        $_SESSION['colors'][] = $newColor;
        $addMessage = "Đã thêm màu: <strong>$newColor</strong>";
    }
    
    // Xử lý xóa màu theo vị trí
    if (isset($_POST['delete_index']) && !empty(trim($_POST['delete_index']))) {
        $deleteIndex = trim($_POST['delete_index']);
        
        // Kiểm tra xem chỉ số có hợp lệ không
        if (is_numeric($deleteIndex) && isset($_SESSION['colors'][$deleteIndex])) {
            $removedColor = $_SESSION['colors'][$deleteIndex];
            unset($_SESSION['colors'][$deleteIndex]);
            
            // Reset lại chỉ số mảng
            $_SESSION['colors'] = array_values($_SESSION['colors']);
            $deleteMessage = "Đã xóa màu ở vị trí $deleteIndex: <strong>$removedColor</strong>";
        } else {
            $deleteMessage = "Vị trí $deleteIndex không hợp lệ!";
        }
    }
    
    // Xử lý reset mảng - SỬA ĐỔI Ở ĐÂY
    if (isset($_POST['reset'])) {
        $_SESSION['colors'] = []; // Reset mảng thành mảng rỗng
        $resetMessage = "Đã xóa tất cả màu trong mảng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 2: Quản lý mảng màu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 900px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card h2 {
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card h2 i {
            color: #764ba2;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus {
            border-color: #667eea;
            outline: none;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-reset {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            margin-top: 20px;
        }
        
        .btn-reset:hover {
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }
        
        .message {
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-weight: 500;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }
        
        .warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 5px solid #ffc107;
        }
        
        .array-display {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-top: 20px;
            border: 2px dashed #dee2e6;
        }
        
        .array-title {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .color-items {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 15px;
        }
        
        .color-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: white;
            border-radius: 50px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            font-weight: 500;
        }
        
        .color-index {
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: bold;
        }
        
        .color-preview {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #eee;
        }
        
        .info-box {
            background: #e7f3ff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            border-left: 5px solid #2196f3;
        }
        
        .info-box h3 {
            color: #2196f3;
            margin-bottom: 10px;
        }
        
        .empty-array {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-palette"></i> Quản lý mảng màu sắc</h1>
            <p class="subtitle">Thêm màu mới vào mảng hoặc xóa màu theo vị trí chỉ định</p>
        </header>
        
        <div class="main-content">
            <!-- Cột trái: Form thao tác -->
            <div class="card">
                <h2><i class="fas fa-plus-circle"></i> Thêm màu mới</h2>
                
                <?php if (isset($addMessage)): ?>
                    <div class="message success"><?php echo $addMessage; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="new_color"><i class="fas fa-fill-drip"></i> Nhập tên màu mới:</label>
                        <input type="text" id="new_color" name="new_color" 
                               placeholder="Ví dụ: orange, pink, brown, cyan..." required>
                    </div>
                    <button type="submit" class="btn" name="add">
                        <i class="fas fa-plus"></i> Thêm vào cuối mảng
                    </button>
                </form>
                
                <h2 style="margin-top: 40px;"><i class="fas fa-trash-alt"></i> Xóa màu theo vị trí</h2>
                
                <?php if (isset($deleteMessage)): ?>
                    <div class="message <?php echo strpos($deleteMessage, 'không hợp lệ') !== false ? 'warning' : 'success'; ?>">
                        <?php echo $deleteMessage; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="delete_index"><i class="fas fa-list-ol"></i> Nhập vị trí cần xóa (0 - <?php echo count($_SESSION['colors']) - 1; ?>):</label>
                        <input type="text" id="delete_index" name="delete_index" 
                               placeholder="Ví dụ: 0, 1, 2..." required>
                    </div>
                    <button type="submit" class="btn" name="delete">
                        <i class="fas fa-trash"></i> Xóa màu tại vị trí này
                    </button>
                </form>
                
                <form method="POST" action="">
                    <button type="submit" class="btn btn-reset" name="reset">
                        <i class="fas fa-redo"></i> Xóa tất cả màu
                    </button>
                </form>
                
                <?php if (isset($resetMessage)): ?>
                    <div class="message success"><?php echo $resetMessage; ?></div>
                <?php endif; ?>
            </div>
            
            <!-- Cột phải: Hiển thị mảng -->
            <div class="card">
                <h2><i class="fas fa-list"></i> Mảng màu hiện tại</h2>
                
                <?php if (empty($_SESSION['colors'])): ?>
                    <div class="empty-array">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; color: #ccc;"></i>
                        <p>Mảng màu đang trống!</p>
                        <p>Hãy thêm màu mới vào mảng.</p>
                    </div>
                <?php else: ?>
                    <div class="array-title" style="margin-top: 25px;">
                        <i class="fas fa-th-large"></i> Hiển thị trực quan:
                    </div>
                    
                    <div class="color-items">
                        <?php foreach ($_SESSION['colors'] as $index => $color): ?>
                            <div class="color-item">
                                <div class="color-index"><?php echo $index; ?></div>
                                <div class="color-preview" style="background-color: <?php echo $color; ?>;"></div>
                                <span><?php echo ucfirst($color); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                    
                <div style="margin-top: 25px; padding: 15px; background: #f0f8ff; border-radius: 10px;">
                    <p><strong><i class="fas fa-info-circle"></i> Thông tin mảng:</strong></p>
                    <p>Tổng số màu: <strong><?php echo count($_SESSION['colors']); ?></strong></p>
                    <?php if (!empty($_SESSION['colors'])): ?>
                        <p>Chỉ số từ: <strong>0</strong> đến <strong><?php echo count($_SESSION['colors']) - 1; ?></strong></p>
                    <?php else: ?>
                        <p>Chỉ số: <strong>Không có phần tử</strong></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <footer>
            <p>Bài tập 2 - Lập trình Web với PHP | Mảng trong PHP</p>
            <p>Chức năng đã sử dụng: array_values(), unset(), array push ([]), session</p>
        </footer>
    </div>
    
    <script>
        // Focus vào ô input đầu tiên
        document.getElementById('new_color').focus();
        
        // Cập nhật placeholder cho ô xóa
        const deleteInput = document.getElementById('delete_index');
        const colorCount = <?php echo count($_SESSION['colors']); ?>;
        
        // Kiểm tra nếu mảng không rỗng thì cập nhật placeholder
        if (colorCount > 0) {
            deleteInput.placeholder = `Nhập từ 0 đến ${colorCount - 1}`;
        } else {
            deleteInput.placeholder = "Mảng đang trống, không có gì để xóa";
            deleteInput.disabled = true;
            document.querySelector('button[name="delete"]').disabled = true;
        }
        
        // Validate ô nhập vị trí xóa
        document.querySelector('form[name="delete"]').addEventListener('submit', function(e) {
            const value = deleteInput.value.trim();
            if (colorCount <= 0) {
                alert("Mảng đang trống, không có gì để xóa!");
                e.preventDefault();
                return;
            }
            
            if (value === '' || isNaN(value) || value < 0 || value >= colorCount) {
                alert(`Vui lòng nhập vị trí hợp lệ từ 0 đến ${colorCount - 1}`);
                e.preventDefault();
                deleteInput.focus();
            }
        });
    </script>
</body>
</html>