<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Appointment</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container" style="max-width: 500px;">
        <div class="auth-header">
            <h2>Book Appointment</h2>
            <p>Select a doctor and time</p>
        </div>

        <form action="index.php?action=book_submit" method="POST">
            
            <div class="form-group">
                <label>Select Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <option value="">-- Choose a Specialist --</option>
                    <?php foreach ($doctors as $doc): ?>
                        <option value="<?php echo $doc['user_id']; ?>">
                            <?php echo htmlspecialchars($doc['full_name']); ?> (<?php echo htmlspecialchars($doc['specialization']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label>Available Slots</label>
                <select name="time" class="form-control" required>
                    <option value="">-- Select Date First --</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">Confirm Booking</button>
            
            <div class="auth-footer">
                <a href="index.php?action=dashboard_patient">Cancel</a>
            </div>
        </form>
    </div>

    <script>
    const dateInput = document.querySelector('input[name="date"]');
    const doctorSelect = document.querySelector('select[name="doctor_id"]');
    const timeSelect = document.querySelector('select[name="time"]');

    // Function to fetch slots
    function fetchSlots() {
        const date = dateInput.value;
        const doctorId = doctorSelect.value;

        // Only run if both Doctor and Date are selected
        if(date && doctorId) {
            // Show "Loading..." text
            timeSelect.innerHTML = '<option>Loading slots...</option>';

            // Call your new API
            fetch(`index.php?action=api_get_slots&doctor_id=${doctorId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    // Reset the dropdown
                    timeSelect.innerHTML = '<option value="">-- Select Time --</option>';

                    if(data.length === 0) {
                        timeSelect.innerHTML += '<option disabled>No slots available</option>';
                    } else {
                        // Loop through the slots (e.g., "10:00 AM", "10:15 AM")
                        data.forEach(slot => {
                            // The backend sends readable time, we use it for both value and display
                            timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    timeSelect.innerHTML = '<option disabled>Error loading slots</option>';
                });
        }
    }

    // Listen for changes on Date or Doctor
    dateInput.addEventListener('change', fetchSlots);
    doctorSelect.addEventListener('change', fetchSlots);
    </script>
</body>
</html>