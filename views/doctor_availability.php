<!DOCTYPE html>
<html lang="en">
<head>
    <title>Set Schedule</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container" style="max-width: 500px;">
        <div class="auth-header">
            <h2>Set Weekly Schedule</h2>
            <p>Choose a date range and your working hours.</p>
        </div>

        <form action="index.php?action=availability_submit" method="POST">
            
            <div class="form-group">
                <label>From Date</label>
                <input type="date" name="start_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label>To Date</label>
                <input type="date" name="end_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                <small style="color:#666;">Select the same date if setting for 1 day only.</small>
            </div>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

            <div class="form-group">
                <label>Start Time</label>
                <select name="start_time" class="form-control" required>
                    <?php 
                    for($i=8; $i<=20; $i++) {
                        $time = sprintf("%02d:00:00", $i);
                        $label = date("h:i A", strtotime($time));
                        echo "<option value='$time'>$label</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>End Time</label>
                <select name="end_time" class="form-control" required>
                    <?php 
                    for($i=9; $i<=21; $i++) {
                        $time = sprintf("%02d:00:00", $i);
                        $label = date("h:i A", strtotime($time));
                        echo "<option value='$time'>$label</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn-primary">Save Schedule</button>
            
            <div class="auth-footer">
                <a href="index.php?action=dashboard_doctor">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>