<?php
require_once 'Database.php';

class CourseModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Phương thức tìm kiếm khóa học theo tên
     * @param string $courseName Tên khóa học cần tìm
     * @return array Danh sách khóa học tìm thấy
     */
    public function searchCourseByName($courseName) {
        $courses = [];
        
        try {
            // Sử dụng LIKE để tìm kiếm tương đối
            $sql = "SELECT * FROM courses WHERE course_name LIKE ? ORDER BY course_name";
            $searchTerm = "%" . $courseName . "%";
            
            $result = $this->db->query($sql, [$searchTerm]);
            
            while ($row = $result->fetch_assoc()) {
                $courses[] = [
                    'ID' => $row['ID'],
                    'course_name' => $row['course_name'],
                    'teacher' => $row['teacher'],
                    'fee' => number_format($row['fee'], 0, ',', '.') . ' VND'
                ];
            }
            
        } catch (Exception $e) {
            error_log("Search error: " . $e->getMessage());
            throw new Exception("Error searching courses: " . $e->getMessage());
        }
        
        return $courses;
    }
    
    /**
     * Phương thức tìm kiếm nâng cao (tùy chọn bổ sung)
     * @param string $courseName Tên khóa học
     * @param string $teacher Tên giáo viên (tùy chọn)
     * @return array Danh sách khóa học
     */
    public function advancedSearch($courseName, $teacher = null) {
        $courses = [];
        
        try {
            $sql = "SELECT * FROM courses WHERE course_name LIKE ?";
            $params = ["%" . $courseName . "%"];
            
            if ($teacher) {
                $sql .= " AND teacher LIKE ?";
                $params[] = "%" . $teacher . "%";
            }
            
            $sql .= " ORDER BY course_name";
            
            $result = $this->db->query($sql, $params);
            
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
            
        } catch (Exception $e) {
            error_log("Advanced search error: " . $e->getMessage());
        }
        
        return $courses;
    }
    
    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
?>