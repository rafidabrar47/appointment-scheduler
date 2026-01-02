<?php
// controllers/AvailabilityController.php
require_once 'models/Availability.php';

class AvailabilityController {

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Security check
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
                header("Location: index.php?action=login");
                exit;
            }

            $date = $_POST['date'];
            $start = $_POST['start_time'];
            $end = $_POST['end_time'];
            $doctor_id = $_SESSION['user_id'];

            // Basic Validation
            if (strtotime($start) >= strtotime($end)) {
                echo "<script>alert('Start time must be before End time'); window.location.href='index.php?action=doctor_availability';</script>";
                exit;
            }

            $model = new Availability();
            if ($model->setAvailability($doctor_id, $date, $start, $end)) {
                header("Location: index.php?action=dashboard_doctor");
            } else {
                echo "<script>alert('Error: Availability already set for this date or Database error.'); window.location.href='index.php?action=doctor_availability';</script>";
            }
        }
    }
}
?>