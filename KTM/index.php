<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSearch - Tìm kiếm Khóa học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #15a6b1ff;
            --secondary-color: #0c8fa3ff;
            --accent-color: #4cc9f0;
            --success-color: #4ade80;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gray-color: #64748b;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--dark-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 20px;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .logo-icon {
            background: var(--primary-color);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .tagline {
            color: var(--gray-color);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Search Section */
        .search-section {
            background: white;
            border-radius: var(--radius);
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .search-section:hover {
            transform: translateY(-5px);
        }

        .search-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-title i {
            color: var(--primary-color);
        }

        .search-form {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .search-input-wrapper {
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 18px 25px 18px 50px;
            border: 2px solid #e2e8f0;
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
            background: var(--light-color);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
            font-size: 1.2rem;
        }

        .search-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 0 35px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        }

        .search-tips {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        .search-tips i {
            color: var(--warning-color);
        }

        /* Results Section */
        .results-section {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .results-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            color: var(--dark-color);
        }

        .results-count {
            background: var(--light-color);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Course Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .course-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .course-header {
            padding: 25px;
            background: linear-gradient(135deg, #139ec5ff 0%, #15a4c0ff 100%);
            color: white;
            position: relative;
        }

        .course-id {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .course-name {
            font-family: 'Poppins', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .course-body {
            padding: 25px;
        }

        .course-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            color: var(--gray-color);
        }

        .course-info i {
            width: 20px;
            color: var(--primary-color);
        }

        .teacher-info {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid var(--primary-color);
        }

        .teacher-label {
            font-size: 0.9rem;
            color: var(--gray-color);
            margin-bottom: 5px;
        }

        .teacher-name {
            font-weight: 600;
            color: var(--dark-color);
        }

        .course-footer {
            padding: 20px 25px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-fee {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .enroll-btn {
            background: var(--success-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .enroll-btn:hover {
            background: #22c55e;
            transform: translateY(-2px);
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 60px 20px;
        }

        .no-results-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 20px;
        }

        .no-results-text {
            font-size: 1.2rem;
            color: var(--gray-color);
            margin-bottom: 10px;
        }

        .no-results-suggestion {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Quick Search */
        .quick-search {
            margin-top: 30px;
        }

        .quick-search-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .quick-search-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .search-tag {
            background: var(--light-color);
            padding: 10px 20px;
            border-radius: 20px;
            color: var(--gray-color);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
            border: 1px solid #e2e8f0;
        }

        .search-tag:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }

        .footer-link {
            color: var(--primary-color);
            text-decoration: none;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* Loading Animation */
        .loading {
            display: none;
            text-align: center;
            padding: 40px;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
            }
            
            .search-btn {
                justify-content: center;
                padding: 18px;
            }
            
            .courses-grid {
                grid-template-columns: 1fr;
            }
            
            .results-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .header {
                padding: 20px 15px;
            }
            
            .logo-text {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="logo-text">EduSearch</h1>
            </div>
            <p class="tagline">
               Sinh viên: Trương Thanh Sơn - Lớp: 24CNTT1A
            </p>
        </header>

        <!-- Search Section -->
        <section class="search-section">
            <h2 class="search-title">
                <i class="fas fa-search"></i>
                Tìm kiếm khóa học
            </h2>
            
            <form method="GET" action="" id="searchForm">
                <div class="search-form">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" 
                               name="search" 
                               class="search-input"
                               placeholder="Nhập tên khóa học, giảng viên hoặc từ khóa..." 
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                               id="searchInput"
                               autocomplete="off">
                    </div>
                    <button type="submit" class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                </div>
                
                <div class="search-tips">
                    <i class="fas fa-lightbulb"></i>
                    <span>Gợi ý: Thử tìm kiếm với "PHP", "Web Development", "Database" hoặc "JavaScript"</span>
                </div>
            </form>
        </section>

        <!-- Loading Animation -->
        <div class="loading" id="loading">
            <div class="loading-spinner"></div>
            <p>Đang tìm kiếm khóa học...</p>
        </div>

        <!-- Results Section -->
        <?php
        require_once 'CourseModel.php';
        
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $searchTerm = trim($_GET['search']);
            
            try {
                $courseModel = new CourseModel();
                $results = $courseModel->searchCourseByName($searchTerm);
        ?>
        
        <section class="results-section">
            <div class="results-header">
                <h2 class="results-title">
                    <i class="fas fa-book-open"></i>
                    Kết quả tìm kiếm
                </h2>
                <div class="results-count">
                    <i class="fas fa-layer-group"></i>
                    <?php echo count($results); ?> khóa học
                </div>
            </div>
            
            <?php if (count($results) > 0): ?>
                <div class="courses-grid">
                    <?php foreach ($results as $course): ?>
                    <div class="course-card">
                        <div class="course-header">
                            <div class="course-id">#<?php echo htmlspecialchars($course['ID']); ?></div>
                            <h3 class="course-name"><?php echo htmlspecialchars($course['course_name']); ?></h3>
                        </div>
                        
                        <div class="course-body">
                            <div class="teacher-info">
                                <div class="teacher-label">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    Giảng viên
                                </div>
                                <div class="teacher-name"><?php echo htmlspecialchars($course['teacher']); ?></div>
                            </div>
                            
                            <div class="course-info">
                                <i class="fas fa-clock"></i>
                                <span>Thời lượng: 12 tuần</span>
                            </div>
                            <div class="course-info">
                                <i class="fas fa-star"></i>
                                <span>Đánh giá: 4.8/5.0</span>
                            </div>
                            <div class="course-info">
                                <i class="fas fa-users"></i>
                                <span>Số lượng học viên: 250+</span>
                            </div>
                        </div>
                        
                        <div class="course-footer">
                            <div class="course-fee"><?php echo htmlspecialchars($course['fee']); ?></div>
                            <button class="enroll-btn" onclick="enrollCourse(<?php echo $course['ID']; ?>)">
                                <i class="fas fa-plus-circle"></i>
                                Đăng ký ngay
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="no-results-text">Không tìm thấy khóa học phù hợp</h3>
                    <p class="no-results-suggestion">
                        Thử tìm kiếm với từ khóa khác hoặc duyệt các khóa học phổ biến bên dưới
                    </p>
                </div>
            <?php endif; ?>
            
        </section>
        
        <?php
            } catch (Exception $e) {
                echo '<div style="background: #fee2e2; color: #dc2626; padding: 20px; border-radius: var(--radius); margin: 20px 0;">
                        <h3><i class="fas fa-exclamation-triangle"></i> Lỗi hệ thống</h3>
                        <p>'.htmlspecialchars($e->getMessage()).'</p>
                      </div>';
            }
        } elseif (isset($_GET['search'])) {
            echo '<div style="background: #fef3c7; color: #d97706; padding: 20px; border-radius: var(--radius); margin: 20px 0;">
                    <h3><i class="fas fa-info-circle"></i> Thông báo</h3>
                    <p>Vui lòng nhập từ khóa tìm kiếm để bắt đầu.</p>
                  </div>';
        }
        ?>

    </div>

    <script>
        // Form submission loading
        document.getElementById('searchForm').addEventListener('submit', function() {
            document.getElementById('loading').style.display = 'block';
        });
        
        // Auto focus search input
        document.getElementById('searchInput').focus();
        
        // Enroll course function
        function enrollCourse(courseId) {
            if(confirm('Bạn có chắc chắn muốn đăng ký khóa học này?')) {
                alert('Đăng ký khóa học #' + courseId + ' thành công!\nChúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
            }
        }
        
        // Search suggestions (optional enhancement)
        const searchInput = document.getElementById('searchInput');
        const suggestions = ['PHP Programming', 'Web Development', 'Database Design', 'JavaScript', 'Python', 'React', 'Vue.js', 'Laravel'];
        
        searchInput.addEventListener('input', function() {
            // You can implement AJAX search suggestions here
        });
        
        // Quick search tag click handler
        document.querySelectorAll('.search-tag').forEach(tag => {
            tag.addEventListener('click', function(e) {
                document.getElementById('loading').style.display = 'block';
            });
        });
    </script>
</body>
</html>