<?php
session_start();
require('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch current user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Handle form submission for updating appointment status
if (isset($_POST['update_appointment_status'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $status = $_POST['status'] === '' ? NULL : intval($_POST['status']);

    if ($status === NULL) {
        $sql = "UPDATE appointments SET status = NULL WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $appointment_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $_SESSION['message'] = "Appointment status updated successfully!";
        } else {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
        }
    } else {
        $sql = "UPDATE appointments SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $status, $appointment_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $_SESSION['message'] = "Appointment status updated successfully!";
        } else {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
        }
    }

  
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Doctor Dashboard — KittyPups</title>

  <!-- Bootstrap CSS (5.3) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root{
      --bg: #fbf8f8;               /* light background */
      --card: #ffffff;
      --accent-red: #d9252a;       /* main red accent */
      --accent-pink: #ffd6d8;
      --muted: #6c6c6c;
      --shadow: rgba(16,24,40,0.06);
      --glass: rgba(255,255,255,0.8);
    }

    /* html,body { height:100%; } */
    body{
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,var(--bg), #fff);
      color: #222;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* Navbar */
    .navbar-doctor{
      background: linear-gradient(90deg, rgba(217,37,42,0.95), rgba(255,140,149,0.95));
      color: #fff;
      border-bottom-left-radius: 12px;
      border-bottom-right-radius: 12px;
      box-shadow: 0 6px 20px var(--shadow);
    }
    .navbar-doctor .navbar-brand { font-weight:700; letter-spacing:0.2px; color:#fff; }
    .navbar-doctor .nav-link, .navbar-doctor .navbar-text { color: rgba(255,255,255,0.95); }

    /* Layout */
    .container-main { max-width:1200px; margin-top:28px; margin-bottom:40px; }

    .card-clean{
      background:var(--card);
      border-radius:12px;
      box-shadow: 0 6px 20px var(--shadow);
      border: none;
    }

    .metric {
      border-radius:12px;
      padding:18px;
      background: linear-gradient(180deg, rgba(255,214,215,0.9), #fff);
      display:flex; align-items:center; gap:16px;
    }
    .metric h3 { margin:0; color:var(--accent-red); font-size:1.6rem; }
    .metric small { color:var(--muted); display:block; }

    .btn-accent {
      background: linear-gradient(90deg,var(--accent-red), #ff6b6b);
      color:#fff; border-radius:10px; border:none;
    }
    .btn-accent:hover { background:#c31f20; color:#fff; }

    /* patient list */
    .patient-card {
      border-radius:10px; padding:12px; margin-bottom:12px; cursor:pointer;
      transition: transform .12s ease, box-shadow .12s ease;
      background: linear-gradient(180deg, #fff, var(--accent-pink));
    }
    .patient-card:hover { transform:translateY(-4px); box-shadow:0 10px 30px rgba(0,0,0,0.06); }

    .empty-state { padding:40px 20px; color:var(--muted); text-align:center; }

    /* small utilities */
    .muted { color:var(--muted); }
    .small-muted { font-size:.86rem; color:var(--muted); }

    /* last item card */
    .last-card { background:#fff7f7; border:1px dashed rgba(217,37,42,0.12); padding:14px; border-radius:8px; }


    .grad-color{
     background: linear-gradient(180deg, #fff, var(--accent-pink)) !important;
    }


    /* responsive adjustments */
    @media (max-width:767px){
      .metric h3 { font-size:1.25rem; }
      .navbar-doctor .navbar-brand { font-size:1rem; }
    }

    /* Footer css starts */

footer {

  background:  #ffffff;
  color: #5555;
  margin-top: 40px;
  padding: 40px 0 0;
}

footer .container {
  max-width: 1200px !important;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  padding: 0 15px;
}

.footer-col {
  flex: 1;
  min-width: 200px;
}

.about-footer {
  max-width: 300px;
}



.footer p{
  color:black;
}

.footer-col h4 {
  margin-bottom: 20px;
  font-weight: 600;
    color: #EB1F48 !important;
}

.footer-col ul {
  list-style: none;
  padding: 0;
}

.footer-col ul li {
  margin-bottom: 10px;
}

.footer-col ul li a {
  color: #0A58CA;
  text-decoration: none;
  transition: color 0.3s;
}

.footer-col p{
  color:black !important;
}

.footer-col ul li a:hover {
  color: white;
}


.logo {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.logo img {
  height: 50px;
  margin-right: 15px;
}

.logo-text span {
  font-weight: bold;
  font-size: 1.2rem;
}

.logo-text p {
  margin: 0;
  opacity: 0.8;
}

.social-icons {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

.social-icons a {
  color: white;
  font-size: 1.2rem;
}

.app-links a {
  display: block;
  margin-bottom: 10px;
}

.app-links img {
  max-width: 120px;
  height: auto;
}

.bottom-bar {
  background: rgba(0,0,0,0.2);
  padding: 15px 0;
  margin-top: 40px;
}

.bottom-bar .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.payment-icons img {
  max-width: 200px;
}

/* Responsive adjustments for footer */
@media (max-width: 767px) {
  footer .container {
    flex-direction: column;
  }
  
  .bottom-bar .container {
    flex-direction: column;
    text-align: center;
    gap: 15px;
  }
}
    /* Footer css ends */


  </style>
</head>
<body>

  <!-- NAV -->
  <nav class="navbar navbar-expand-lg navbar-doctor">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="fas fa-user-md me-2"></i>Doctor Dashboard — KittyPups</a>
      <div class="d-flex align-items-center ms-auto">
        <div class="navbar-text small-muted me-3"><strong> Doctor </strong></div>
        <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
      </div>
    </div>
  </nav>


<?php
date_default_timezone_set('Asia/Dhaka'); // optional but recommended for "today"
$conn = mysqli_connect("localhost","root","","kittypups");
if (!$conn) die("DB conn failed");

$sql = "SELECT COUNT(*) AS total FROM appointments WHERE appointment_date = CURDATE()";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
// echo "Today's appointments: " . intval($row['total']);


?>
















  <!-- MAIN WRAPPER -->
  <div class="container container-main">
    <!-- overview metrics -->
    <div class="row g-4 mb-4">
      <div class="col-lg-4">
        <div class="card-clean p-3">
          <h6 class="small-muted mb-2">Overview</h6>
          <div class="row g-2">
            <div class="col-12 metric">
              <div class="flex-grow-1">
                <small>Today's Appointments</small>
                <h3 id="today-appointments-count">0</h3>
              </div>
              <div class="text-end">
                <i class="fas fa-calendar-check fa-2x" style="color:var(--accent-red)"></i>
              </div>
            </div>
            <div class="col-12 metric mt-2">
              <div class="flex-grow-1">
                <small>Total Patients</small>
                <h3 id="total-patients-count"><?php intval($row['total']) ?> </h3>
              </div>
              <div class="text-end">
                <i class="fas fa-hospital-user fa-2x" style="color:var(--accent-red)"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- urgent / quick actions -->
      <div class="col-lg-8">
        <div class="card-clean p-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h5 class="mb-1">Quick Actions</h5>
              <p class="small-muted mb-0">Create prescriptions, upload reports, and view recent activity.</p>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i class="fas fa-user-plus me-2"></i>Add Patient</button>
              <button class="btn btn-outline-secondary" id="btnOpenPrescriptionModal"><i class="fas fa-prescription-bottle-alt me-2"></i>New Prescription</button>
            </div>
          </div>

          <hr class="my-3" />

          <div class="d-flex gap-3 flex-wrap">
            <div class="last-card flex-grow-1">
              <small class="small-muted">Last Prescription</small>
              <div id="lastPrescriptionCard" class="mt-2"><p class="text-muted mb-0">No prescriptions yet.</p></div>
            </div>

            <div class="last-card" style="min-width:200px;">
              <small class="small-muted">Last Report</small>
              <div id="lastReportCard" class="mt-2"><p class="text-muted mb-0">No reports yet.</p></div>
            </div>
          </div>

        </div>
      </div>
    </div>



    <div class="row">

            <!-- Appointment Table Starts -->
         
        
    <h3 class="mt-2 text-center">All Appointments</h3>
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0 text-center grad-color py-3">Appointment Management</h5>
      </div>
      <div class="card-body grad-color">
        <div class="table-responsive">
          <table class="table table-hover appointment-table grad-color">
            <thead>
              <tr>
        
                <th>User ID</th>
                <th>Parent Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Pet Name</th>
                <th>Pet Type</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              
              
              $appointments = mysqli_query($conn, "SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC");
              if (mysqli_num_rows($appointments) > 0) {
                while($app = mysqli_fetch_assoc($appointments)) {
                  // Determine status class and text
                  $status_class = '';
                  $status_text = '';
                  $status_value = $app['status'];
                  
                  if ($status_value === NULL) {
                    $status_class = 'status-pending';
                    $status_text = 'Pending';
                    $status_value = 0; // show as Pending in dropdown
                  } else {
                    switch($status_value) {
                      case 0: 
                        $status_class = 'status-pending';
                        $status_text = 'Pending';
                        break;
                        case 1: 
                          $status_class = 'status-confirmed';
                          $status_text = 'Confirmed';
                          break;
                          default:
                          $status_class = 'status-null';
                          $status_text = 'Unknown';
                          break;
                        }
                      }
                      
                      echo "<tr class=`grad-color`>
                      <td>{$app['id']}</td>
                      <td>{$app['user_id']}</td>
                      <td>{$app['parent_name']}</td>
                      <td>{$app['email']}</td>
                      <td>{$app['phone_number']}</td>
                      <td>{$app['pet_name']}</td>
                      <td>{$app['pet_type']}</td>
                      <td>{$app['appointment_date']}</td>
                      <td>{$app['appointment_time']}</td>
                      <td>
                      <form method='POST' onchange='this.submit()'>
                      <input type='hidden' name='update_appointment_status' value='1'>
                      <input type='hidden' name='appointment_id' value='{$app['id']}'>
                      <select name='status' class='form-select form-select-sm'>
                      <option value='0' " . ($app['status'] === NULL || $app['status'] == 0 ? 'selected' : '') . ">Pending</option>
                      <option value='1' " . ($app['status'] == 1 ? 'selected' : '') . ">Confirmed</option>
                      
                      </select>
                      </form>
                      </td>
                      
                      </tr>";
                      
                      // Modal for appointment details
                      echo "
                      <div class='modal fade' id='detailsModal{$app['id']}' tabindex='-1' aria-labelledby='detailsModalLabel{$app['id']}' aria-hidden='true'>
                      <div class='modal-dialog modal-lg'>
                      <div class='modal-content'>
                      <div class='modal-header'>
                      <h5 class='modal-title' id='detailsModalLabel{$app['id']}'>Appointment Details #{$app['id']}</h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                      </div>
                      <div class='modal-body'>
                      <div class='row'>
                      <div class='col-md-6'>
                      <h6>Pet Information</h6>
                      <p><strong>Name:</strong> {$app['pet_name']}</p>
                      <p><strong>Age:</strong> {$app['pet_age']}</p>
                    <p><strong>Type:</strong> {$app['pet_type']}</p>
                    </div>
                    <div class='col-md-6'>
                    <h6>Owner Information</h6>
                    <p><strong>Name:</strong> {$app['parent_name']}</p>
                    <p><strong>Email:</strong> {$app['email']}</p>
                    <p><strong>Phone:</strong> {$app['phone_number']}</p>
                    </div>
                    </div>
                    <div class='row mt-3'>
                    <div class='col-12'>
                    <h6>Medical Information</h6>
                    <p><strong>Problem:</strong> {$app['problem']}</p>
                    <p><strong>Previous Treatment:</strong> " . ($app['previous_treatment'] ? $app['previous_treatment'] : 'None') . "</p>
                    <p><strong>Doctor:</strong> {$app['doctor']}</p>
                    </div>
                    </div>
                    <div class='row mt-3'>
                    <div class='col-md-6'>
                    <h6>Appointment Details</h6>
                    <p><strong>Date:</strong> {$app['appointment_date']}</p>
                    <p><strong>Time:</strong> {$app['appointment_time']}</p>
                    <p><strong>Status:</strong> <span class='status-badge {$status_class}'>{$status_text}</span></p>
                    </div>
                    </div>
                    </div>
                    <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                    </div>
                    </div>
                    </div>
                    </div>";
                  }
                } else {
                  echo "<tr><td colspan='11' class='text-center'>No appointments found</td></tr>";
                }
                ?>
            </tbody>
          </table>
        </div>
    </div>

  


        
        <!-- Appointment Table Ends -->
    </div>



    <!-- two-column main area: left = patients + search, right = forms & lists -->
    <div class="row g-4">
      <!-- LEFT: Patients list -->
      <div class="col-lg-4">
        <div class="card-clean p-3">
          <div class="d-flex align-items-center mb-3">
            <h5 class="mb-0 me-2">Patients</h5>
            <span class="small-muted ms-auto">Manage your patients</span>
          </div>

          <div class="mb-3">
            <input id="patientSearch" type="search" class="form-control form-control-sm" placeholder="Search patient or pet name...">
          </div>

          <div id="patientList" style="max-height:520px; overflow:auto;">
            <!-- Patients will be appended here -->
          </div>
        </div>
      </div>

      <!-- RIGHT: Forms / Appointments / History -->
      <div class="col-lg-8">
        <div class="card-clean p-3">
          <h5 class="mb-3">Create Prescription</h5>

          <form id="prescriptionForm">
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Pet Name</label>
                <input id="prescriptionPetName" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Age</label>
                <input id="prescriptionPetAge" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Pet Type</label>
                <select id="prescriptionPetType" class="form-select" required>
                  <option value="" selected disabled>Choose...</option>
                  <option>Dog</option><option>Cat</option><option>Rabbit</option><option>Bird</option><option>Other</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Current Disease / Condition</label>
                <textarea id="currentDisease" class="form-control" rows="2" required></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Medication & Dosage</label>
                <textarea id="medication" class="form-control" rows="3" required></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Instructions / Notes</label>
                <textarea id="instructions" class="form-control" rows="2" required></textarea>
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-accent" type="submit"><i class="fas fa-file-medical me-2"></i>Create Prescription</button>
                <button type="button" id="btnClearPrescription" class="btn btn-outline-secondary">Clear</button>
              </div>
            </div>
          </form>

          <hr class="my-4">

      

        </div>
      </div>
    </div>


  </div> 

  <!-- ADD PATIENT Modal (Bootstrap) -->
  <div class="modal fade" id="addPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="addPatientForm" class="p-3">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add Patient</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-2">
              <label class="form-label">Patient (Owner) Name</label>
              <input name="patientName" id="modalPatientName" class="form-control" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Contact</label>
              <input name="patientContact" id="modalPatientContact" class="form-control" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Pet Name</label>
              <input name="petName" id="modalPetName" class="form-control" required>
            </div>
            <div class="row g-2">
              <div class="col-6">
                <label class="form-label">Pet Type</label>
                <select name="petType" id="modalPetType" class="form-select" required>
                  <option>Dog</option>
                  <option>Cat</option>
                  <option>Rabbit</option>
                  <option>Bird</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label">Pet Age</label>
                <input name="petAge" id="modalPetAge" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-accent">Save Patient</button>
          </div>
        </form>
      </div>
    </div>
  </div>






  <!-- Prescription / Report View Modal (Bootstrap) -->
  <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="viewModalTitle" class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="viewModalBody" class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // ---------------------------
    // Utility: localStorage helpers
    // ---------------------------
    const LS = {
      get(key){ try { return JSON.parse(localStorage.getItem(key)) || []; } catch(e){ return []; } },
      set(key,val){ localStorage.setItem(key, JSON.stringify(val)); }
    };

    // On first load create demo data (won't overwrite existing)
    function createDemoData(){
      if (!localStorage.getItem('patients')){
        LS.set('patients', [
          { patientName: 'Ahmed Khan', patientContact: '01712345678', petName: 'Leo', petType: 'Dog', petAge: '3 years' },
          { patientName: 'Fatema Begum', patientContact: '01987654321', petName: 'Mimi', petType: 'Cat', petAge: '1.5 years' },
          { patientName: 'Saima Islam', patientContact: '01855554444', petName: 'Tutu', petType: 'Rabbit', petAge: '6 months' }
        ]);
      }
      if (!localStorage.getItem('appointments')){
        LS.set('appointments', [
          { patient: 'Ahmed Khan', date: '2025-08-16', time: '10:00 AM' },
          { patient: 'Fatema Begum', date: '2025-08-15', time: '02:30 PM' },
          { patient: 'Saima Islam', date: '2025-08-17', time: '11:00 AM' },
          { patient: 'Ahmed Khan', date: '2025-08-10', time: '09:00 AM' }
        ]);
      }
    }

    // ---------------------------
    // Render functions
    // ---------------------------
    function renderPatients(filter = ''){
      const patients = LS.get('patients');
      const container = document.getElementById('patientList');
      container.innerHTML = '';
      const f = (''+filter).trim().toLowerCase();
      const filtered = patients.filter(p => {
        if (!f) return true;
        return (p.patientName + ' ' + p.petName + ' ' + p.patientContact).toLowerCase().includes(f);
      });

      if (!filtered.length){
        container.innerHTML = '<div class="empty-state"><p class="text-muted">No patients found. Add one using the button above.</p></div>';
        document.getElementById('total-patients-count').textContent = patients.length;
        return;
      }

      filtered.forEach((p, idx) => {
        const div = document.createElement('div');
        div.className = 'patient-card';
        div.innerHTML = `
          <div class="d-flex justify-content-between">
            <div>
              <div><strong>${escapeHtml(p.patientName)}</strong> <span class="small-muted">— ${escapeHtml(p.petName)}</span></div>
              <div class="small-muted">${escapeHtml(p.petType)} • ${escapeHtml(p.petAge)}</div>
            </div>
            <div class="text-end">
              <div class="small-muted">${p.patientContact}</div>
              <div class="mt-2"><button class="btn btn-sm btn-outline-secondary btn-view" data-index="${idx}"><i class="fas fa-eye"></i></button></div>
            </div>
          </div>
        `;
        // click opens profile view modal
        div.querySelector('.btn-view').addEventListener('click', (e)=>{
          e.stopPropagation();
          showPatientProfileByIndex(idx);
        });
        div.addEventListener('click', ()=>{
          showPatientProfileByIndex(idx);
        });
        container.appendChild(div);
      });

      document.getElementById('total-patients-count').textContent = patients.length;
    }

    function renderAppointments(){
      const upcomingContainer = document.getElementById('upcomingAppointmentsList');
      const historyContainer = document.getElementById('appointmentHistoryList');
      const appts = LS.get('appointments');
      const today = new Date().toISOString().split('T')[0];

      const upcoming = appts.filter(a => a.date >= today).sort((a,b)=> a.date.localeCompare(b.date));
      const history = appts.filter(a => a.date < today).sort((a,b)=> b.date.localeCompare(a.date));

      upcomingContainer.innerHTML = '';
      if (!upcoming.length) upcomingContainer.innerHTML = '<p class="text-muted">No upcoming appointments.</p>';
      else {
        upcoming.forEach(app => {
          const el = document.createElement('div');
          el.className = 'patient-card';
          el.innerHTML = `<div><strong>${escapeHtml(app.patient)}</strong><div class="small-muted">${escapeHtml(app.date)} • ${escapeHtml(app.time)}</div></div>
                          <div class="mt-2"><button class="btn btn-sm btn-outline-secondary" onclick="showPatientProfileByName('${escapeJs(app.patient)}', ${JSON.stringify(app).split('"').join("&quot;")})">View Profile</button></div>`;
          upcomingContainer.appendChild(el);
        });
      }

      historyContainer.innerHTML = '';
      if (!history.length) historyContainer.innerHTML = '<p class="text-muted">No history found.</p>';
      else {
        history.forEach(app => {
          const el = document.createElement('div');
          el.className = 'patient-card';
          el.innerHTML = `<div><strong>${escapeHtml(app.patient)}</strong><div class="small-muted">${escapeHtml(app.date)} • ${escapeHtml(app.time)}</div></div>
                          <div class="mt-2"><button class="btn btn-sm btn-outline-secondary" onclick="showPatientProfileByName('${escapeJs(app.patient)}', ${JSON.stringify(app).split('"').join("&quot;")})">View</button></div>`;
          historyContainer.appendChild(el);
        });
      }

      document.getElementById('today-appointments-count').textContent = upcoming.length;
    }

    function renderLastPrescription(){
      const lastPrescriptionCard = document.getElementById('lastPrescriptionCard');
      const prescriptions = LS.get('prescriptions');
      if (!prescriptions.length) {
        lastPrescriptionCard.innerHTML = '<p class="text-muted mb-0">No prescriptions have been created yet.</p>';
        return;
      }
      const last = prescriptions[prescriptions.length-1];
      lastPrescriptionCard.innerHTML = `
        <div><strong>${escapeHtml(last.petName)}</strong></div>
        <div class="small-muted">${escapeHtml(last.date)} • ${escapeHtml(last.time)}</div>
        <div class="mt-2 small-muted">Disease: ${escapeHtml(last.currentDisease)}</div>
        <div class="mt-2"><button class="btn btn-sm btn-outline-secondary" onclick='openViewModal("Prescription", ${JSON.stringify(last).split('"').join("&quot;")})'>View</button></div>
      `;
    }

    function renderLastReport(){
      const lastReportCard = document.getElementById('lastReportCard');
      const reports = LS.get('reports');
      if (!reports.length){
        lastReportCard.innerHTML = '<p class="text-muted mb-0">No reports have been uploaded yet.</p>';
        return;
      }
      const last = reports[reports.length-1];
      lastReportCard.innerHTML = `
        <div><strong>${escapeHtml(last.petName)}</strong></div>
        <div class="small-muted">${escapeHtml(last.date)} • ${escapeHtml(last.time)}</div>
        <div class="mt-2 small-muted">File: ${escapeHtml(last.reportName)}</div>
        <div class="mt-2"><button class="btn btn-sm btn-outline-secondary" onclick='openViewModal("Report", ${JSON.stringify(last).split('"').join("&quot;")})'>View</button></div>
      `;
    }

    // ---------------------------
    // Modal helper
    // ---------------------------
    const bsViewModal = new bootstrap.Modal(document.getElementById('viewModal'));

    function openViewModal(title, data){
      document.getElementById('viewModalTitle').textContent = title;
      let html = '';
      if (title === 'Prescription'){
        html = `<p><strong>Pet Name:</strong> ${escapeHtml(data.petName)}</p>
                <p><strong>Date:</strong> ${escapeHtml(data.date)} ${escapeHtml(data.time)}</p>
                <p><strong>Pet Age:</strong> ${escapeHtml(data.petAge)}</p>
                <p><strong>Type:</strong> ${escapeHtml(data.petType)}</p>
                <p><strong>Current Disease:</strong> ${escapeHtml(data.currentDisease)}</p>
                <p><strong>Medication:</strong> ${escapeHtml(data.medication)}</p>
                <p><strong>Instructions:</strong> ${escapeHtml(data.instructions)}</p>`;
      } else if (title === 'Report'){
        html = `<p><strong>Pet Name:</strong> ${escapeHtml(data.petName)}</p>
                <p><strong>Date:</strong> ${escapeHtml(data.date)} ${escapeHtml(data.time)}</p>
                <p><strong>Report File:</strong> ${escapeHtml(data.reportName)}</p>
                <p class="small-muted">This is a demo; in a full app you'd be able to download/view the uploaded file here.</p>`;
      } else {
        html = `<pre>${JSON.stringify(data,null,2)}</pre>`;
      }
      document.getElementById('viewModalBody').innerHTML = html;
      bsViewModal.show();
    }

    // ---------------------------
    // Patient profile view
    // ---------------------------
    function showPatientProfileByIndex(index){
      const patients = LS.get('patients');
      const p = patients[index];
      if (!p) return;
      let html = `<h5>${escapeHtml(p.patientName)} <small class="small-muted">(${escapeHtml(p.patientContact)})</small></h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-6"><p><strong>Pet:</strong> ${escapeHtml(p.petName)}</p><p class="small-muted">${escapeHtml(p.petType)} • ${escapeHtml(p.petAge)}</p></div>
                    <div class="col-md-6">
                      <p><strong>Prescriptions</strong></p>
                      ${renderPatientPrescriptionsHtml(p.petName)}
                    </div>
                  </div>`;
      document.getElementById('viewModalTitle').textContent = 'Patient Profile';
      document.getElementById('viewModalBody').innerHTML = html;
      bsViewModal.show();
    }

    window.showPatientProfileByName = function(patientName, appointment=null){
      const patients = LS.get('patients');
      const idx = patients.findIndex(p => p.patientName === patientName);
      if (idx !== -1) {
        showPatientProfileByIndex(idx);
      } else {
        // not found: show message
        alert('Patient not found locally.');
      }
    };

    function renderPatientPrescriptionsHtml(petName){
      const prescriptions = LS.get('prescriptions').filter(px => px.petName === petName);
      if (!prescriptions.length) return '<p class="small-muted">No prescriptions found.</p>';
      return prescriptions.map(px => `<div class="small-muted mb-2">
                <div><strong>${escapeHtml(px.date)} ${escapeHtml(px.time)}</strong></div>
                <div>${escapeHtml(px.currentDisease)}</div>
                <div><button class="btn btn-sm btn-outline-secondary mt-1" onclick='openViewModal("Prescription", ${JSON.stringify(px).split('"').join("&quot;")})'>View</button></div>
              </div>`).join('');
    }

    // ---------------------------
    // Form handling
    // ---------------------------
    document.getElementById('addPatientForm').addEventListener('submit', function(e){
      e.preventDefault();
      const patient = {
        patientName: document.getElementById('modalPatientName').value.trim(),
        patientContact: document.getElementById('modalPatientContact').value.trim(),
        petName: document.getElementById('modalPetName').value.trim(),
        petType: document.getElementById('modalPetType').value,
        petAge: document.getElementById('modalPetAge').value.trim()
      };
      const patients = LS.get('patients');
      patients.push(patient);
      LS.set('patients', patients);
      bootstrap.Modal.getInstance(document.getElementById('addPatientModal')).hide();
      renderPatients();
      showToast('Patient added successfully');
      this.reset();
    });

    // Prescription form
    document.getElementById('prescriptionForm').addEventListener('submit', function(e){
      e.preventDefault();
      const now = new Date();
      const date = now.toLocaleDateString('en-CA'); // yyyy-mm-dd
      const time = now.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
      const prescription = {
        petName: document.getElementById('prescriptionPetName').value.trim(),
        petAge: document.getElementById('prescriptionPetAge').value.trim(),
        petType: document.getElementById('prescriptionPetType').value,
        currentDisease: document.getElementById('currentDisease').value.trim(),
        medication: document.getElementById('medication').value.trim(),
        instructions: document.getElementById('instructions').value.trim(),
        date, time
      };
      const pills = LS.get('prescriptions');
      pills.push(prescription);
      LS.set('prescriptions', pills);
      renderLastPrescription();
      showToast('Prescription created');
      this.reset();
    });

    // clear prescription
    document.getElementById('btnClearPrescription').addEventListener('click', ()=>{
      document.getElementById('prescriptionForm').reset();
    });

    // quick open new prescription modal focus
    document.getElementById('btnOpenPrescriptionModal').addEventListener('click', ()=>{
      document.getElementById('prescriptionPetName').focus();
      window.scrollTo({ top: document.getElementById('prescriptionForm').offsetTop - 60, behavior:'smooth' });
    });

    // file upload (reports)
    // we simulate file name only (localStorage)
    function initReportUploadSimulation(){
      // create simple form handler: using a fake form elsewhere you can attach. For now we'll rely on the global demo in original.
    }

    // search filter
    document.getElementById('patientSearch').addEventListener('input', (e)=>{
      renderPatients(e.target.value);
    });

    // small toast-like message (simple)
    function showToast(msg){
      const el = document.createElement('div');
      el.className = 'position-fixed top-0 start-50 translate-middle-x mt-4 bg-white border p-2 rounded shadow-sm';
      el.style.zIndex = 11000;
      el.innerHTML = `<div class="small-muted">${escapeHtml(msg)}</div>`;
      document.body.appendChild(el);
      setTimeout(()=> el.remove(), 1800);
    }

    // ---------------------------
    // Helpers for escaping
    // ---------------------------
    function escapeHtml(str){
      if (str === undefined || str === null) return '';
      return String(str).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;');
    }
    function escapeJs(str){
      return (str+'').replace(/'/g,"\\'").replace(/"/g,'\\"');
    }

    // ---------------------------
    // Initialize page
    // ---------------------------
    (function init(){
      createDemoData();
      renderPatients();
      renderAppointments();
      renderLastPrescription();
      renderLastReport();
    })();

  </script>


  <footer>
    <div class="container">
        <div class="footer-col about-footer">
            <div class="logo">
                <img src="WhatsApp Image 2025-08-09 at 17.06.15_24840d36.jpg" alt="Kitty Pups Logo">
                <div class="logo-text">
                    <span>KittyPups</span>
                    <p>Every Life Counts</p>
                </div>
            </div>
            <p>Kitty Pups is a pet hospital that provides all kinds of veterinary services with the best care. We are highly determined to help the adorable pets to be cured. We also provide pet products such as food, accessories, medication, and care items. Your visit to our clinic would be much appreciated. Thanks for being with us.</p>
            <p>Address: Basundhara Main Road, Ground Floor, 1229</p>
            <p>Phone: 01767-675206</p>
            
            <!-- Directions Box with White Background and Pink Border -->
            <div class="directions-box" style="background-color: #fff; padding: 15px; display: flex; align-items: center; border-radius: 8px; border: 2px solid #ff5a8f;">
                <i class="fa fa-map-marker-alt" style="color: #ff5a8f; font-size: 20px; margin-right: 10px;"></i>
                <a href="https://maps.app.goo.gl/VVHL3sAgMWqzh357A" target="_blank" style="color: #ff5a8f; font-weight: bold; text-decoration: none;">Get Directions</a>
            </div>
            
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-col">
            <h4>About</h4>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">FAQs</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Customer Service</h4>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Return & Refund policy</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Mobile Apps</h4>
            <div class="app-links">
                <a href="#"><img src="https://amarpet.com/_next/image?url=%2Fassets%2Flogo%2Fapp-store.png&w=256&q=75=" alt="App Store"></a>
                <a href="#"><img src="https://amarpet.com/_next/image?url=%2Fassets%2Flogo%2Fplay-store.png&w=256&q=75" alt="Google Play"></a>
            </div>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="bottom-bar">
        <div class="container">
            <div class="payment-icons" style="text-align: center;">
                <img src="https://amarpet.com/_next/image?url=%2Fassets%2Fbanner%2FSSLCOMMERZ-desktop.png&w=3840&q=75" alt="Payment Methods" style="width: 100%; height: auto; max-height: 200px;">
            </div>
        </div>
    </div>

    <!-- Copyright Section -->
    <div class="container" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
        <p style="font-weight: bold; text-align: center; margin: 0;">© 2025 KittyPups. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

