<?php
// Ghi bằng fwrite()
// $handle = fopen("vdfile.txt", "a");
// fwrite($handle, "Dòng mới\n");
// fclose($handle);
// Ghi nhanh – file_put_contents()
file_put_contents("log.txt", "Nội dung mới", FILE_APPEND);
// Đóng file – fclose()
fclose($handle);
?>