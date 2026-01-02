<?php
// models/Appointment.php
require_once 'config/Database.php';

class Appointment {
    private $conn;
    private $table = 'appointments';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

// Update Appointment Status
    public function updateStatus($appointment_id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE appointment_id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $appointment_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get all appointments for a specific doctor
    public function getAppointmentsByDoctor($doctor_id) {
        // JOIN query to get Patient Name instead of just ID
        $query = "SELECT 
                    a.appointment_id, 
                    a.appointment_date, 
                    a.appointment_time, 
                    a.status,
                    u.full_name as patient_name,
                    u.email as patient_email
                  FROM " . $this->table . " a
                  JOIN users u ON a.patient_id = u.user_id
                  WHERE a.doctor_id = :doctor_id
                  ORDER BY a.appointment_date ASC, a.appointment_time ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Count pending appointments for the banner
    public function countPending($doctor_id) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE doctor_id = :doctor_id AND status = 'pending'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>