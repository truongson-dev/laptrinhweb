<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();

// Kiểm tra ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: subjects.php");
    exit();
}

$subject_id = intval($_GET['id']);
$subject = getSubjectById($conn, $subject_id);

if (!$subject) {
    showMessage("Môn học không tồn tại!", "danger");
    header("Location: subjects.php");
    exit();
}

// Kiểm tra xem có sinh viên nào đăng ký môn này không
$sql_check = "SELECT COUNT(*) as count FROM sinhvien WHERE ID_MH = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "i", $subject_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$row = mysqli_fetch_assoc($result_check);

if ($row['count'] > 0) {
    showMessage("Không thể xóa môn học có sinh viên đăng ký!", "danger");
    closeDB($conn);
    header("Location: subjects.php");
    exit();
}

// Xóa môn học
$sql = "DELETE FROM monhoc WHERE ID_MH = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $subject_id);

if (mysqli_stmt_execute($stmt)) {
    showMessage("Xóa môn học thành công!", "success");
} else {
    showMessage("Lỗi khi xóa môn học: " . mysqli_error($conn), "danger");
}

closeDB($conn);
header("Location: subjects.php");
exit();
?>
