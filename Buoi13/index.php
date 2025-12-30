<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();

// Lấy số liệu thống kê
$sql_students = "SELECT COUNT(*) as total FROM sinhvien";
$result_students = mysqli_query($conn, $sql_students);
$total_students = mysqli_fetch_assoc($result_students)['total'];

$sql_subjects = "SELECT COUNT(*) as total FROM monhoc";
$result_subjects = mysqli_query($conn, $sql_subjects);
$total_subjects = mysqli_fetch_assoc($result_subjects)['total'];

// Lấy danh sách sinh viên mới nhất
$sql_new_students = "SELECT s.*, m.ten_MH 
                     FROM sinhvien s 
                     LEFT JOIN monhoc m ON s.ID_MH = m.ID_MH 
                     ORDER BY s.ID_SV DESC LIMIT 5";
$new_students = mysqli_query($conn, $sql_new_students);

closeDB($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh viên & Môn học</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><i class="fas fa-graduation-cap"></i> UpStudy</h1>
            <nav>
                <ul>
                    <li><a href="index.php" class="active"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li><a href="students.php"><i class="fas fa-users"></i> Sinh viên</a></li>
                    <li><a href="subjects.php"><i class="fas fa-book"></i> Môn học</a></li>
                    <li><a href="search.php"><i class="fas fa-search"></i> Tìm kiếm</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h2>Best to Platform Empower Skills</h2>
                <p>Quản lý sinh viên và môn học một cách hiệu quả. Tổ chức thông tin học tập của bạn ngay hôm nay!</p>
                <a href="students.php" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> Bắt đầu ngay
                </a>
            </div>
            <div class="hero-image">
                <i class="fas fa-users fa-10x" style="color: #14b8a6; opacity: 0.3;"></i>
            </div>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Top Categories -->
        <div style="margin-bottom: 3rem;">
            <h2 style="text-align: center; color: #1e3c72; font-size: 2rem; margin-bottom: 2rem;">
                <span style="position: relative; display: inline-block;">
                    Top Categories
                    <span style="position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); width: 100px; height: 3px; background: linear-gradient(90deg, #fbbf24, #14b8a6); border-radius: 2px;"></span>
                </span>
            </h2>
            <div class="categories">
                <div class="category-card cat-1">
                    <i class="fas fa-book fa-2x"></i>
                    <h4>Quản lý Môn học</h4>
                </div>
                <div class="category-card cat-2">
                    <i class="fas fa-users fa-2x"></i>
                    <h4>Quản lý Sinh viên</h4>
                </div>
                <div class="category-card cat-3">
                    <i class="fas fa-search fa-2x"></i>
                    <h4>Tìm kiếm Nâng cao</h4>
                </div>
                <div class="category-card cat-4">
                    <i class="fas fa-chart-bar fa-2x"></i>
                    <h4>Thống kê</h4>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo $total_students; ?></h3>
                <p>Tổng số sinh viên</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-book"></i>
                <h3><?php echo $total_subjects; ?></h3>
                <p>Tổng số môn học</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-chart-bar"></i>
                <h3><?php echo $total_subjects > 0 ? ceil($total_students / $total_subjects) : 0; ?></h3>
                <p>SV trung bình/môn</p>
            </div>
        </div>

        <!-- Popular Courses Section -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-star"></i> Sinh viên mới nhất</h2>
                <div>
                    <a href="add_student.php" class="btn btn-success"><i class="fas fa-plus"></i> Thêm SV</a>
                    <a href="add_subject.php" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm MH</a>
                </div>
            </div>
            
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
                        <?php if (mysqli_num_rows($new_students) > 0): ?>
                            <?php while($student = mysqli_fetch_assoc($new_students)): ?>
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
                                    <a href="edit_student.php?id=<?php echo $student['ID_SV']; ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_student.php?id=<?php echo $student['ID_SV']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirmDelete('Xóa sinh viên này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">
                                    Chưa có sinh viên nào. <a href="add_student.php">Thêm sinh viên</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-bolt"></i> Chức năng nhanh</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem;">
                <a href="add_student.php" class="btn btn-success" style="justify-content: center;">
                    <i class="fas fa-user-plus"></i> Thêm Sinh viên
                </a>
                <a href="add_subject.php" class="btn btn-success" style="justify-content: center;">
                    <i class="fas fa-book-medical"></i> Thêm Môn học
                </a>
                <a href="students.php" class="btn btn-primary" style="justify-content: center;">
                    <i class="fas fa-list"></i> DS Sinh viên
                </a>
                <a href="subjects.php" class="btn btn-primary" style="justify-content: center;">
                    <i class="fas fa-list"></i> DS Môn học
                </a>
                <a href="search.php" class="btn btn-warning" style="justify-content: center;">
                    <i class="fas fa-search"></i> Tìm kiếm
                </a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> UpStudy - Quản lý Sinh viên và Môn học</p>
        <p>Hệ thống quản lý thông tin sinh viên hiệu quả</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>