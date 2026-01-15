<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile - TechSpace</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container" style="max-width: 500px;">
        <div class="auth-header">
            <h2>Edit Profile</h2>
            <p>Update your personal information</p>
        </div>

        <form action="index.php?action=profile_submit" method="POST">
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

            <div class="form-group">
                <label>New Password <small>(Leave blank to keep current)</small></label>
                <input type="password" name="password" class="form-control" placeholder="••••••">
            </div>

            <button type="submit" class="btn-primary">Save Changes</button>
            
            <div class="auth-footer">
                <?php
                    // Determine where the "Back" button goes based on role
                    $role = $_SESSION['role'];
                    $dashboardLink = 'index.php?action=login'; // Default
                    if ($role == 'admin') $dashboardLink = 'index.php?action=dashboard_admin';
                    if ($role == 'doctor') $dashboardLink = 'index.php?action=dashboard_doctor';
                    if ($role == 'patient') $dashboardLink = 'index.php?action=dashboard_patient';
                ?>
                <a href="<?php echo $dashboardLink; ?>">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>