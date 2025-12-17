<!DOCTYPE html>
<html>
<head>
    <title>Thêm sinh viên</title>
</head>
<body>
    <h2>THÔNG TIN SINH VIÊN</h2>
    <form action="insertList.php" method="POST">
        <label for="id_sinhvien">Mã sinh viên</label><br>
        <input type="number" id="id_sinhvien" name="id_sinhvien" required><br><br>
        <!-- SỬA: id="id_sinhvien" thay vì id="IDSV" -->
        
        <label for="hoten">Họ tên sinh viên</label><br>
        <input type="text" id="hoten" name="hoten" required><br><br>
        
        <label for="lop">Lớp</label><br>
        <input type="text" id="lop" name="lop" required><br><br>
        
        <input type="submit" value="Thêm">
    </form>
    
    <br>
    <a href="insertList.php">Xem danh sách sinh viên</a>
</body>
</html>