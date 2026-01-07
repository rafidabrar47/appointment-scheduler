<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - TechSpace</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Extra styles for Admin Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-number { font-size: 2rem; font-weight: bold; color: #dc3545; }
        .sidebar { background-color: #212529; } /* Darker sidebar for Admin */
    </style>
</head>
<body>
    <style>body { display: block; }</style> 

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <a href="#" class="active">Overview</a>
            <a href="index.php?action=admin_doctors">Doctors List</a>
            <a href="index.php?action=admin_patients">Patients List</a>
            <a href="index.php?action=admin_user_form&role=admin">Add Admin</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <div class="welcome-banner">
                <h2>System Overview</h2>
                <p>Welcome, Administrator.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_doctors']; ?></div>
                    <div>Total Doctors</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_patients']; ?></div>
                    <div>Registered Patients</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_appointments']; ?></div>
                    <div>Total Appointments</div>
                </div>
            </div>

            <h3 class="section-title">Pending Doctor Approvals</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Registered On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pendingDoctors) > 0): ?>
                        <?php foreach ($pendingDoctors as $doc): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($doc['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($doc['email']); ?></td>
                                <td><?php echo htmlspecialchars($doc['specialization']); ?></td>
                                <td><?php echo date("M d, Y", strtotime($doc['created_at'])); ?></td>
                                <td>
                                    <a href="index.php?action=admin_approval&id=<?php echo $doc['user_id']; ?>&status=approve" 
                                       class="btn-primary" 
                                       style="background-color:green; padding: 5px 10px; text-decoration:none; font-size:0.8rem;">
                                       Approve
                                    </a>
                                    <a href="index.php?action=admin_approval&id=<?php echo $doc['user_id']; ?>&status=reject" 
                                       class="btn-primary" 
                                       style="background-color:red; padding: 5px 10px; text-decoration:none; font-size:0.8rem; margin-left:5px;">
                                       Reject
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding:20px;">No pending requests.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>