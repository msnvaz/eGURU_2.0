<?php
class StudyMaterialModel {
    private $db;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=eguru_full;charset=utf8';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getMaterials($grade, $subject) {
        $stmt = $this->db->prepare("SELECT title, file_path FROM study_materials WHERE grade = ? AND subject = ?");
        $stmt->execute([$grade, $subject]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
