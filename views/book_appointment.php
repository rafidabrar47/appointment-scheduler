<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Appointment - TechSpace</title>
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
            <h3>Patient Panel</h3>
            <a href="index.php?action=dashboard_patient">My Appointments</a>
            <a href="index.php?action=book_appointment" class="active">Book New</a>
            <a href="index.php?action=profile">My Profile</a>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>

        <div class="main-content">
            <h2 class="section-title">Book a New Appointment</h2>

            <div class="dashboard-form-container">
                <form action="index.php?action=book_submit" method="POST">
                    
                    <div class="form-group">
                        <label>Select Specialist</label>
                        <select name="doctor_id" id="doctorSelect" class="form-control" required>
                            <option value="">-- Choose a Doctor --</option>
                            <?php foreach ($doctors as $doc): ?>
                                <option value="<?php echo $doc['user_id']; ?>">
                                    <?php echo htmlspecialchars($doc['full_name']); ?> (<?php echo htmlspecialchars($doc['specialization']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select Date</label>
                        <select name="date" id="dateSelect" class="form-control" required>
                            <option value="">-- Select Doctor First --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Available Slots</label>
                        <select name="time" id="timeSelect" class="form-control" required>
                            <option value="">-- Select Date First --</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    const docSelect = document.getElementById('doctorSelect');
    const dateSelect = document.getElementById('dateSelect');
    const timeSelect = document.getElementById('timeSelect');

    // 1. When Doctor changes -> Fetch Dates
    docSelect.addEventListener('change', function() {
        const doctorId = this.value;
        
        // Reset subsequent dropdowns
        dateSelect.innerHTML = '<option>Loading dates...</option>';
        timeSelect.innerHTML = '<option value="">-- Select Date First --</option>';
        
        if(doctorId) {
            fetch(`index.php?action=api_get_dates&doctor_id=${doctorId}`)
                .then(res => res.json())
                .then(data => {
                    dateSelect.innerHTML = '<option value="">-- Select Available Date --</option>';
                    if(data.length === 0) {
                        dateSelect.innerHTML += '<option disabled>No availability found</option>';
                    } else {
                        data.forEach(d => {
                            dateSelect.innerHTML += `<option value="${d}">${d}</option>`;
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    dateSelect.innerHTML = '<option disabled>Error loading dates</option>';
                });
        } else {
            dateSelect.innerHTML = '<option value="">-- Select Doctor First --</option>';
        }
    });

    // 2. When Date changes -> Fetch Time Slots
    dateSelect.addEventListener('change', function() {
        const date = this.value;
        const doctorId = docSelect.value;
        
        timeSelect.innerHTML = '<option>Loading slots...</option>';

        if(date && doctorId) {
            fetch(`index.php?action=api_get_slots&doctor_id=${doctorId}&date=${date}`)
                .then(res => res.json())
                .then(data => {
                    timeSelect.innerHTML = '<option value="">-- Select Time --</option>';
                    if(data.length === 0) {
                        timeSelect.innerHTML += '<option disabled>No slots available</option>';
                    } else {
                        data.forEach(slot => {
                            timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    timeSelect.innerHTML = '<option disabled>Error loading slots</option>';
                });
        }
    });
    </script>
</body>
</html>