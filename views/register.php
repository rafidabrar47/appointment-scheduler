<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - TechSpace</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h2>Create Account</h2>
            <p>Join us as a Doctor or Patient</p>
        </div>

        <form action="index.php?action=register_submit" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a password" required>
            </div>

            <div class="form-group">
                <label>I am a...</label>
                <select name="role" id="roleSelect" class="form-control" required onchange="toggleSpecialization()">
                    <option value="patient">Patient</option>
                    <option value="doctor">Doctor</option>
                </select>
            </div>

            <div class="form-group" id="specDiv" style="display:none;">
                <label>Specialization</label>
                <select name="specialization" class="form-control">
                    <option value="General Physician">General Physician</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Dermatologist">Dermatologist</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Orthopedic">Orthopedic</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">Sign Up</button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="index.php?action=login">Login here</a></p>
        </div>
    </div>

    <script>
        function toggleSpecialization() {
            var role = document.getElementById("roleSelect").value;
            var specDiv = document.getElementById("specDiv");
            if(role === "doctor") {
                specDiv.style.display = "block";
            } else {
                specDiv.style.display = "none";
            }
        }
    </script>
</body>
</html>