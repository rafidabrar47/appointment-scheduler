<?php
// index.php - Main Entry Point

session_start();
require_once 'config/Database.php';

// Get the action from the URL (default to 'login')
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'login':
        include 'views/login.php';
        break;
        
    case 'register':
        include 'views/register.php';
        break;

    case 'dashboard_doctor':
        include 'views/doctor_dashboard.php';
        break;

    case 'dashboard_patient':
        include 'views/patient_dashboard.php';
        break;
        
    case 'logout':
        session_destroy();
        header("Location: index.php?action=login");
        exit;

    default:
        echo "404 - Page Not Found";
        break;
}
?>