<?php
// Cách 2: Đọc từng dòng bằng fgets()
$handle = fopen("vd2file.txt", "r"); // mở file để đọc
echo "<h3>Đọc từng dòng:</h3>";
while (!feof($handle)) {
$line = fgets($handle);
echo $line. "<br>";
}
fclose($handle); // đóng file
?>
