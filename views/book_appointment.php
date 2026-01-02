<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Appointment</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container" style="max-width: 500px;"> <div class="auth-header">
            <h2>Book Appointment</h2>
            <p>Select a doctor and time</p>
        </div>

        <form action="index.php?action=book_submit" method="POST">
            
            <div class="form-group">
                <label>Select Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <option value="">-- Choose a Specialist --</option>
                    <?php foreach ($doctors as $doc): ?>
                        <option value="<?php echo $doc['user_id']; ?>">
                            <?php echo htmlspecialchars($doc['full_name']); ?> (<?php echo htmlspecialchars($doc['specialization']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label>Time</label>
                <input type="time" name="time" class="form-control" required>
            </div>

            <button type="submit" class="btn-primary">Confirm Booking</button>
            
            <div class="auth-footer">
                <a href="index.php?action=dashboard_patient">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>