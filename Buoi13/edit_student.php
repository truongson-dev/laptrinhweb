<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();
$error = '';
$success = '';
$student = null;

// Lấy thông tin sinh viên
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: students.php");
    exit();
}

$student_id = intval($_GET['id']);
$student = getStudentById($conn, $student_id);

if (!$student) {
    $error = "Sinh viên không tồn tại!";
}

// Lấy danh sách môn học
$sql_subjects = "SELECT * FROM monhoc ORDER BY ten_MH";
$result_subjects = mysqli_query($conn, $sql_subjects);

// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error) {
    $tenSV = isset($_POST['tenSV']) ? $_POST['tenSV'] : '';
    $lop = isset($_POST['lop']) ? $_POST['lop'] : '';
    $ID_MH = !empty($_POST['ID_MH']) ? intval($_POST['ID_MH']) : null;
    
    // Kiểm tra dữ liệu
    if (empty($tenSV) || empty($lop)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Cập nhật sinh viên
        if ($ID_MH) {
            $sql = "UPDATE sinhvien SET tenSV = ?, lop = ?, ID_MH = ? WHERE ID_SV = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssii", $tenSV, $lop, $ID_MH, $student_id);
        } else {
            $sql = "UPDATE sinhvien SET tenSV = ?, lop = ?, ID_MH = NULL WHERE ID_SV = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $tenSV, $lop, $student_id);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            showMessage("Cập nhật sinh viên thành công!", "success");
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
    <title>Chỉnh sửa sinh viên</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><i class="fas fa-user-edit"></i> UpStudy</h1>
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
                <h2><i class="fas fa-user-edit"></i> Chỉnh sửa thông tin sinh viên</h2>
                <a href="students.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($student): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="tenSV"><i class="fas fa-user"></i> Tên sinh viên *</label>
                    <input type="text" id="tenSV" name="tenSV" class="form-control" 
                           placeholder="Nhập tên sinh viên" value="<?php echo htmlspecialchars($student['tenSV']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="lop"><i class="fas fa-school"></i> Lớp *</label>
                    <input type="text" id="lop" name="lop" class="form-control" 
                           placeholder="Ví dụ: CTK44, CTK45" value="<?php echo htmlspecialchars($student['lop']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="ID_MH"><i class="fas fa-book"></i> Môn học (tùy chọn)</label>
                    <select id="ID_MH" name="ID_MH" class="form-control">
                        <option value="">-- Chọn môn học --</option>
                        <?php while($subject = mysqli_fetch_assoc($result_subjects)): ?>
                            <option value="<?php echo $subject['ID_MH']; ?>" 
                                <?php echo ($student['ID_MH'] == $subject['ID_MH']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($subject['ten_MH']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="text-muted">Có thể để trống nếu không cần</small>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-redo"></i> Nhập lại
                    </button>
                    <a href="students.php" class="btn btn-primary">
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
