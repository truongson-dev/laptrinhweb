<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();

// Lấy danh sách môn học
$sql_subjects = "SELECT * FROM monhoc ORDER BY ten_MH";
$result_subjects = mysqli_query($conn, $sql_subjects);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenSV = isset($_POST['tenSV']) ? $_POST['tenSV'] : '';
    $lop = isset($_POST['lop']) ? $_POST['lop'] : '';
    $ID_MH = !empty($_POST['ID_MH']) ? intval($_POST['ID_MH']) : null;
    
    // Kiểm tra dữ liệu
    if (empty($tenSV) || empty($lop)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Thêm sinh viên với Prepared Statement
        if ($ID_MH) {
            $sql = "INSERT INTO sinhvien (tenSV, lop, ID_MH) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $tenSV, $lop, $ID_MH);
        } else {
            $sql = "INSERT INTO sinhvien (tenSV, lop) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $tenSV, $lop);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            showMessage("Thêm sinh viên thành công!", "success");
            header("Location: students.php");
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
    <title>Thêm sinh viên</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><i class="fas fa-user-plus"></i> UpStudy</h1>
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
                <h2><i class="fas fa-user-plus"></i> Thông tin sinh viên</h2>
                <a href="students.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="tenSV"><i class="fas fa-user"></i> Tên sinh viên *</label>
                    <input type="text" id="tenSV" name="tenSV" class="form-control" 
                           placeholder="Nhập tên sinh viên" required>
                </div>

                <div class="form-group">
                    <label for="lop"><i class="fas fa-school"></i> Lớp *</label>
                    <input type="text" id="lop" name="lop" class="form-control" 
                           placeholder="Ví dụ: CTK44, CTK45" required>
                </div>

                <div class="form-group">
                    <label for="ID_MH"><i class="fas fa-book"></i> Môn học (tùy chọn)</label>
                    <select id="ID_MH" name="ID_MH" class="form-control">
                        <option value="">-- Chọn môn học --</option>
                        <?php while($subject = mysqli_fetch_assoc($result_subjects)): ?>
                            <option value="<?php echo $subject['ID_MH']; ?>">
                                <?php echo htmlspecialchars($subject['ten_MH']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="text-muted">Có thể để trống và cập nhật sau</small>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu thông tin
                    </button>
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-redo"></i> Nhập lại
                    </button>
                    <a href="students.php" class="btn btn-primary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> UpStudy - Quản lý Sinh viên và Môn học</p>
        <p>Hệ thống quản lý thông tin sinh viên hiệu quả</p>
    </footer>
</body>
</html>