<!DOCTYPE html>
<html lang="en">
<head>
    <title>Set Availability</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container" style="max-width: 500px;">
        <div class="auth-header">
            <h2>Set Your Schedule</h2>
            <p>Choose your working hours for a specific date.</p>
        </div>

        <form action="index.php?action=availability_submit" method="POST">
            
            <div class="form-group">
                <label>Select Date</label>
                <input type="date" name="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label>Available From (Start)</label>
                <select name="start_time" class="form-control" required>
                    <?php 
                    // Generate hours from 08:00 AM to 08:00 PM
                    for($i=8; $i<=20; $i++) {
                        $time = sprintf("%02d:00:00", $i);
                        $label = date("h:i A", strtotime($time));
                        echo "<option value='$time'>$label</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Available To (End)</label>
                <select name="end_time" class="form-control" required>
                    <?php 
                    // Generate hours from 09:00 AM to 09:00 PM
                    for($i=9; $i<=21; $i++) {
                        $time = sprintf("%02d:00:00", $i);
                        $label = date("h:i A", strtotime($time));
                        echo "<option value='$time'>$label</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn-primary">Save Availability</button>
            
            <div class="auth-footer">
                <a href="index.php?action=dashboard_doctor">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>