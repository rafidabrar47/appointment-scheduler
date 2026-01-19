<?php
// controllers/ProfileController.php
require_once 'models/User.php';

class ProfileController {

    // 1. Show the Profile Page
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $userModel = new User();
        // Reuse the existing getUserById function
        $user = $userModel->getUserById($_SESSION['user_id']);

        include 'views/profile.php';
    }

    // 2. Handle the Update Profile Form Submission

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php?action=login");
                exit;
            }

            $id = $_SESSION['user_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();

            // 1. VALIDATION: Check if email already exists
            if ($userModel->isEmailTaken($email, $id)) {
                echo "<script>
                        alert('Error: This email address is already exists in the system. Please try another one.'); 
                        window.location.href='index.php?action=profile';
                      </script>";
                exit;
            }

            // 2. UPDATE PROFILE
            if ($userModel->updateProfile($id, $name, $email, $password)) {
                
                // Update Session Name
                $_SESSION['name'] = $name;

                // 3. DETERMINE DASHBOARD LINK
                $role = $_SESSION['role'];
                $redirect = 'index.php?action=login'; // Fallback
                
                if ($role == 'admin') {
                    $redirect = 'index.php?action=dashboard_admin';
                } elseif ($role == 'doctor') {
                    $redirect = 'index.php?action=dashboard_doctor';
                } elseif ($role == 'patient') {
                    $redirect = 'index.php?action=dashboard_patient';
                }

                // 4. SUCCESS ALERT & REDIRECT
                echo "<script>
                        alert('Profile updated successfully!'); 
                        window.location.href='$redirect';
                      </script>";
            } else {
                echo "<script>alert('Database error updating profile.'); window.location.href='index.php?action=profile';</script>";
            }
        }
    }
}
?>