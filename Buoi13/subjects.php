<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();
$subjects = getAllSubjects($conn);
closeDB($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Môn học</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><i class="fas fa-book"></i> UpStudy</h1>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li><a href="students.php"><i class="fas fa-users"></i> Sinh viên</a></li>
                    <li><a href="subjects.php" class="active"><i class="fas fa-book"></i> Môn học</a></li>
                    <li><a href="search.php"><i class="fas fa-search"></i> Tìm kiếm</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-list"></i> Danh sách môn học</h2>
                <div>
                    <a href="add_subject.php" class="btn btn-success"><i class="fas fa-plus"></i> Thêm môn học</a>
                    <a href="index.php" class="btn btn-primary"><i class="fas fa-home"></i> Trang chủ</a>
                </div>
            </div>

            <div class="search-box">
                <input type="text" class="form-control" placeholder="Tìm kiếm môn học...">
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên môn học</th>
                            <th>Số tín chỉ</th>
                            <th>Số sinh viên</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($subjects)): ?>
                            <?php foreach($subjects as $subject): ?>
                            <tr>
                                <td><?php echo $subject['ID_MH']; ?></td>
                                <td><?php echo htmlspecialchars($subject['ten_MH']); ?></td>
                                <td><?php echo isset($subject['sotinchi']) ? $subject['sotinchi'] : 0; ?></td>
                                <td>
                                    <span class="badge"><?php echo $subject['so_sv']; ?> sinh viên</span>
                                </td>
                                <td class="actions">
                                    <a href="edit_subject.php?id=<?php echo $subject['ID_MH']; ?>" 
                                       class="btn btn-primary btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_subject.php?id=<?php echo $subject['ID_MH']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       title="Xóa"
                                       onclick="return confirmDelete('Xóa môn học <?php echo htmlspecialchars($subject['ten_MH']); ?>?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">
                                    Chưa có môn học nào. <a href="add_subject.php">Thêm môn học</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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