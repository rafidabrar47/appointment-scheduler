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
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
            header("Location: index.php?action=login");
            exit;
        }
        
        require_once 'models/Appointment.php';
        $apptModel = new Appointment();
        
        // 1. Get the list of appointments (You already have this)
        $appointments = $apptModel->getAppointmentsByDoctor($_SESSION['user_id']);
        
        // 2. Get the specific count of PENDING ones (NEW LINE)
        $pendingCount = $apptModel->countPending($_SESSION['user_id']);

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

    case 'update_status':
        // Check if user is logged in as doctor (Security)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
            header("Location: index.php?action=login");
            exit;
        }
        
        require_once 'controllers/AppointmentController.php';
        $apptController = new AppointmentController();
        $apptController->updateStatus();
        break;

    default:
        echo "404 - Page Not Found";
        break;
}
?>
