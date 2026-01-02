<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard - TechSpace</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <style>body { display: block; }</style> 

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>Patient Panel</h3>
            <a href="#" class="active">My Appointments</a>
            <a href="index.php?action=book_appointment">Book New</a>
            <a href="#">Medical Records</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <div class="welcome-banner">
                <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
                <p>Track your health journey here.</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <button class="btn-primary" style="width: auto;">+ Book New Appointment</button>
            </div>

            <h3 class="section-title">My Appointments</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Status</th>
                    </tr>
                </thead>
<tbody>
                    <?php if (!empty($myAppointments)): ?>
                        <?php foreach ($myAppointments as $appt): ?>
                            <tr>
                                <td>
                                    <?php echo date("M d, Y", strtotime($appt['appointment_date'])); ?>
                                </td>
                                
                                <td>
                                    <?php echo date("h:i A", strtotime($appt['appointment_time'])); ?>
                                </td>

                                <td>
                                    <strong><?php echo htmlspecialchars($appt['doctor_name']); ?></strong>
                                </td>

                                <td>
                                    <?php 
                                        // Create a dynamic class name (e.g., status-confirmed)
                                        $statusClass = 'status-' . $appt['status'];
                                        
                                        // Display the status with the correct color
                                        echo "<span class='status-badge $statusClass'>" . ucfirst($appt['status']) . "</span>"; 
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center; color:#888; padding: 20px;">
                                No appointments found. Click "Book New" to start!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>