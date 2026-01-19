<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile - TechSpace</title>
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
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <h3>Admin Panel</h3>
                <a href="index.php?action=dashboard_admin">Overview</a>
                <a href="index.php?action=admin_doctors">Doctors List</a>
                <a href="index.php?action=admin_patients">Patients List</a>
            <?php elseif ($_SESSION['role'] === 'doctor'): ?>
                <h3>Doctor Panel</h3>
                <a href="index.php?action=dashboard_doctor">Appointments</a>
                <a href="index.php?action=doctor_availability">My Schedule</a>
            <?php else: ?>
                <h3>Patient Panel</h3>
                <a href="index.php?action=dashboard_patient">My Appointments</a>
                <a href="index.php?action=book_appointment">Book New</a>
            <?php endif; ?>
            
            <a href="index.php?action=profile" class="active">My Profile</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <h2 class="section-title">Edit Profile</h2>

            <div class="dashboard-form-container">
                <form action="index.php?action=profile_submit" method="POST">
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>New Password <small>(Leave blank to keep current)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="••••••">
                    </div>

                    <button type="submit" class="btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>