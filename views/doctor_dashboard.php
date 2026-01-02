<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard - TechSpace</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body> <style>body { display: block; }</style> 

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>Doctor Panel</h3>
            <a href="#" class="active">Dashboard</a>
            <a href="#">My Schedule</a>
            <a href="#">Appointments</a>
            <a href="#">Patients</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <div class="welcome-banner">
                <h2>Welcome, Dr. Ratul!</h2>
                <p>You have 3 pending appointments today.</p>
            </div>

            <h3 class="section-title">Today's Schedule</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient Name</th>
                        <th>Problem</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10:00 AM</td>
                        <td>John Doe</td>
                        <td>Fever & Flu</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>
                            <button style="color:green;">Approve</button> 
                            <button style="color:red;">Reject</button>
                        </td>
                    </tr>
                    <tr>
                        <td>11:30 AM</td>
                        <td>Jane Smith</td>
                        <td>Dental Checkup</td>
                        <td><span class="status-badge status-confirmed">Confirmed</span></td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>

            <br><br>

            <h3 class="section-title">Update Availability</h3>
            <div style="background:white; padding:1rem; border-radius:8px;">
                <label>Set Available Date:</label>
                <input type="date" style="padding:5px;">
                <button class="btn-primary" style="width:auto; margin-top:0;">Add Slot</button>
            </div>
        </div>
    </div>
</body>
</html>