<?php
// models/User.php
require_once 'config/Database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Verify Login Credentials
    public function login($email, $password) {
        // 1. Get user by email
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Verify Password (using the hash)
        if($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }

    // Get list of all doctors with their specialization
    public function getAllDoctors() {
        $query = "SELECT u.user_id, u.full_name, p.specialization 
                  FROM users u 
                  JOIN doctor_profiles p ON u.user_id = p.user_id 
                  WHERE u.role = 'doctor'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Register New User (We will need this later)
    public function register($name, $email, $password, $role) {
        $query = "INSERT INTO " . $this->table . " (full_name, email, password_hash, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);
        
        // Secure Hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>