<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập PHP: Cấu trúc điều khiển</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --warning: #f8961e;
            --info: #4895ef;
            --card-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --card-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --card-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --card-5: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --card-6: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: var(--dark);
            min-height: 100vh;
            padding: 40px 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }
        
        .header-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .header-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        
        h1 {
            font-size: 3rem;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
            font-weight: 800;
        }
        
        .subtitle {
            font-size: 1.3rem;
            color: #6c757d;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 60px;
        }
        
        .card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .card:nth-child(1) .card-header {
            background: var(--card-1);
        }
        
        .card:nth-child(2) .card-header {
            background: var(--card-2);
        }
        
        .card:nth-child(3) .card-header {
            background: var(--card-3);
        }
        
        .card:nth-child(4) .card-header {
            background: var(--card-4);
        }
        
        .card:nth-child(5) .card-header {
            background: var(--card-5);
        }
        
        .card:nth-child(6) .card-header {
            background: var(--card-6);
        }
        
        .card-header {
            padding: 25px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: skewX(-20deg) translateX(-20px);
        }
        
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-header h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .card-body {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .card-body p {
            margin-bottom: 20px;
            color: #6c757d;
            flex-grow: 1;
        }
        
        .card-footer {
            padding: 0 25px 25px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
            width: 100%;
            text-align: center;
        }
        
        .btn:hover {
            background: var(--secondary);
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(67, 97, 238, 0.4);
        }
        
        .btn i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }
        
        .btn:hover i {
            transform: translateX(5px);
        }
        
        footer {
            text-align: center;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        footer p {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .grid-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 2.5rem;
            }
            
            .header-content {
                padding: 30px 20px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 20px 15px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 1.1rem;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card {
            animation: fadeIn 0.6s ease forwards;
        }
        
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }
        .card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1>BÀI TẬP PHP: CẤU TRÚC ĐIỀU KHIỂN</h1>
                <p class="subtitle">Khám phá và thực hành các cấu trúc điều khiển cơ bản trong PHP thông qua các bài tập tương tác</p>
            </div>
        </header>
        
        <div class="grid-container">
            <!-- Hàng 1: 3 ô đầu tiên -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <h3>Cấu trúc rẽ nhánh IF</h3>
                    <p>Kiểm tra điều kiện số</p>
                </div>
                <div class="card-body">
                    <p>Thực hành sử dụng cấu trúc IF để kiểm tra số dương, số âm và số không.</p>
                    <div class="card-footer">
                        <a href="bai1.php" class="btn">
                            Bắt đầu thực hành <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-redo-alt"></i>
                    </div>
                    <h3>Vòng lặp DO...WHILE</h3>
                    <p>Đếm ngược từ N về 1</p>
                </div>
                <div class="card-body">
                    <p>Thực hành vòng lặp DO...WHILE để đếm ngược từ một số N về 1.</p>
                    <div class="card-footer">
                        <a href="bai6.php" class="btn">
                            Bắt đầu thực hành <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>IF – ELSE – ELSEIF</h3>
                    <p>Xếp loại học lực</p>
                </div>
                <div class="card-body">
                    <p>Sử dụng cấu trúc IF-ELSE-ELSEIF để xếp loại học lực dựa trên điểm trung bình.</p>
                    <div class="card-footer">
                        <a href="bai2.php" class="btn">
                            Bắt đầu thực hành <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Hàng 2: 3 ô tiếp theo -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <h3>Switch...Case</h3>
                    <p>Hiển thị thứ trong tuần</p>
                </div>
                <div class="card-body">
                    <p>Áp dụng cấu trúc Switch...Case để hiển thị thứ trong tuần dựa vào số nhập vào.</p>
                    <div class="card-footer">
                        <a href="bai3.php" class="btn">
                            Bắt đầu thực hành <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>Vòng lặp FOR</h3>
                    <p>Tính tổng các số từ 1 đến N</p>
                </div>
                <div class="card-body">
                    <p>Sử dụng vòng lặp FOR để tính tổng các số từ 1 đến một số N nhập vào.</p>
                    <div class="card-footer">
                        <a href="bai4.php" class="btn">
                            Bắt đầu thực hành <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3>Vòng lặp WHILE</h3>
                    <p>In ra các số chẵn</p>
                </div>
                <div class="card-body">
                    <p>Thực hành vòng lặp WHILE để in ra tất cả các số chẵn nhỏ hơn một số N cho trước.</p>
                    <div class="card-footer">
                        <a href="bai5.php" class="btn">
                            Bắt đầu thực hành <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>