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

    public function register($name, $email, $password, $role, $specialization = null) {
        // 1. Determine Approval Status (Doctors = 0, Patients = 1)
        $is_approved = ($role === 'doctor') ? 0 : 1;

        try {
            // Start Transaction (So we don't create half-users)
            $this->conn->beginTransaction();

            // 2. Insert into USERS table
            $query = "INSERT INTO " . $this->table . " (full_name, email, password_hash, role, is_approved) 
                      VALUES (:name, :email, :password, :role, :approved)";
            $stmt = $this->conn->prepare($query);
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':approved', $is_approved);
            
            $stmt->execute();
            $new_user_id = $this->conn->lastInsertId(); // Get the ID of the user we just made

            // 3. If Doctor, insert into DOCTOR_PROFILES too
            if ($role === 'doctor' && !empty($specialization)) {
                $queryProfile = "INSERT INTO doctor_profiles (user_id, specialization) VALUES (:uid, :spec)";
                $stmtProfile = $this->conn->prepare($queryProfile);
                $stmtProfile->bindParam(':uid', $new_user_id);
                $stmtProfile->bindParam(':spec', $specialization);
                $stmtProfile->execute();
            }

            // Commit changes
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack(); // Undo if something failed
            return false;
        }
    }
}
?>