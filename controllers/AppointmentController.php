<?php
// controllers/AppointmentController.php
require_once 'models/Appointment.php';

class AppointmentController {

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