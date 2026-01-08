<?php
// index.php - Main Entry Point
ob_start(); // Fixes redirection issues
session_start();

require_once 'config/Database.php';
require_once 'controllers/AuthController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    // --- AUTHENTICATION ---
    case 'login':
        include 'views/login.php';
        break;
        
    case 'login_submit':
        $auth = new AuthController();
        $auth->login();
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?action=login");
        exit;

    case 'register':
        include 'views/register.php';
        break;

    case 'register_submit':
        $auth = new AuthController();
        $auth->register();
        break;

    // --- PASSWORD RESET (The missing part) ---
    case 'reset_password':
        include 'views/reset_password.php';
        break;

    case 'reset_password_submit':
        $auth = new AuthController();
        $auth->resetPassword();
        break;

    // --- DOCTOR DASHBOARD ---
    case 'dashboard_doctor':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'models/Appointment.php';
        $apptModel = new Appointment();
        $appointments = $apptModel->getAppointmentsByDoctor($_SESSION['user_id']);
        $pendingCount = $apptModel->countPending($_SESSION['user_id']);
        include 'views/doctor_dashboard.php';
        break;

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

    case 'update_status':
        require_once 'controllers/AppointmentController.php';
        $apptController = new AppointmentController();
        $apptController->updateStatus();
        break;

    // --- PATIENT DASHBOARD ---
    case 'dashboard_patient':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'models/Appointment.php';
        require_once 'models/User.php';
        
        $apptModel = new Appointment();
        $userModel = new User();
        
        $myAppointments = $apptModel->getAppointmentsByPatient($_SESSION['user_id']);
        $doctors = $userModel->getAllDoctors(); // For the booking dropdown
        
        include 'views/patient_dashboard.php';
        break;

    case 'book_submit':
        require_once 'controllers/AppointmentController.php';
        $apptController = new AppointmentController();
        $apptController->book();
        break;

    // --- ADMIN DASHBOARD ---
    case 'dashboard_admin':
        require_once 'controllers/AdminController.php';
        $admin = new AdminController();
        $admin->dashboard();
        break;

    case 'admin_approval':
        require_once 'controllers/AdminController.php';
        $admin = new AdminController();
        $admin->handleApproval();
        break;

    case 'admin_doctors':
        require_once 'controllers/AdminController.php';
        (new AdminController())->listDoctors();
        break;

    case 'admin_patients':
        require_once 'controllers/AdminController.php';
        (new AdminController())->listPatients();
        break;

    case 'admin_user_form':
        require_once 'controllers/AdminController.php';
        (new AdminController())->manageUser();
        break;

    case 'admin_delete_user':
        require_once 'controllers/AdminController.php';
        (new AdminController())->deleteUser();
        break;

    // --- APIs (AJAX) ---
    case 'api_get_slots':
        require_once 'controllers/AjaxController.php';
        $ajax = new AjaxController();
        $ajax->getSlots();
        break;

    case 'api_get_dates':
        require_once 'controllers/AjaxController.php';
        $ajax = new AjaxController();
        $ajax->getDates();
        break;

    // --- DEFAULT ---
    default:
        echo "404 - Page Not Found";
        break;
}
?>