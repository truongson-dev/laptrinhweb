<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();

$error = '';
$subject = null;

// Lấy thông tin môn học
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: subjects.php");
    exit();
}

$subject_id = intval($_GET['id']);
$subject = getSubjectById($conn, $subject_id);

if (!$subject) {
    $error = "Môn học không tồn tại!";
}

// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error) {
    $tenMH = isset($_POST['tenMH']) ? $_POST['tenMH'] : '';
    $sotinchi = isset($_POST['sotinchi']) ? intval($_POST['sotinchi']) : 0;
    
    // Kiểm tra dữ liệu
    if (empty($tenMH) || $sotinchi <= 0) {
        $error = "Vui lòng nhập đầy đủ thông tin hợp lệ!";
    } else {
        // Cập nhật môn học
        $sql = "UPDATE monhoc SET ten_MH = ?, sotinchi = ? WHERE ID_MH = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $tenMH, $sotinchi, $subject_id);
        
        if (mysqli_stmt_execute($stmt)) {
            showMessage("Cập nhật môn học thành công!", "success");
            header("Location: subjects.php");
            exit();
        } else {
            $error = "Lỗi: " . mysqli_error($conn);
        }
    }
}

closeDB($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa môn học</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><i class="fas fa-book-open"></i> UpStudy</h1>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li><a href="students.php"><i class="fas fa-users"></i> Sinh viên</a></li>
                    <li><a href="subjects.php"><i class="fas fa-book"></i> Môn học</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-book-open"></i> Chỉnh sửa thông tin môn học</h2>
                <a href="subjects.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($subject): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="tenMH"><i class="fas fa-book"></i> Tên môn học *</label>
                    <input type="text" id="tenMH" name="tenMH" class="form-control" 
                           placeholder="Nhập tên môn học" value="<?php echo htmlspecialchars($subject['ten_MH']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="sotinchi"><i class="fas fa-credit-card"></i> Số tín chỉ *</label>
                    <input type="number" id="sotinchi" name="sotinchi" class="form-control" 
                           placeholder="Nhập số tín chỉ" min="1" value="<?php echo $subject['sotinchi']; ?>" required>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-redo"></i> Nhập lại
                    </button>
                    <a href="subjects.php" class="btn btn-primary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> UpStudy - Quản lý Sinh viên và Môn học</p>
        <p>Hệ thống quản lý thông tin sinh viên hiệu quả</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>
