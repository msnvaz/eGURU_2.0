<?php
namespace App\Models\tutor;
use PDO;

class UserModel {
    // Database connection parameters
    private static $host = 'localhost';
    private static $dbName = 'eguru_full';
    private static $username = 'root';
    private static $password = '';

    // Method to validate user credentials
    public static function validateUser($email, $password) {
        try {   
            // Establish database connection using PDO
            $pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName, self::$username, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL query to check if the user exists
            $query = "SELECT * FROM tutors WHERE email = :email AND password = :password";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); // You should hash the password in a real-world scenario

            // Execute the query
            $stmt->execute();

            // Check if user exists
            if ($stmt->rowCount() > 0) {
                return true; // User found, valid credentials
            } else {
                return false; // No user found, invalid credentials
            }
        } catch (PDOException $e) {
            // In case of any error (e.g., database connection issue)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
