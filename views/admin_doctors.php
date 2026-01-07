<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Doctors - Admin</title>
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
            <a href="index.php?action=admin_doctors" class="active">Doctors List</a>
            <a href="index.php?action=admin_patients">Patients List</a>
            <a href="index.php?action=admin_user_form&role=admin">Add Admin</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                <h2 class="section-title" style="margin:0;">Manage Doctors</h2>
                <a href="index.php?action=admin_user_form&role=doctor" class="btn-add">+ Add New Doctor</a>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($doctors)): ?>
                        <?php foreach ($doctors as $doc): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($doc['full_name']); ?></td>
                                <td>
                                    <?php 
                                        // Handle case where profile might be missing
                                        echo htmlspecialchars($doc['specialization'] ?? 'N/A'); 
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($doc['email']); ?></td>
                                <td class="action-links">
                                    <a href="index.php?action=admin_user_form&id=<?php echo $doc['user_id']; ?>" style="color:#007bff;">Edit</a>
                                    <a href="index.php?action=admin_delete_user&id=<?php echo $doc['user_id']; ?>" 
                                       style="color:#dc3545;" 
                                       onclick="return confirm('Are you sure you want to delete this doctor? This cannot be undone.');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center; padding: 20px;">No doctors found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>