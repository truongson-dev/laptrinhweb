<?php
session_start();

// Kiểm tra nếu chưa có tên trong session
if (!isset($_SESSION['name'])) {
    header('Location: index.php');
    exit();
}

$name = $_SESSION['name'];
$time = $_SESSION['time'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bài 1 - Kết quả</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 50px;
            background: #4CAF50;
            color: white;
        }
        .result-box {
            display: inline-block;
            padding: 40px;
            background: white;
            color: #333;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        .greeting {
            font-size: 24px;
            margin: 20px 0;
        }
        .name {
            color: #4CAF50;
            font-weight: bold;
        }
        .time {
            color: #666;
            font-size: 14px;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-logout {
            background: #f44336;
        }
    </style>
</head>
<body>
    <div class="result-box">
        <h2>Kết quả</h2>
        <div class="greeting">
            Xin chào, <span class="name"><?php echo $name; ?></span>!
        </div>
        <div class="time">
            Thời gian: <?php echo $time; ?>
        </div>
        <div>
            <a href="index.php" class="btn">Trang chủ</a>
            <a href="result.php?action=logout" class="btn btn-logout">Đăng xuất</a>
        </div>
    </div>
    
    <?php
    // Xử lý đăng xuất
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    ?>
</body>
</html>