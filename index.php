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
    require_once 'models/Appointment.php';
    $apptModel = new Appointment();
    $myAppointments = $apptModel->getAppointmentsByPatient($_SESSION['user_id']);
    include 'views/patient_dashboard.php';
    break;

    // --- Add these inside the switch($action) block ---

    case 'doctor_availability':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
            header("Location: index.php?action=login");
            exit;
        }
        include 'views/doctor_availability.php';
        break;

    case 'availability_submit':
        require_once 'controllers/AvailabilityController.php';
        $avController = new AvailabilityController();
        $avController->add();
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

    case 'book_appointment':
        // Security check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
            header("Location: index.php?action=login");
            exit;
        }

        // Get Doctors for the dropdown
        require_once 'models/User.php';
        $userModel = new User();
        $doctors = $userModel->getAllDoctors();

        include 'views/book_appointment.php';
        break;

    case 'api_get_slots':
        require_once 'controllers/AjaxController.php';
        $ajax = new AjaxController();
        $ajax->getSlots();
        break;    

    case 'book_submit':
        require_once 'controllers/AppointmentController.php';
        $apptController = new AppointmentController();
        $apptController->book();
        break;

    case 'register_submit':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->register();
        break;    

    default:
        echo "404 - Page Not Found";
        break;
}
?>
