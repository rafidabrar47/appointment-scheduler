<?php
// controllers/AuthController.php
require_once 'models/User.php';

class AuthController {
    
    // --- LOGIN LOGIC ---
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['full_name'];

                if ($user['role'] === 'doctor') {
                    header("Location: index.php?action=dashboard_doctor");
                } elseif ($user['role'] === 'patient') {
                    header("Location: index.php?action=dashboard_patient");
                } else {
                    echo "Login Successful (Admin Dashboard not ready)";
                }
                exit;
            } else {
                echo "<script>alert('Invalid Email or Password'); window.location.href='index.php?action=login';</script>";
            }
        }
    }

    // --- REGISTER LOGIC (This was missing) ---
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role']; // 'doctor' or 'patient'

            $userModel = new User();
            if ($userModel->register($name, $email, $password, $role)) {
                // Success: Redirect to Login
                echo "<script>alert('Account created! Please login.'); window.location.href='index.php?action=login';</script>";
            } else {
                // Failure: Likely email duplicate
                echo "<script>alert('Registration failed. Email might already exist.'); window.location.href='index.php?action=register';</script>";
            }
        }
    }
}
?>