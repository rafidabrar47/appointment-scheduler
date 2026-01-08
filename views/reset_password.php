<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h2>Reset Password</h2>
            <p>Enter your email to set a new password.</p>
        </div>
        <form action="index.php?action=reset_password_submit" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="New secure password" required>
            </div>
            <button type="submit" class="btn-primary">Update Password</button>
        </form>
        <div class="auth-footer">
            <a href="index.php?action=login">Back to Login</a>
        </div>
    </div>
</body>
</html>