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
            <a href="#">Book New</a>
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
                    <tr>
                        <td>Oct 24, 2025</td>
                        <td>10:00 AM</td>
                        <td>Dr. Adnan Ratul</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td>Sep 12, 2025</td>
                        <td>11:30 AM</td>
                        <td>Dr. Sarah Khan</td>
                        <td><span class="status-badge status-confirmed">Confirmed</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>