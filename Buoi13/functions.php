<?php
// Hàm hiển thị thông báo
function showMessage($message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

// Hàm lấy danh sách sinh viên
function getAllStudents($conn) {
    $sql = "SELECT s.*, m.ten_MH 
            FROM sinhvien s 
            LEFT JOIN monhoc m ON s.ID_MH = m.ID_MH 
            ORDER BY s.ID_SV DESC";
    $result = mysqli_query($conn, $sql);
    
    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
    
    return $students;
}

// Hàm lấy danh sách môn học
function getAllSubjects($conn) {
    $sql = "SELECT m.*, COUNT(s.ID_SV) as so_sv 
            FROM monhoc m 
            LEFT JOIN sinhvien s ON m.ID_MH = s.ID_MH 
            GROUP BY m.ID_MH 
            ORDER BY m.ID_MH DESC";
    $result = mysqli_query($conn, $sql);
    
    $subjects = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subjects[] = $row;
    }
    
    return $subjects;
}

// Hàm lấy thông tin sinh viên theo ID
function getStudentById($conn, $id) {
    $sql = "SELECT * FROM sinhvien WHERE ID_SV = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

// Hàm lấy thông tin môn học theo ID
function getSubjectById($conn, $id) {
    $sql = "SELECT * FROM monhoc WHERE ID_MH = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

// Hàm tìm kiếm sinh viên
function searchStudents($conn, $keyword) {
    $sql = "SELECT s.*, m.ten_MH 
            FROM sinhvien s 
            LEFT JOIN monhoc m ON s.ID_MH = m.ID_MH 
            WHERE s.tenSV LIKE ? OR s.lop LIKE ? OR m.ten_MH LIKE ?
            ORDER BY s.ID_SV DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    $searchTerm = "%" . $keyword . "%";
    mysqli_stmt_bind_param($stmt, "sss", $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
    
    return $students;
}
?>