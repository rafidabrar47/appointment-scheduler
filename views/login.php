<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Appointment Scheduler</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="auth-container">
        <div class="auth-header">
            <h2>Welcome Back</h2>
            <p>Please login to your account</p>
        </div>

        <form action="index.php?action=login_submit" method="POST">
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn-primary">Login</button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="index.php?action=register">Register here</a></p>
        </div>
    </div>

</body>
</html>