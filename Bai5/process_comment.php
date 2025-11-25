<h1>Kết quả Bình luận</h1>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'] ?? '';
        $comment = $_POST['comment'] ?? '';
        
        // Kiểm tra dữ liệu trống
        if (empty($name) || empty($comment)) {
            echo "<p>Lỗi: Vui lòng điền đầy đủ tên và bình luận!</p>";
            echo "<p><a href='comment.html'>Quay lại form</a></p>";
            exit;
        }
        
        // Kiểm tra ký tự đặc biệt nguy hiểm
        $dangerous_pattern = '/[<>"\'\&]/';
        
        if (preg_match($dangerous_pattern, $name) || preg_match($dangerous_pattern, $comment)) {
            echo "<p>Lỗi: Bình luận chứa ký tự đặc biệt nguy hiểm!</p>";
            echo "<p>Vui lòng không sử dụng các ký tự: &lt; &gt; \" ' &</p>";
            echo "<p><a href='comment.html'>Quay lại form</a></p>";
            exit;
        }
        
        // Xử lý an toàn với htmlspecialchars (dù đã kiểm tra trên)
        $safe_name = htmlspecialchars($name);
        $safe_comment = htmlspecialchars($comment);
        
        echo "<h2>Bình luận an toàn:</h2>";
        echo "<p><strong>Tên:</strong> $safe_name</p>";
        echo "<p><strong>Bình luận:</strong> $safe_comment</p>";
        echo "<p>✅ Bình luận đã được kiểm tra và xử lý an toàn!</p>";
        
    } else {
        echo "<p>Lỗi: Không có dữ liệu!</p>";
    }
    ?>
    
    <br>
    <a href="comment.html">Gửi bình luận khác</a>
