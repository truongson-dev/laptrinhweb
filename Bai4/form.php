 <h1>Form Gửi Dữ Liệu</h1>
    
    <div>
        <h2>Gửi bằng GET</h2>
        <form action="process.php" method="get">
            <label for="get_data">Nhập dữ liệu:</label><br>
            <input type="text" id="get_data" name="data" placeholder="Nhập dữ liệu ở đây..."><br><br>
            <button type="submit">Gửi bằng GET</button>
        </form>
    </div>

    <div>
        <h2>Gửi bằng POST</h2>
        <form action="process.php" method="post">
            <label for="post_data">Nhập dữ liệu:</label><br>
            <input type="text" id="post_data" name="data" placeholder="Nhập dữ liệu ở đây..."><br><br>
            <button type="submit">Gửi bằng POST</button>
        </form>
    </div>