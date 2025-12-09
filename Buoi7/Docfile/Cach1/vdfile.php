<?php
$content = file_get_contents("vdfile.txt");
// in ra nội dung file
echo "<h3>Nội dung file: </h3>";
echo nl2br($content);
?>