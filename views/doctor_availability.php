<!DOCTYPE html>
<html lang="en">
<head>
    <title>Set Schedule</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .dashboard-form-container {
            max-width: 600px;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <style>body { display: block; }</style> 

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>Doctor Panel</h3>
            <a href="index.php?action=dashboard_doctor">Appointments</a>
            <a href="index.php?action=doctor_availability" class="active">My Schedule</a>
            <a href="index.php?action=profile">My Profile</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <h2 class="section-title">Set Weekly Schedule</h2>

            <div class="dashboard-form-container">
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

                    <div class="form-group">
                        <label>Start Time</label>
                        <select name="start_time" class="form-control" required>
                            <?php 
                            for($i=8; $i<=20; $i++) {
                                $time = sprintf("%02d:00:00", $i);
                                echo "<option value='$time'>".date("h:i A", strtotime($time))."</option>";
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
                                echo "<option value='$time'>".date("h:i A", strtotime($time))."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary">Save Schedule</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>