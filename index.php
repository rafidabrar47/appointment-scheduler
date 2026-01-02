<?php
// index.php - Main Entry Point

session_start();
require_once 'config/Database.php';
require_once 'controllers/AuthController.php'; // Load Controller

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'login':
        include 'views/login.php';
        break;
        
    case 'login_submit':
        // Pass control to the Controller
        $auth = new AuthController();
        $auth->login();
        break;

    case 'dashboard_doctor':
        // Security Check: Is user logged in AND a doctor?
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
            header("Location: index.php?action=login");
            exit;
        }
        include 'views/doctor_dashboard.php';
        break;

    case 'dashboard_patient':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
            header("Location: index.php?action=login");
            exit;
        }
        // We haven't built this view yet, so we show a placeholder
        echo "<h1>Patient Dashboard (Coming Soon)</h1><a href='index.php?action=logout'>Logout</a>";
        break;
        
    case 'logout':
        session_destroy();
        header("Location: index.php?action=login");
        exit;

    case 'register':
        include 'views/register.php';
        break;

    default:
        echo "404 - Page Not Found";
        break;
}
?>
