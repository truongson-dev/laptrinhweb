<!-- Tạo form upload -->
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="myfile">
<button type="submit">Upload</button>
</form>

<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["myfile"]["name"]);
if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
echo "Upload thành công!";
} else {
echo "Upload thất bại!";
}
?>