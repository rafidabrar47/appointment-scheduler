<?php
require_once 'models/User.php';

class AdminController {

    public function dashboard() {
        // Security Check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit;
        }

        $userModel = new User();
        $stats = $userModel->getStats();
        $pendingDoctors = $userModel->getPendingDoctors();

        include 'views/admin_dashboard.php';
    }

    public function handleApproval() {
        // Security Check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit;
        }

        if (isset($_GET['id']) && isset($_GET['status'])) {
            $id = $_GET['id'];
            $status = $_GET['status']; // 'approve' or 'reject'

            $userModel = new User();
            if ($userModel->updateStatus($id, $status)) {
                header("Location: index.php?action=dashboard_admin");
            } else {
                echo "Error updating status.";
            }
        }
    }

    // --- LISTS ---
    public function listDoctors() {
        $this->checkAdmin(); // Helper method below
        $userModel = new User();
        $doctors = $userModel->getAllDoctors(); // You wrote this in T-10
        include 'views/admin_doctors.php';
    }

    public function listPatients() {
        $this->checkAdmin();
        $userModel = new User();
        $patients = $userModel->getAllPatients();
        include 'views/admin_patients.php';
    }

    // --- ADD/EDIT ACTIONS ---
    public function manageUser() {
        $this->checkAdmin();
        $userModel = new User();
        
        $user = null;
        if (isset($_GET['id'])) {
            // Edit Mode: Fetch existing data
            $user = $userModel->getUserById($_GET['id']);
        }

        // Handle Form Submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $spec = isset($_POST['specialization']) ? $_POST['specialization'] : null;

            if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                // UPDATE Existing
                $userModel->updateUser($_POST['user_id'], $name, $email, $role, $spec);
            } else {
                // CREATE New
                $password = $_POST['password']; 
                $userModel->register($name, $email, $password, $role, $spec);
                
                // Auto-approve doctors created by Admin
                if ($role === 'doctor') {
                    // Logic to auto-approve could go here, or just let them be pending
                }
            }
            
            // --- FIXED REDIRECTION LOGIC ---
            if ($role === 'patient') {
                header("Location: index.php?action=admin_patients");
            } elseif ($role === 'doctor') {
                header("Location: index.php?action=admin_doctors");
            } else {
                // If it's an Admin, go back to the main dashboard
                header("Location: index.php?action=dashboard_admin");
            }
            exit;
        }

        include 'views/admin_user_form.php';
    }

    // --- DELETE ACTION ---
    public function deleteUser() {
        $this->checkAdmin();
        if (isset($_GET['id'])) {
            $userModel = new User();
            $userModel->deleteUser($_GET['id']);
        }
        header("Location: " . $_SERVER['HTTP_REFERER']); // Go back to previous page
    }

    // Helper to prevent repeating code
    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit;
        }
    }
}
?>