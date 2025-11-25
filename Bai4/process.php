  
    <?php
    // Xác định phương thức và lấy dữ liệu
    $method = $_SERVER['REQUEST_METHOD'];
    
    if ($method === 'GET') {
        $data = $_GET['data'] ?? '';
    } else if ($method === 'POST') {
        $data = $_POST['data'] ?? '';
    } else {
        $data = '';
    }
    
    // Loại bỏ khoảng trắng thừa
    $data = trim($data);
    ?>

    <div>
        <h3>Thông tin phương thức:</h3>
        <p><strong>Phương thức nhận được:</strong> <?php echo $method; ?></p>
        <p><strong>Dữ liệu nhận được:</strong> "<?php echo htmlspecialchars($data); ?>"</p>
    </div>

    <?php
    // Kiểm tra và hiển thị kết quả
    if (empty($data)) {
        echo '<div>';
        echo '<h3>Lỗi!</h3>';
        echo '<p>Vui lòng không để trống dữ liệu.</p>';
        echo '</div>';
    } else {
        echo '<div>';
        echo '<h3>Thành công!</h3>';
        echo '<p>Bạn đã gửi dữ liệu bằng <strong>' . $method . '</strong>: <strong>' . htmlspecialchars($data) . '</strong></p>';
        echo '</div>';
    }
    ?>

    <br>
    <a href="form.html">Quay lại Form</a>