<?php
class TimeSlotGenerator {
    
    // Duration in minutes
    private $interval = 15; 

    public function generateSlots($startTime, $endTime, $bookedSlots = []) {
        $slots = [];
        $current = strtotime($startTime);
        $end = strtotime($endTime);

        while ($current < $end) {
            $slotTime = date("H:i:s", $current);
            
            // Logic: Is this specific time already in the booked array?
            if (!in_array($slotTime, $bookedSlots)) {
                $slots[] = date("h:i A", $current); // Readable Format (09:00 AM)
            }

            // Jump 15 minutes
            $current = strtotime("+$this->interval minutes", $current);
        }
        
        return $slots;
    }
}
?>