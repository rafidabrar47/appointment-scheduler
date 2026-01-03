<?php
// models/Availability.php
require_once 'config/Database.php';

class Availability {
    private $conn;
    private $table = 'availability';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Set new availability slot
    public function setAvailability($doctor_id, $date, $start, $end) {
        // Optional: Check if already exists for this date to prevent duplicates
        $checkQuery = "SELECT * FROM " . $this->table . " WHERE doctor_id = :did AND available_date = :date";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->execute([':did' => $doctor_id, ':date' => $date]);
        
        if($stmtCheck->rowCount() > 0) {
            return false; // Already set for this day
        }

        $query = "INSERT INTO " . $this->table . " (doctor_id, available_date, start_time, end_time) 
                  VALUES (:did, :date, :start, :end)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':did', $doctor_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>