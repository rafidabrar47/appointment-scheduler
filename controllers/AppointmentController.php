<?php
// controllers/AppointmentController.php
require_once 'models/Appointment.php';

class AppointmentController {

    public function book() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Security Check
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
                header("Location: index.php?action=login");
                exit;
            }

            $patient_id = $_SESSION['user_id'];
            $doctor_id = $_POST['doctor_id'];
            $date = $_POST['date'];
            $timeRaw = $_POST['time']; // This comes in as "10:15 AM"

            // Convert "10:15 AM" to MySQL format "10:15:00"
            $timeFormatted = date("H:i:s", strtotime($timeRaw));

            $apptModel = new Appointment();
            
            if ($apptModel->bookAppointment($patient_id, $doctor_id, $date, $timeFormatted)) {
                // Success! Redirect to dashboard
                echo "<script>alert('Appointment Booked Successfully!'); window.location.href='index.php?action=dashboard_patient';</script>";
            } else {
                echo "<script>alert('Error booking appointment.'); window.location.href='index.php?action=book_appointment';</script>";
            }
        }
    }

    public function updateStatus() {
        // Check if ID and Status are in the URL
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $id = $_GET['id'];
            $status = $_GET['status'];

            // Security: Only allow valid statuses
            $allowed_statuses = ['confirmed', 'rejected', 'cancelled'];
            if (!in_array($status, $allowed_statuses)) {
                die("Invalid status");
            }

            $apptModel = new Appointment();
            if ($apptModel->updateStatus($id, $status)) {
                // Success: Redirect back to dashboard
                header("Location: index.php?action=dashboard_doctor");
                exit;
            } else {
                echo "Error updating record.";
            }
        }
    }
}
?>