<?php
namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminPointsModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    public function getAllPointTransactions($transactionType = '') {
        try {
            $purchaseQuery = "SELECT 
                'purchase' AS transaction_type,
                p.payment_id AS transaction_id,
                p.student_id AS user_id,
                NULL AS tutor_id,
                s.student_first_name AS first_name,
                s.student_last_name AS last_name,
                s.student_email AS email,
                p.point_amount,
                p.cash_value,
                p.bank_transaction_id,
                p.transaction_date,
                p.transaction_time
            FROM student_point_purchase p
            LEFT JOIN student s ON p.student_id = s.student_id";
            
            $cashoutQuery = "SELECT 
                'cashout' AS transaction_type,
                c.cashout_id AS transaction_id,
                NULL AS student_id,
                c.tutor_id AS user_id,
                t.tutor_first_name AS first_name,
                t.tutor_last_name AS last_name,
                t.tutor_email AS email,
                c.point_amount,
                c.cash_value,
                c.bank_transaction_id,
                c.transaction_date,
                c.transaction_time
            FROM tutor_point_cashout c
            LEFT JOIN tutor t ON c.tutor_id = t.tutor_id";
            
            if ($transactionType === 'purchase') {
                $sql = $purchaseQuery . " ORDER BY payment_id DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            } 
            else if ($transactionType === 'cashout') {
                $sql = $cashoutQuery . " ORDER BY cashout_id DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            } 
            else {
                $sql = $purchaseQuery . " UNION ALL " . $cashoutQuery . " ORDER BY transaction_date DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            }
            
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Model: getAllPointTransactions fetched ' . count($records) . ' records');
            
            foreach ($records as $record) {
                if ($record['transaction_type'] === 'cashout' && empty($record['user_id'])) {
                    error_log('Warning: Cashout transaction #' . $record['transaction_id'] . ' has empty tutor_id');
                }
            }
            
            return $records;
        } catch (PDOException $e) {
            error_log('Error fetching point transactions: ' . $e->getMessage());
            return [];
        }
    }

    public function filterPointTransactions($startDate, $endDate, $tutorId, $studentId, $transactionType, $pointsMin, $pointsMax) {
        try {
            $conditions = [];
            $params = [];
            
            $purchaseQuery = "SELECT 
                'purchase' AS transaction_type,
                p.payment_id AS transaction_id,
                p.student_id AS user_id,
                NULL AS tutor_id,
                s.student_first_name AS first_name,
                s.student_last_name AS last_name,
                s.student_email AS email,
                p.point_amount,
                p.cash_value,
                p.bank_transaction_id,
                p.transaction_date,
                p.transaction_time
            FROM student_point_purchase p
            LEFT JOIN student s ON p.student_id = s.student_id
            WHERE 1=1";
            
            $cashoutQuery = "SELECT 
                'cashout' AS transaction_type,
                c.cashout_id AS transaction_id,
                NULL AS student_id,
                c.tutor_id AS user_id,
                t.tutor_first_name AS first_name,
                t.tutor_last_name AS last_name,
                t.tutor_email AS email,
                c.point_amount,
                c.cash_value,
                c.bank_transaction_id,
                c.transaction_date,
                c.transaction_time
            FROM tutor_point_cashout c
            LEFT JOIN tutor t ON c.tutor_id = t.tutor_id
            WHERE 1=1";
            
            $purchaseConditions = [];
            if ($studentId) {
                $purchaseConditions[] = "p.student_id = :student_id";
                $params[':student_id'] = $studentId;
            }
            if ($pointsMin) {
                $purchaseConditions[] = "p.point_amount >= :points_min";
                $params[':points_min'] = $pointsMin;
            }
            if ($pointsMax) {
                $purchaseConditions[] = "p.point_amount <= :points_max";
                $params[':points_max'] = $pointsMax;
            }
            $purchaseConditionsStr = !empty($purchaseConditions) ? " AND " . implode(" AND ", $purchaseConditions) : "";
            
            $cashoutConditions = [];
            if ($tutorId) {
                $cashoutConditions[] = "c.tutor_id = :tutor_id";
                $params[':tutor_id'] = $tutorId;
            }
            if ($pointsMin) {
                $cashoutConditions[] = "c.point_amount >= :points_min";
                $params[':points_min'] = $pointsMin;
            }
            if ($pointsMax) {
                $cashoutConditions[] = "c.point_amount <= :points_max";
                $params[':points_max'] = $pointsMax;
            }
            $cashoutConditionsStr = !empty($cashoutConditions) ? " AND " . implode(" AND ", $cashoutConditions) : "";
            
            $purchaseQuery .= $purchaseConditionsStr;
            $cashoutQuery .= $cashoutConditionsStr;
            
            if ($transactionType === 'purchase') {
                $sql = $purchaseQuery . " ORDER BY payment_id DESC";
                $stmt = $this->conn->prepare($sql);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $stmt->execute();
            } 
            else if ($transactionType === 'cashout') {
                $sql = $cashoutQuery . " ORDER BY cashout_id DESC";
                $stmt = $this->conn->prepare($sql);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $stmt->execute();
            } 
            else {
                $sql = $purchaseQuery . " UNION ALL " . $cashoutQuery . " ORDER BY transaction_id DESC";
                $stmt = $this->conn->prepare($sql);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $stmt->execute();
            }
            
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Model: filterPointTransactions fetched ' . count($records) . ' records');
            
            foreach ($records as $record) {
                if ($record['transaction_type'] === 'cashout' && empty($record['user_id'])) {
                    error_log('Warning: Filtered cashout transaction #' . $record['transaction_id'] . ' has empty tutor_id');
                }
            }
            
            return $records;
        } catch (PDOException $e) {
            error_log('Error filtering point transactions: ' . $e->getMessage());
            return [];
        }
    }

    public function searchPointTransactions($searchTerm, $transactionType = '') {
        try {
            $purchaseQuery = "SELECT 
                'purchase' AS transaction_type,
                p.payment_id AS transaction_id,
                p.student_id AS user_id,
                NULL AS tutor_id,
                s.student_first_name AS first_name,
                s.student_last_name AS last_name,
                s.student_email AS email,
                p.point_amount,
                p.cash_value,
                p.bank_transaction_id,
                p.transaction_date,
                p.transaction_time
            FROM student_point_purchase p
            LEFT JOIN student s ON p.student_id = s.student_id
            WHERE (LOWER(s.student_first_name) LIKE LOWER(:search)
                OR LOWER(s.student_last_name) LIKE LOWER(:search)
                OR LOWER(s.student_email) LIKE LOWER(:search)
                OR CAST(p.payment_id AS CHAR) LIKE :search
                OR LOWER(p.bank_transaction_id) LIKE LOWER(:search)) ";
            
            $cashoutQuery = "SELECT 
                'cashout' AS transaction_type,
                c.cashout_id AS transaction_id,
                NULL AS student_id,
                c.tutor_id AS user_id,
                t.tutor_first_name AS first_name,
                t.tutor_last_name AS last_name,
                t.tutor_email AS email,
                c.point_amount,
                c.cash_value,
                c.bank_transaction_id,
                c.transaction_date,
                c.transaction_time
            FROM tutor_point_cashout c
            LEFT JOIN tutor t ON c.tutor_id = t.tutor_id
            WHERE (LOWER(t.tutor_first_name) LIKE LOWER(:search)
                OR LOWER(t.tutor_last_name) LIKE LOWER(:search)
                OR LOWER(t.tutor_email) LIKE LOWER(:search)
                OR CAST(c.cashout_id AS CHAR) LIKE :search
                OR LOWER(c.bank_transaction_id) LIKE LOWER(:search)) ";
            
            $cashoutQuery = "SELECT 
                'cashout' AS transaction_type,
                c.cashout_id AS transaction_id,
                NULL AS student_id,
                c.tutor_id AS user_id,
                t.tutor_first_name AS first_name,
                t.tutor_last_name AS last_name,
                t.tutor_email AS email,
                c.point_amount,
                c.cash_value,
                c.bank_transaction_id,
                c.transaction_date,
                c.transaction_time
            FROM tutor_point_cashout c
            LEFT JOIN tutor t ON c.tutor_id = t.tutor_id
            WHERE (LOWER(t.tutor_first_name) LIKE LOWER(:search)
                OR LOWER(t.tutor_last_name) LIKE LOWER(:search)
                OR LOWER(t.tutor_email) LIKE LOWER(:search)
                OR CAST(c.cashout_id AS CHAR) LIKE :search
                OR LOWER(c.bank_transaction_id) LIKE LOWER(:search));";
                        
            $searchParam = "%$searchTerm%"; 
            
            if ($transactionType === 'purchase') {
                $sql = $purchaseQuery . " ORDER BY payment_id DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':search', $searchParam);
                $stmt->execute();
            } 
            else if ($transactionType === 'cashout') {
                $sql = $cashoutQuery . " ORDER BY cashout_id DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':search', $searchParam);
                $stmt->execute();
            } 
            else {
                $sql = $purchaseQuery . " UNION ALL " . $cashoutQuery . " ORDER BY transaction_id DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':search', $searchParam);
                $stmt->execute();
            }
            
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Model: searchPointTransactions found ' . count($records) . ' matching records');
            
            foreach ($records as $record) {
                if ($record['transaction_type'] === 'cashout' && empty($record['user_id'])) {
                    error_log('Warning: Search result cashout transaction #' . $record['transaction_id'] . ' has empty tutor_id');
                }
            }
            
            return $records;
        } catch (PDOException $e) {
            error_log('Error searching point transactions: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllTutors() {
        try {
            $sql = "SELECT tutor_id, 
                    CONCAT(tutor_first_name, ' ', tutor_last_name) AS tutor_full_name 
                    FROM tutor 
                    ORDER BY tutor_first_name, tutor_last_name";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching tutors: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllStudents() {
        try {
            $sql = "SELECT student_id, 
                    CONCAT(student_first_name, ' ', student_last_name) AS student_full_name 
                    FROM student 
                    ORDER BY student_first_name, student_last_name";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching students: ' . $e->getMessage());
            return [];
        }
    }
    public function getPlatformFee() {
        $query = "SELECT admin_setting_value FROM admin_settings WHERE admin_setting_name = 'platform_fee'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (float)$result['admin_setting_value'] : 0;
    }
}
?>