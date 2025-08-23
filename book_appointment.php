<?php
session_start();
require("db.php");

// Initialize variables
$success_message = '';
$error_message = '';
$redirect = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'book_appointment') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $error_message = 'You must be logged in to book an appointment.';
    } else {
        // Get user_id from session
        $user_id = $_SESSION['user_id'];
        
        // Get form data
        $parent_name = $_POST['petParentsName'];
        $email = $_POST['email'];
        $phone_number = $_POST['phoneNumber'];
        $pet_name = $_POST['petName'];
        
        // Calculate pet age in months for database storage
        $pet_age_years = intval($_POST['petAgeYear']);
        $pet_age_months = intval($_POST['petAgeMonth']);
        $pet_age = ($pet_age_years * 12) + $pet_age_months; // Store as total months
        
        $pet_type = $_POST['petType'];
        $problem = $_POST['problemDescription'];
        $previous_treatment = $_POST['oldTreatment'];
        $doctor = $_POST['doctorName'];
        $appointment_date = $_POST['appointmentDate'];
        $appointment_time = $_POST['appointmentTime'];
        
        // Insert into database
        $sql = "INSERT INTO appointments (user_id, parent_name, email, phone_number, pet_name, pet_age, pet_type, problem, previous_treatment, doctor, appointment_date, appointment_time)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssissssss", $user_id, $parent_name, $email, $phone_number, $pet_name, $pet_age, $pet_type, $problem, $previous_treatment, $doctor, $appointment_date, $appointment_time);
        
        if ($stmt->execute()) {
            $success_message = "Appointment for <strong>$pet_name</strong> with <strong>$doctor</strong> on <strong>$appointment_date</strong> at <strong>$appointment_time</strong>.";
            $redirect = true; // Set flag for redirection
        } else {
            $error_message = 'Error booking appointment: ' . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment - KittyPups</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: #4e73df;
            color: white;
            padding: 1rem;
            text-align: center;
            margin-bottom: 2rem;
            border-radius: 5px;
        }
        
        .appointment-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #4e73df;
        }
        
        .appointment-form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .pet-age-group {
            display: flex;
            gap: 0.5rem;
        }
        
        .pet-age-group input {
            flex: 1;
        }
        
        .full-width {
            grid-column: span 2;
        }
        
        .submit-btn {
            grid-column: span 2;
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: #3a56c4;
        }
        
        .appointments-table {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fc;
            font-weight: 600;
        }
        
        tr:hover {
            background-color: #f6f9ff;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }
        
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-btn:hover {
            color: black;
        }
        
        .back-to-home-btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #4e73df;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        
        .tabs {
            display: flex;
            margin-bottom: 1rem;
        }
        
        .tab-btn {
            padding: 0.75rem 1.5rem;
            background-color: #e9ecef;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .tab-btn.active {
            background-color: #4e73df;
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        
        .alert-error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
        
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        
        .success-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 1001;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .success-notification i {
            font-size: 20px;
        }
        
        .countdown {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php if ($redirect): ?>
    <!-- Success Notification -->
    <div class="success-notification" id="successNotification">
        <i class="fas fa-check-circle"></i>
        <span>Appointment booked successfully! Redirecting in <span class="countdown" id="countdown">3</span> seconds...</span>
    </div>
    <?php endif; ?>
    
    <div class="container">
        <header  style="background:#df4e4e;">
            <h1>KittyPups Veterinary Clinic</h1>
        </header>
        
        <!-- Display error/success messages -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success_message) && !$redirect): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
       
        
        <div id="book" class="tab-content active">
            <div class="appointment-container">
                <h2 class="form-title" style="color:#df4e4e;" >Book an Appointment</h2>
                <form id="appointmentForm" class="appointment-form" method="POST" action="">
                    <input type="hidden" name="action" value="book_appointment">
                    
                    <div class="form-group">
                        <label for="petParentsName">Pet Parent's Name</label>
                        <input type="text" id="petParentsName" name="petParentsName" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" required>
                    </div>

                    <div class="form-group">
                        <label for="petName">Pet Name</label>
                        <input type="text" id="petName" name="petName" required>
                    </div>

                    <div class="form-group">
                        <label>Pet Age</label>
                        <div class="pet-age-group">
                            <input type="number" id="petAgeYear" name="petAgeYear" placeholder="Years" min="0">
                            <input type="number" id="petAgeMonth" name="petAgeMonth" placeholder="Months" min="0" max="11">
                            <input type="number" id="petAgeDay" name="petAgeDay" placeholder="Days" min="0" max="30">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="petType">Pet Type</label>
                        <select id="petType" name="petType" required>
                            <option value="">Select Pet</option>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="rabbit">Rabbit</option>
                            <option value="bird">Bird</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="problemDescription">Problem Description</label>
                        <textarea id="problemDescription" name="problemDescription" rows="4" required></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="oldTreatment">Is there any ongoing treatment?</label>
                        <textarea id="oldTreatment" name="oldTreatment" rows="2"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="doctorName">Select a Doctor</label>
                        <select id="doctorName" name="doctorName" required>
                            <option value="">Select Doctor</option>
                            <option value="Dr. Smith">Dr. Smith</option>
                            <option value="Dr. Johnson">Dr. Johnson</option>
                            <option value="Dr. Williams">Dr. Williams</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointmentDate">Appointment Date</label>
                        <input type="date" id="appointmentDate" name="appointmentDate" required>
                    </div>

                    <div class="form-group">
                        <label for="appointmentTime">Appointment Time</label>
                        <input type="time" id="appointmentTime" name="appointmentTime" required>
                    </div>

                    <button type="submit" class="submit-btn">Book Now</button>
                </form>
            </div>
        </div>
        
        <div id="view" class="tab-content">
            <div class="appointments-table">
                <h2 class="form-title">Appointment Records</h2>
                <?php
                // Function to display appointments - only show appointments for logged in user
                function displayAppointments() {
                    global $conn;
                    
                    // Check if user is logged in
                    if (!isset($_SESSION['user_id'])) {
                        echo "<p>Please log in to view your appointments.</p>";
                        return;
                    }
                    
                    $user_id = $_SESSION['user_id'];
                    
                    $sql = "SELECT id, parent_name, email, phone_number, pet_name, pet_age, pet_type, problem, doctor, appointment_date, appointment_time 
                            FROM appointments 
                            WHERE user_id = ?
                            ORDER BY appointment_date DESC, appointment_time DESC";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        echo "<table>
                                <tr>
                                    <th>ID</th>
                                    <th>Pet Parent</th>
                                    <th>Pet Name</th>
                                    <th>Pet Type</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Contact</th>
                                </tr>";
                        
                        while($row = $result->fetch_assoc()) {
                            // Convert pet age from months to readable format
                            $years = floor($row['pet_age'] / 12);
                            $months = $row['pet_age'] % 12;
                            $pet_age_display = $years > 0 ? "$years year" . ($years > 1 ? "s" : "") : "";
                            $pet_age_display .= $months > 0 ? " $months month" . ($months > 1 ? "s" : "") : "";
                            
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['parent_name'] . "</td>
                                    <td>" . $row['pet_name'] . "</td>
                                    <td>" . ucfirst($row['pet_type']) . "</td>
                                    <td>" . $row['doctor'] . "</td>
                                    <td>" . $row['appointment_date'] . "</td>
                                    <td>" . $row['appointment_time'] . "</td>
                                    <td>" . $row['email'] . "<br>" . $row['phone_number'] . "</td>
                                  </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>No appointments found.</p>";
                    }
                    
                    $stmt->close();
                }
                
                // Call the function to display appointments
                displayAppointments();
                ?>
            </div>
        </div>
    </div>

    <script>
        function openTab(tabName) {
            // Hide all tab contents
            var tabContents = document.getElementsByClassName("tab-content");
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove("active");
            }
            
            // Remove active class from all buttons
            var tabButtons = document.getElementsByClassName("tab-btn");
            for (var i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove("active");
            }
            
            // Show the selected tab and mark button as active
            document.getElementById(tabName).classList.add("active");
            event.currentTarget.classList.add("active");
            
            // If viewing appointments, reload the data
            if (tabName === 'view') {
                location.reload();
            }
        }
        
        // Set minimum date to today
        document.getElementById('appointmentDate').min = new Date().toISOString().split('T')[0];
        
        <?php if ($redirect): ?>
        // Countdown and redirect functionality
        let seconds = 2;
        const countdownElement = document.getElementById('countdown');
        const countdownInterval = setInterval(function() {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdownInterval);
                window.location.href = 'index.php';
            }
        }, 1000);
        <?php endif; ?>
    </script>
    
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>