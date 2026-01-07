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
}
?>