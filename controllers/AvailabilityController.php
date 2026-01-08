<?php
require_once 'models/Availability.php';

class AvailabilityController {

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Security check
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
                header("Location: index.php?action=login");
                exit;
            }

            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $doctor_id = $_SESSION['user_id'];

            // Validation: Start Date cannot be after End Date
            if (strtotime($start_date) > strtotime($end_date)) {
                echo "<script>alert('Error: From Date cannot be after To Date'); window.location.href='index.php?action=doctor_availability';</script>";
                exit;
            }

            // Validation: Time
            if (strtotime($start_time) >= strtotime($end_time)) {
                echo "<script>alert('Error: Start time must be before End time'); window.location.href='index.php?action=doctor_availability';</script>";
                exit;
            }

            $model = new Availability();
            $successCount = 0;
            
            // Loop through dates
            $current = strtotime($start_date);
            $end = strtotime($end_date);

            while ($current <= $end) {
                $dateForDB = date('Y-m-d', $current);
                
                // Try to insert (model returns true/false)
                if($model->setAvailability($doctor_id, $dateForDB, $start_time, $end_time)) {
                    $successCount++;
                }

                // Add 1 day
                $current = strtotime("+1 day", $current);
            }

            echo "<script>alert('Schedule updated! Added availability for $successCount days.'); window.location.href='index.php?action=dashboard_doctor';</script>";
        }
    }
}
?>