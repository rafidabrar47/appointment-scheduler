<?php
// controllers/AuthController.php
require_once 'models/User.php';

class AuthController {
    
    public function login() {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->login($email, $password);

            if ($user) {
                // Login Success: Save info in Session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['full_name'];

                // Redirect based on Role
                if ($user['role'] === 'doctor') {
                    header("Location: index.php?action=dashboard_doctor");
                } elseif ($user['role'] === 'patient') {
                    header("Location: index.php?action=dashboard_patient");
                } else {
                    // Admin or others
                    echo "Login Successful (Admin Dashboard not ready)";
                }
                exit;
            } else {
                // Login Failed
                echo "<script>alert('Invalid Email or Password'); window.location.href='index.php?action=login';</script>";
            }
        }
    }
}
?>