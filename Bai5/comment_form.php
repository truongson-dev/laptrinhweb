<h1>Form Bình Luận</h1>
    
    <form action="process_comment.php" method="post">
        <label>Tên của bạn:</label><br>
        <input type="text" name="name" required><br><br>
        
        <label>Bình luận:</label><br>
        <textarea name="comment" rows="4" cols="50" required></textarea><br><br>
        
        <button type="submit">Gửi Bình luận</button>
    </form>
    
    <p><strong>Lưu ý:</strong> Không được nhập các ký tự đặc biệt nguy hiểm như &lt;, &gt;, ", ', &, ...</p>
