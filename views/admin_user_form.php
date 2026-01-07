<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage User</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2><?php echo $user ? 'Edit User' : 'Add New User'; ?></h2>
        
        <form action="index.php?action=admin_user_form" method="POST">
            <?php if ($user): ?>
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Role</label>
                <select name="role" id="roleSelect" class="form-control" onchange="toggleSpec()" required>
                    <option value="admin" <?php echo ($user && $user['role']=='admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="doctor" <?php echo (isset($_GET['role']) && $_GET['role']=='doctor') || ($user && $user['role']=='doctor') ? 'selected' : ''; ?>>Doctor</option>
                    <option value="patient" <?php echo (isset($_GET['role']) && $_GET['role']=='patient') || ($user && $user['role']=='patient') ? 'selected' : ''; ?>>Patient</option>
                </select>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $user['full_name'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $user['email'] ?? ''; ?>" required>
            </div>

            <?php if (!$user): ?>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <?php endif; ?>

            <div class="form-group" id="specDiv" style="display:none;">
                <label>Specialization</label>
                <select name="specialization" class="form-control">
                    <?php 
                        $specs = ['General Physician', 'Cardiologist', 'Dermatologist', 'Neurologist', 'Orthopedic'];
                        foreach($specs as $s) {
                            $selected = ($user && isset($user['specialization']) && $user['specialization'] == $s) ? 'selected' : '';
                            echo "<option value='$s' $selected>$s</option>";
                        }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn-primary">Save User</button>
            <br><br>
            <?php 
                $backLink = 'index.php?action=dashboard_admin';
                if(isset($_GET['role'])) {
                    if($_GET['role'] == 'doctor') $backLink = 'index.php?action=admin_doctors';
                    if($_GET['role'] == 'patient') $backLink = 'index.php?action=admin_patients';
                }
            ?>
            <a href="<?php echo $backLink; ?>">Cancel</a>
        </form>
    </div>

    <script>
        function toggleSpec() {
            var role = document.getElementById("roleSelect").value;
            // Only show specialization if role is 'doctor'
            document.getElementById("specDiv").style.display = (role === "doctor") ? "block" : "none";
        }
        
        // Run immediately on page load to set correct state
        toggleSpec();
    </script>
</body>
</html>