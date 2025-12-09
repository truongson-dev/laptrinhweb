<?php
// Cách 3: Đọc file thành mảng các dòng
$lines = file("vd3file.txt");
echo "<h3>Danh sách các dòng trong file:</h3>";
foreach ($lines as $index => $line) {
echo "Dòng " . ($index + 1) . ": " . $line . "<br>";
}
?>
