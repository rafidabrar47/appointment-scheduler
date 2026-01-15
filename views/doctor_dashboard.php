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
            <a href="index.php?action=doctor_availability">My Schedule</a>
            <a href="index.php?action=profile">My Profile</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <div class="welcome-banner">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
                
                <p>You have <strong><?php echo $pendingCount; ?></strong> pending appointments.</p>
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
                    <?php if (count($appointments) > 0): ?>
                        <?php foreach ($appointments as $appt): ?>
                            <tr>
                                <td><?php echo date("h:i A", strtotime($appt['appointment_time'])); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($appt['patient_name']); ?>
                                    <br>
                                    <small style="color:#888;"><?php echo htmlspecialchars($appt['patient_email']); ?></small>
                                </td>
                                <td>General Checkup</td> <td>
                                    <?php 
                                        $statusClass = 'status-' . $appt['status'];
                                        echo "<span class='status-badge $statusClass'>" . ucfirst($appt['status']) . "</span>"; 
                                    ?>
                                </td>
                                <td>
                                    <?php if ($appt['status'] == 'pending'): ?>
                                        <a href="index.php?action=update_status&id=<?php echo $appt['appointment_id']; ?>&status=confirmed" style="color:green; font-weight:bold; margin-right:10px;">Approve</a>
                                        <a href="index.php?action=update_status&id=<?php echo $appt['appointment_id']; ?>&status=rejected" style="color:red; font-weight:bold;">Reject</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">No appointments found.</td></tr>
                    <?php endif; ?>
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