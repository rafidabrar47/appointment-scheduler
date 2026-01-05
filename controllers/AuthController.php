<?php
// controllers/AuthController.php
require_once 'models/User.php';

class AuthController {
    
    // --- LOGIN LOGIC (Updated with Approval Check) ---
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->login($email, $password);

            if ($user) {
                // 1. SECURITY CHECK: Is the account approved?
                // If is_approved is 0 (False), deny access immediately.
                if ($user['is_approved'] == 0) {
                    echo "<script>
                        alert('Access Denied: Your account is currently pending Admin Approval. Please wait for confirmation.'); 
                        window.location.href='index.php?action=login';
                    </script>";
                    exit;
                }

                // 2. If Approved, Start Session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['full_name'];

                // 3. Redirect based on Role
                if ($user['role'] === 'doctor') {
                    header("Location: index.php?action=dashboard_doctor");
                } elseif ($user['role'] === 'patient') {
                    header("Location: index.php?action=dashboard_patient");
                } elseif ($user['role'] === 'admin') {
                    header("Location: index.php?action=dashboard_admin");
                } else {
                    echo "Unknown Role";
                }
                exit;
            } else {
                // Login Failed (Wrong Email/Pass)
                echo "<script>alert('Invalid Email or Password'); window.location.href='index.php?action=login';</script>";
            }
        }
    }

    public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Get specialization if it exists (only for doctors)
        $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : null;

        $userModel = new User();
        if ($userModel->register($name, $email, $password, $role, $specialization)) {
            if ($role === 'doctor') {
                echo "<script>alert('Registration Successful! Your account is PENDING Admin approval.'); window.location.href='index.php?action=login';</script>";
            } else {
                echo "<script>alert('Registration Successful! Please login.'); window.location.href='index.php?action=login';</script>";
            }
        } else {
            echo "<script>alert('Registration failed. Email might exist.'); window.location.href='index.php?action=register';</script>";
        }
    }
}
}
?>