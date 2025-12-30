<?php
session_start();
require_once 'database.php';
require_once 'functions.php';

$conn = connectDB();

// Kiểm tra ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: students.php");
    exit();
}

$student_id = intval($_GET['id']);
$student = getStudentById($conn, $student_id);

if (!$student) {
    showMessage("Sinh viên không tồn tại!", "danger");
    header("Location: students.php");
    exit();
}

// Xóa sinh viên
$sql = "DELETE FROM sinhvien WHERE ID_SV = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $student_id);

if (mysqli_stmt_execute($stmt)) {
    showMessage("Xóa sinh viên thành công!", "success");
} else {
    showMessage("Lỗi khi xóa sinh viên: " . mysqli_error($conn), "danger");
}

closeDB($conn);
header("Location: students.php");
exit();
?>
