<?php
require_once "database.php";

class SinhVien {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->conn;
    }

    public function insert($id, $hoten, $lop) {
        $sql = "INSERT INTO sinhvien (id_sinhvien, hoten, lop) VALUES ('$id', '$hoten', '$lop')";
        return $this->conn->query($sql);
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM sinhvien");
    }

    public function getById($id) {
        $result = $this->conn->query("SELECT * FROM sinhvien WHERE id_sinhvien='$id'");
        return $result->fetch_assoc();
    }

    public function update($id, $hoten, $lop) {
        $sql = "UPDATE sinhvien SET hoten='$hoten', lop='$lop' WHERE id_sinhvien='$id'";
        return $this->conn->query($sql);
    }

    public function delete($id) {
        return $this->conn->query("DELETE FROM sinhvien WHERE id_sinhvien='$id'");
    }
}
?>