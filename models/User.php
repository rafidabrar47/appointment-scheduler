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

    // Get all users pending approval (Doctors with is_approved = 0)
    public function getPendingDoctors() {
        $query = "SELECT u.user_id, u.full_name, u.email, u.created_at, p.specialization 
                  FROM " . $this->table . " u 
                  LEFT JOIN doctor_profiles p ON u.user_id = p.user_id 
                  WHERE u.role = 'doctor' AND u.is_approved = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get simple stats for the dashboard cards
    public function getStats() {
        $query = "SELECT 
                    (SELECT COUNT(*) FROM users WHERE role='doctor') as total_doctors,
                    (SELECT COUNT(*) FROM users WHERE role='patient') as total_patients,
                    (SELECT COUNT(*) FROM appointments) as total_appointments
                  FROM dual";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Approve or Reject (Delete) a user
    public function updateStatus($user_id, $status) {
        if ($status === 'approve') {
            $query = "UPDATE " . $this->table . " SET is_approved = 1 WHERE user_id = :id";
        } else {
            // If rejected, we delete the user entirely so they can sign up again if needed
            $query = "DELETE FROM " . $this->table . " WHERE user_id = :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }

    // Get single user data (for editing)
    public function getUserById($user_id) {
        $query = "SELECT u.*, p.specialization 
                  FROM " . $this->table . " u 
                  LEFT JOIN doctor_profiles p ON u.user_id = p.user_id 
                  WHERE u.user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get All Patients
    public function getAllPatients() {
        $query = "SELECT * FROM " . $this->table . " WHERE role = 'patient'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update User Info
    public function updateUser($user_id, $name, $email, $role, $specialization = null) {
        $query = "UPDATE " . $this->table . " SET full_name = :name, email = :email WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':name' => $name, ':email' => $email, ':id' => $user_id]);

        // If Doctor, update specialization
        if ($role === 'doctor' && $specialization) {
            $queryProf = "UPDATE doctor_profiles SET specialization = :spec WHERE user_id = :id";
            $stmtProf = $this->conn->prepare($queryProf);
            $stmtProf->execute([':spec' => $specialization, ':id' => $user_id]);
        }
        return true;
    }

    // Delete User (Already handled by updateStatus('reject'), but let's be explicit)
    public function deleteUser($user_id) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
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

    public function updatePasswordByEmail($email, $hashed_password) {
        // Check if email exists first
        $checkQuery = "SELECT user_id FROM " . $this->table . " WHERE email = :email";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bindParam(':email', $email);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() == 0) {
            return false; // Email not found
        }

        // Update password
        $query = "UPDATE " . $this->table . " SET password_hash = :pass WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pass', $hashed_password);
        $stmt->bindParam(':email', $email);
        
        return $stmt->execute();
    }

    // Update Profile Info
    public function updateProfile($user_id, $name, $email, $new_password = null) {
        if (!empty($new_password)) {
            // Update WITH Password
            $query = "UPDATE " . $this->table . " SET full_name = :name, email = :email, password_hash = :pass WHERE user_id = :id";
            $stmt = $this->conn->prepare($query);
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt->bindParam(':pass', $hashed);
        } else {
            // Update WITHOUT Password
            $query = "UPDATE " . $this->table . " SET full_name = :name, email = :email WHERE user_id = :id";
            $stmt = $this->conn->prepare($query);
        }

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $user_id);

        return $stmt->execute();
    }

    // Check if email exists for ANY OTHER user (excluding the current one)
    public function isEmailTaken($email, $current_user_id) {
        $query = "SELECT user_id FROM " . $this->table . " WHERE email = :email AND user_id != :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $current_user_id);
        $stmt->execute();
        
        // If we find a row, it means someone else has this email
        return $stmt->rowCount() > 0;
    }
}
?>