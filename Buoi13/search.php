<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();
$students = [];
$search_term = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search'])) {
    $search_term = $_POST['search'];
    $students = searchStudents($conn, $search_term);
}

closeDB($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><i class="fas fa-search"></i> UpStudy</h1>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li><a href="students.php"><i class="fas fa-users"></i> Sinh viên</a></li>
                    <li><a href="subjects.php"><i class="fas fa-book"></i> Môn học</a></li>
                    <li><a href="search.php" class="active"><i class="fas fa-search"></i> Tìm kiếm</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-search"></i> Tìm kiếm sinh viên hoặc môn học</h2>
            </div>

            <form method="POST" action="" class="search-box">
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Nhập tên sinh viên, lớp hoặc tên môn học..." 
                           value="<?php echo htmlspecialchars($search_term); ?>" style="flex: 1; min-width: 300px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <div style="margin: 1rem 0;">
                    <p>Kết quả tìm kiếm cho: <strong><?php echo htmlspecialchars($search_term); ?></strong> 
                    (<?php echo count($students); ?> kết quả)</p>
                </div>

                <?php if (!empty($students)): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sinh viên</th>
                                <th>Lớp</th>
                                <th>Môn học</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($students as $student): ?>
                            <tr>
                                <td><?php echo $student['ID_SV']; ?></td>
                                <td><?php echo htmlspecialchars($student['tenSV']); ?></td>
                                <td><?php echo htmlspecialchars($student['lop']); ?></td>
                                <td>
                                    <?php if ($student['ten_MH']): ?>
                                        <span class="badge"><?php echo htmlspecialchars($student['ten_MH']); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Chưa đăng ký</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions">
                                    <a href="edit_student.php?id=<?php echo $student['ID_SV']; ?>" 
                                       class="btn btn-primary btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_student.php?id=<?php echo $student['ID_SV']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       title="Xóa"
                                       onclick="return confirmDelete('Xóa sinh viên <?php echo htmlspecialchars($student['tenSV']); ?>?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> Không tìm thấy kết quả nào!
                </div>
                <?php endif; ?>
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
