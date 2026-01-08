<?php
require_once 'config/Database.php';
require_once 'helpers/TimeSlotGenerator.php';

class AjaxController {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getSlots() {
        $doctor_id = $_GET['doctor_id'];
        $date = $_GET['date'];

        // 1. Get Doctor's Working Hours for that date
        $query = "SELECT start_time, end_time FROM availability 
                  WHERE doctor_id = :did AND available_date = :date LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':did' => $doctor_id, ':date' => $date]);
        $availability = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$availability) {
            echo json_encode([]); // Doctor not working today
            exit;
        }

        // 2. Get Booked Appointments for that date
        $query2 = "SELECT appointment_time FROM appointments 
                   WHERE doctor_id = :did AND appointment_date = :date AND status != 'cancelled' AND status != 'rejected'";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->execute([':did' => $doctor_id, ':date' => $date]);
        $booked = $stmt2->fetchAll(PDO::FETCH_COLUMN); // Returns array like ['10:00:00', '10:15:00']

        // 3. Calculate Free Slots
        $generator = new TimeSlotGenerator();
        $freeSlots = $generator->generateSlots($availability['start_time'], $availability['end_time'], $booked);

        // 4. Return JSON
        echo json_encode($freeSlots);
    }

    public function getDates() {
        if(!isset($_GET['doctor_id'])) return;

        $doctor_id = $_GET['doctor_id'];
        
        // Fetch only dates where doctor works AND date is today or future
        $query = "SELECT DISTINCT available_date FROM availability 
                  WHERE doctor_id = :did AND available_date >= CURDATE() 
                  ORDER BY available_date ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':did' => $doctor_id]);
        
        $dates = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo json_encode($dates);
    }
}
?>