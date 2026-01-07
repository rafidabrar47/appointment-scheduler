<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Patients - Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .sidebar { background-color: #212529; }
        .action-links a { text-decoration: none; margin-right: 10px; font-weight: bold; }
        .btn-add { background-color: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <style>body { display: block; }</style> 

    <div class="dashboard-container">
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <a href="index.php?action=dashboard_admin">Overview</a>
            <a href="index.php?action=admin_doctors">Doctors List</a>
            <a href="index.php?action=admin_patients" class="active">Patients List</a>
            <a href="index.php?action=admin_user_form&role=admin">Add Admin</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                <h2 class="section-title" style="margin:0;">Manage Patients</h2>
                <a href="index.php?action=admin_user_form&role=patient" class="btn-add">+ Add New Patient</a>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($patients)): ?>
                        <?php foreach ($patients as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($p['email']); ?></td>
                                <td class="action-links">
                                    <a href="index.php?action=admin_user_form&id=<?php echo $p['user_id']; ?>" style="color:#007bff;">Edit</a>
                                    <a href="index.php?action=admin_delete_user&id=<?php echo $p['user_id']; ?>" 
                                       style="color:#dc3545;" 
                                       onclick="return confirm('Are you sure you want to delete this patient? All their appointments will be deleted too.');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center; padding: 20px;">No patients found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>