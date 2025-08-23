
<style>

  
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

<?php
session_start();
require('db.php');

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Helper
function set_db_error($conn, $stmt = null) {
    if ($stmt) {
        $msg = mysqli_stmt_error($stmt);
    } else {
        $msg = mysqli_error($conn);
    }
    $_SESSION['error'] = "Database error: " . $msg;
    error_log("DB ERROR: " . $msg);
}

/* -------------------------
    Update Appointment Status
    ------------------------- */
if (isset($_POST['update_appointment_status'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $status = $_POST['status'] === '' ? NULL : intval($_POST['status']);

    if ($status === NULL) {
        $sql = "UPDATE appointments SET status = NULL WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $appointment_id);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Appointment status updated successfully!";
            } else {
                set_db_error($conn, $stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            set_db_error($conn);
        }
    } else {
        $sql = "UPDATE appointments SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $status, $appointment_id);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Appointment status updated successfully!";
            } else {
                set_db_error($conn, $stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            set_db_error($conn);
        }
    }

    header("Location: admin_dashboard.php");
    exit;
}

/* -------------------------
    Delete Appointment
    ------------------------- */
if (isset($_GET['delete_appointment'])) {
    $appointment_id = intval($_GET['delete_appointment']);
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $appointment_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Appointment deleted successfully!";
        } else {
            set_db_error($conn, $stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        set_db_error($conn);
    }
    header("Location: admin_dashboard.php");
    exit;
}



// ===================  Old MySQL Starts   ===============================


/* -------------------------
   Handle Add Product
   ------------------------- */
// if (isset($_POST['add_product'])) {
//     $name         = trim($_POST['name'] ?? '');
//     $price        = floatval($_POST['price'] ?? 0);
//     $category     = trim($_POST['category'] ?? '');
//     $description  = trim($_POST['description'] ?? '');
//     $brand_name   = trim($_POST['brand_name'] ?? '');
//     $weight       = trim($_POST['weight'] ?? '');
//     $stock        = intval($_POST['stock'] ?? 0);
//     $image        = trim($_POST['image'] ?? '');

//     $sql = "INSERT INTO products (name, price, image, rating, category, description, brand_name, weight, stock)
//             VALUES (?, ?, ?, 0, ?, ?, ?, ?, ?)";
//     $stmt = mysqli_prepare($conn, $sql);
//     if (!$stmt) {
//         // Handle prepare error
//         set_db_error($conn);
//     } else {
//         // Corrected type string: "sdsssssi" for the 8 variables
//         mysqli_stmt_bind_param($stmt, "sdsssssi", $name, $price, $image, $category, $description, $brand_name, $weight, $stock);
        
//         if (mysqli_stmt_execute($stmt)) {
//             $_SESSION['message'] = "Product added successfully!";
//         } else {
//             // Handle execution error
//             set_db_error($conn, $stmt);
//             // This is a development-only line, it should be removed in production.
//             die("Product adding failed: " . mysqli_stmt_error($stmt));
//         }
//         mysqli_stmt_close($stmt);
//     }
//     header("Location: admin_dashboard.php");
//     exit;
// }

/* -------------------------
    Edit Product
    ------------------------- */
if (isset($_POST['edit_product'])) {
    $pid = intval($_POST['product_id']);
    $name         = trim($_POST['name'] ?? '');
    $price        = floatval($_POST['price'] ?? 0);
    $image        = trim($_POST['image'] ?? '');
    $category     = trim($_POST['category'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $brand_name   = trim($_POST['brand_name'] ?? '');
    $weight       = trim($_POST['weight'] ?? '');
    $stock        = intval($_POST['stock'] ?? 0);

    // The SQL query has 9 placeholders
    $sql = "UPDATE products SET name=?, price=?, image=?, category=?, description=?, brand_name=?, weight=?, stock=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        set_db_error($conn);
    } else {
        // Corrected type string for 9 parameters: "sdsssssii"
        mysqli_stmt_bind_param($stmt, "sdsssssii", $name, $price, $image, $category, $description, $brand_name, $weight, $stock, $pid);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Product updated successfully!";
        } else {
            set_db_error($conn, $stmt);
        }
        mysqli_stmt_close($stmt);
    }
    header("Location: admin_dashboard.php");
    exit;
}

/* -------------------------
   Delete Product
   ------------------------- */
if (isset($_GET['delete_product'])) {
    $product_id = intval($_GET['delete_product']);
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        set_db_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Product deleted successfully!";
        } else {
            set_db_error($conn, $stmt);
        }
        mysqli_stmt_close($stmt);
    }
    header("Location: admin_dashboard.php");
    exit;
}

/* -------------------------
   Add User
   ------------------------- */
if (isset($_POST['add_user'])) {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = trim($_POST['role'] ?? 'customer');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Username, email and password are required.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $approved = ($role === 'doctor') ? 1 : 0;

        $sql = "INSERT INTO users (username, email, password, role, phone, address, approved, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            set_db_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssi", $username, $email, $password_hashed, $role, $phone, $address, $approved);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "User added successfully!";
            } else {
                set_db_error($conn, $stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
    header("Location: admin_dashboard.php");
    exit;
  }



    
// If this is an AJAX request for messages only, return just the messages HTML and exit
if (isset($_GET['ajax']) && $_GET['ajax'] == '1' && $current_chat > 0) {
    // Output messages HTML
    foreach ($chat_messages as $msg) {
        $is_me = ($msg['sender_id'] == $_SESSION['user_id']);
        $align = $is_me ? 'text-end' : 'text-start';
        $bubbleClass = $is_me ? 'bg-primary text-white' : 'bg-light';
        $time = date('h:i a', strtotime($msg['sent_at']));
        echo '<div class="mb-3 '.$align.'">';
        echo '<div class="d-inline-block p-2 rounded '.$bubbleClass.'">';
        echo htmlspecialchars($msg['message']);
        echo '<div class="small text-muted mt-1" style="font-size:11px;">'.htmlspecialchars($time).'</div>';
        echo '</div></div>';
    }
    exit;
}

/* -------------------------
   Edit User
   ------------------------- */
if (isset($_POST['edit_user'])) {
    $uid = intval($_POST['user_id']);
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = trim($_POST['role'] ?? 'customer');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');

    if (empty($username) || empty($email)) {
        $_SESSION['error'] = "Username and email are required.";
        header("Location: admin_dashboard.php");
        exit;
    }

    if (!empty($password)) {
        // update including password
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username=?, email=?, password=?, role=?, phone=?, address=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            set_db_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssi", $username, $email, $password_hashed, $role, $phone, $address, $uid);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "User updated successfully!";
            } else {
                set_db_error($conn, $stmt);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        // update without touching password
        $sql = "UPDATE users SET username=?, email=?, role=?, phone=?, address=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            set_db_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "sssssi", $username, $email, $role, $phone, $address, $uid);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "User updated successfully!";
            } else {
                set_db_error($conn, $stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
    header("Location: admin_dashboard.php");
    exit;
}

/* -------------------------
   Delete User
   ------------------------- */
if (isset($_GET['delete_user'])) {
    $delete_user_id = intval($_GET['delete_user']);
    // do not allow admin to delete themselves
    if ($delete_user_id == $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot delete your own account.";
        header("Location: admin_dashboard.php");
        exit;
    }
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        set_db_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $delete_user_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "User deleted successfully!";
        } else {
            set_db_error($conn, $stmt);
        }
        mysqli_stmt_close($stmt);
    }
    header("Location: admin_dashboard.php");
    exit;
}

/* -------------------------
   Approve doctor (already present)
   ------------------------- */
if (isset($_POST['approve_doctor'])) {
    $doctor_id = intval($_POST['doctor_id']);
    $sql = "UPDATE users SET approved = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) { set_db_error($conn); }
    else {
        mysqli_stmt_bind_param($stmt, "i", $doctor_id);
        if (mysqli_stmt_execute($stmt)) $_SESSION['message'] = "Doctor approved successfully!";
        else set_db_error($conn, $stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: admin_dashboard.php");
    exit;
}

/* -------------------------
   Update order status (already present)
   ------------------------- */
if (isset($_POST['update_order_status'])) {
    $order_id = intval($_POST['order_id']);
    $status   = trim($_POST['status'] ?? '');
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) { set_db_error($conn); }
    else {
        mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
        if (mysqli_stmt_execute($stmt)) $_SESSION['message'] = "Order status updated successfully!";
        else set_db_error($conn, $stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: admin_dashboard.php");
    exit;
}

/* -------------------------
   Fetch data for display
   ------------------------- */
$products = mysqli_query($conn, "SELECT * FROM products");
$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");
$users = mysqli_query($conn, "SELECT * FROM users");
$pending_doctors = mysqli_query($conn, "SELECT * FROM users WHERE approved='0'");
$revenue_res = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders");
$revenue = $revenue_res ? mysqli_fetch_assoc($revenue_res) : ['total' => 0];

$message = $_SESSION['message'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['message'], $_SESSION['error']);




// =========================  Old MySQL Ends   =========================














?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard - KittyPups</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root { --accent:#dc3545; }
    body { font-family: 'Poppins', sans-serif; background:#f8f9fa; color:#222; }
    .navbar { background:var(--accent); }
    .brand { color:#fff; font-weight:700; }
    .img-thumb { width:56px; height:56px; object-fit:cover; border-radius:8px; }
    .status-badge { padding: 0.35em 0.65em; font-size: 0.75em; font-weight: 700; border-radius: 0.25rem; }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-confirmed { background-color: #d1ecf1; color: #0c5460; }
    .status-null { background-color: #e2e3e5; color: #383d41; }
    .table-responsive { border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    .appointment-table th { background-color: #f1f1f1; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand brand" href="#"><i class="fas fa-paw me-2"></i>KittyPups Admin</a>
    <div class="ms-auto d-flex align-items-center">
      <div class="me-3 text-white">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></div>
      <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container-fluid mt-4">
  <div class="row">


  <div class="col-lg-3">
        <div class="card p-3 mb-3">
          <h6>Quick Stats</h6>
          <small class="text-muted">Overview</small>
          <hr>
          <div class="mb-2">Products: <strong><?php echo mysqli_num_rows($products); ?></strong></div>
          <div class="mb-2">Orders: <strong><?php echo mysqli_num_rows($orders); ?></strong></div>
          <div class="mb-2">Revenue: <strong><?php echo number_format($revenue['total'] ?? 0,2); ?> BDT</strong></div>
          <div class="mb-2">Pending Doctors: <strong><?php echo mysqli_num_rows($pending_doctors); ?></strong></div>
        </div>
  </div>



   <div class="col-lg-9">
          <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

     <ul class="nav nav-tabs mb-3" role="tablist">
       <li class="nav-item">
         <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#appointments">Appointments</button>
        </li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#products">Products</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders">Orders</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#users">Users</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#doctors">Pending Doctors</button></li>
        
        
        
        
        
        
        
          
          
          
        
      </ul>
      
      
      <div class="tab-content">
         <!-- Appointments -->
 
        <div class="tab-pane fade show active" id="appointments">
          <div class="card">
            <div class="card-header bg-white">
              <h5 class="mb-0">Appointment Management</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover appointment-table">
                  <thead>
                    <tr>
                      <th>ID</th>
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
                            
                            echo "<tr>
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
                            <td>
                            <button type='button' class='btn btn-sm btn-info' data-bs-toggle='modal' data-bs-target='#detailsModal{$app['id']}'>
                            <i class='fas fa-eye'></i>
                            </button>
                            <a href='?delete_appointment={$app['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this appointment?\")'>
                            <i class='fas fa-trash'></i>
                            </a>
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
          </div>
        </div>


        <!-- PRODUCTS -->
        <div class="tab-pane fade show" id="products">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5>Products</h5>
            <div>
              <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="fas fa-plus"></i> Add Product</button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table align-middle">
              <thead><tr><th>ID</th><th>Image</th><th>Name</th><th>Price</th><th>Category</th><th>Stock</th><th>Actions</th></tr></thead>
              <tbody>
                <?php
                  // refresh products list for display
                  $products = mysqli_query($conn, "SELECT * FROM products");
                  while($product = mysqli_fetch_assoc($products)):
                ?>
                <tr>
                  <td><?php echo $product['id']; ?></td>
                  <td><img src="<?php echo htmlspecialchars($product['image']); ?>" class="img-thumb" alt=""></td>
                  <td><?php echo htmlspecialchars($product['name']); ?></td>
                  <td><?php echo number_format($product['price'],2); ?> BDT</td>
                  <td><?php echo htmlspecialchars($product['category']); ?></td>
                  <td><?php echo intval($product['stock']); ?></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary edit-product-btn"
                      data-id="<?php echo $product['id']; ?>"
                      data-name="<?php echo htmlspecialchars($product['name'], ENT_QUOTES); ?>"
                      data-price="<?php echo $product['price']; ?>"
                      data-image="<?php echo htmlspecialchars($product['image'], ENT_QUOTES); ?>"
                      data-category="<?php echo htmlspecialchars($product['category'], ENT_QUOTES); ?>"
                      data-description="<?php echo htmlspecialchars($product['description'], ENT_QUOTES); ?>"
                      data-brand_name="<?php echo htmlspecialchars($product['brand_name'], ENT_QUOTES); ?>"
                      data-weight="<?php echo htmlspecialchars($product['weight'], ENT_QUOTES); ?>"
                      data-stock="<?php echo $product['stock']; ?>"
                    ><i class="fas fa-edit"></i></button>

                    <a href="?delete_product=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete product?')"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ORDERS -->
        <div class="tab-pane fade" id="orders">
          <h5>Orders</h5>
          <div class="table-responsive">
            <table class="table">
              <thead><tr><th>#</th><th>Customer</th><th>Date</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead>
              <tbody>
                <?php
                  $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");
                  while($order = mysqli_fetch_assoc($orders)):
                ?>
                <tr>
                  <td>#<?php echo $order['id']; ?></td>
                  <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                  <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                  <td><?php echo number_format($order['total_amount'],2); ?> BDT</td>
                  <td>
                    <form method="post" class="d-flex">
                      <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                      <select name="status" class="form-select form-select-sm me-2" style="width:140px;">
                        <option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>Pending</option>
                        <option value="processing" <?php if($order['status']=='processing') echo 'selected'; ?>>Processing</option>
                        <option value="shipped" <?php if($order['status']=='shipped') echo 'selected'; ?>>Shipped</option>
                        <option value="delivered" <?php if($order['status']=='delivered') echo 'selected'; ?>>Delivered</option>
                        <option value="cancelled" <?php if($order['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                      </select>
                      <button type="submit" name="update_order_status" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                    </form>
                  </td>
                  <td><a class="btn btn-sm btn-info" href="order_details.php?id=<?php echo $order['id']; ?>"><i class="fas fa-eye"></i></a></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- USERS -->
        <div class="tab-pane fade" id="users">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5>Users</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-plus"></i> Add User</button>
          </div>

          <div class="table-responsive">
            <table class="table align-middle">
              <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Phone</th><th>Actions</th></tr></thead>
              <tbody>
                <?php
                  $users = mysqli_query($conn, "SELECT * FROM users");
                  while($user = mysqli_fetch_assoc($users)):
                ?>
                <tr>
                  <td><?php echo $user['id']; ?></td>
                  <td><?php echo htmlspecialchars($user['username']); ?></td>
                  <td><?php echo htmlspecialchars($user['email']); ?></td>
                  <td><?php echo htmlspecialchars($user['role']); ?></td>
                  <td><?php echo htmlspecialchars($user['phone']); ?></td>
                  <td>
                 
                    <?php if($user['id'] != $_SESSION['user_id']): ?>
                      <a href="?delete_user=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete user?')"><i class="fas fa-trash"></i></a>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- PENDING DOCTORS -->
        <div class="tab-pane fade" id="doctors">
          <h5>Pending Doctors</h5>
          <div class="table-responsive">
            <table class="table">
              <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr></thead>
              <tbody>
                <?php
                  $pending_doctors = mysqli_query($conn, "SELECT * FROM users WHERE approved='0'");
                  while($doc = mysqli_fetch_assoc($pending_doctors)):
                ?>
                <tr>
                  <td><?php echo $doc['id']; ?></td>
                  <td><?php echo htmlspecialchars($doc['username']); ?></td>
                  <td><?php echo htmlspecialchars($doc['email']); ?></td>
                  <td><?php echo htmlspecialchars($doc['phone']); ?></td>
                  <td>
                    <form method="post" class="d-inline">
                      <input type="hidden" name="doctor_id" value="<?php echo $doc['id']; ?>">
                      <button type="submit" name="approve_doctor" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Approve</button>
                    </form>
                    <a class="btn btn-sm btn-info" href="view_doctor.php?id=<?php echo $doc['id']; ?>"><i class="fas fa-eye"></i></a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>





<!-- Modals -->

      <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="admin_adding_product.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="text" name="name" class="form-control" id="pname" placeholder="Product Name" required>
                                <label for="pname">Product Name</label>
                            </div>
                            <div class="col-md-3 form-floating">
                                <input type="number" step="0.01" name="price" class="form-control" id="pprice" placeholder="Price" required>
                                <label for="pprice">Price</label>
                            </div>
                            <div class="col-md-3 form-floating">
                                <select name="category" class="form-select" id="pcat" required>
                                    <option value="">Select category</option>
                                    <option value="cat">Cat</option>
                                    <option value="dog">Dog</option>
                                    <option value="rabbit">Rabbit</option>
                                    <option value="bird">Bird</option>
                                </select>
                                <label for="pcat">Category</label>
                            </div>

                            <div class="col-12 form-floating">
                                <textarea name="description" class="form-control" placeholder="Description" id="pdesc" style="height:80px"></textarea>
                                <label for="pdesc">Description</label>
                            </div>

                            <div class="col-md-4 form-floating">
                                <input type="text" name="brand_name" class="form-control" id="pbrand" placeholder="Brand">
                                <label for="pbrand">Brand</label>
                            </div>
                            <div class="col-md-4 form-floating">
                                <input type="text" name="weight" class="form-control" id="pweight" placeholder="Weight">
                                <label for="pweight">Weight</label>
                            </div>
                            <div class="col-md-4 form-floating">
                                <input type="number" name="stock" class="form-control" id="pstock" placeholder="Stock" required>
                                <label for="pstock">Stock Quantity</label>
                            </div>

                            <div class="col-12 form-floating">
                                <input type="url" name="image" class="form-control" id="pimage" placeholder="Image URL" required>
                                <label for="pimage">Product Image URL</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
      <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header"><h5 class="modal-title">Edit Product</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <input type="hidden" name="product_id" id="edit_product_id">
                            <div class="row g-3">
                                <div class="col-md-6 form-floating">
                                    <input type="text" name="name" id="edit_name" class="form-control" placeholder="Product Name" required>
                                    <label for="edit_name">Product Name</label>
                                </div>
                                <div class="col-md-3 form-floating">
                                    <input type="number" step="0.01" name="price" id="edit_price" class="form-control" placeholder="Price" required>
                  <label for="edit_price">Price</label>
                </div>
                <div class="col-md-3 form-floating">
                  <select name="category" id="edit_category" class="form-select" required>
                      <option value="">Select category</option>
                      <?php
                      // same options as add modal
                      $res = mysqli_query($conn, "SHOW COLUMNS FROM `products` LIKE 'category'");
                      if ($r = mysqli_fetch_assoc($res)) {
                          $type = $r['Type'];
                          if (preg_match("/^enum\((.*)\)$/", $type, $m)) {
                              $vals = str_getcsv($m[1], ',', "'");
                              foreach ($vals as $v) echo '<option value="'.htmlspecialchars($v).'">'.htmlspecialchars(ucfirst($v)).'</option>';
                          } else {
                              $cat_res = mysqli_query($conn, "SELECT DISTINCT category FROM products WHERE category <> ''");
                              while($c = mysqli_fetch_assoc($cat_res)) echo '<option value="'.htmlspecialchars($c['category']).'">'.htmlspecialchars(ucfirst($c['category'])).'</option>';
                          }
                      }
                    ?>
                  </select>
                  <label for="edit_category">Category</label>
                </div>

                <div class="col-12 form-floating">
                  <textarea name="description" id="edit_description" class="form-control" placeholder="Description" style="height:80px"></textarea>
                  <label for="edit_description">Description</label>
                </div>

                <div class="col-md-4 form-floating">
                  <input type="text" name="brand_name" id="edit_brand" class="form-control" placeholder="Brand">
                  <label for="edit_brand">Brand</label>
                </div>
                <div class="col-md-4 form-floating">
                    <input type="text" name="weight" id="edit_weight" class="form-control" placeholder="Weight">
                    <label for="edit_weight">Weight</label>
                </div>
                <div class="col-md-4 form-floating">
                    <input type="number" name="stock" id="edit_stock" class="form-control" placeholder="Stock" required>
                    <label for="edit_stock">Stock Quantity</label>
                </div>
                
                <div class="col-12 form-floating">
                    <input type="url" name="image" id="edit_image" class="form-control" placeholder="Image URL" required>
                    <label for="edit_image">Product Image URL</label>
                </div>
            </div>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
          </div>
          </div>
    </div>


    <!-- Add User Modal -->

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="post">
            <div class="modal-header"><h5 class="modal-title">Add New User</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-12 form-floating">
                  <input type="text" name="username" class="form-control" id="uname" placeholder="Username" required>
                  <label for="uname">Username</label>
                </div>
                <div class="col-md-6 form-floating">
                  <input type="email" name="email" class="form-control" id="uemail" placeholder="Email" required>
                  <label for="uemail">Email</label>
                </div>
                <div class="col-md-6 form-floating">
                  <input type="password" name="password" class="form-control" id="upassword" placeholder="Password" required>
                  <label for="upassword">Password</label>
                </div>
                <div class="col-md-6 form-floating">
                  <select name="role" class="form-select" id="urole" required>
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="manager">Manager</option>
                  </select>
                  <label for="urole">Role</label>
                </div>
                <div class="col-md-6 form-floating">
                  <input type="text" name="phone" class="form-control" id="uphone" placeholder="Phone">
                  <label for="uphone">Phone</label>
                </div>
                <div class="col-12 form-floating">
                  <textarea name="address" class="form-control" id="uaddress" placeholder="Address" style="height:68px"></textarea>
                  <label for="uaddress">Address</label>
                </div>
              </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" name="add_user" class="btn btn-primary">Add User</button></div>
          </form>
        </div>
      </div>
    </div>

      <!-- Edit User Modal -->
      <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form method="post">
              <div class="modal-header"><h5 class="modal-title">Edit User</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
              <div class="modal-body">
                <input type="hidden" name="user_id" id="edit_user_id">
                <div class="row g-3">
                  <div class="col-12 form-floating">
                    <input type="text" name="username" id="edit_username" class="form-control" placeholder="Username" required>
                    <label for="edit_username">Username</label>
                  </div>
                  <div class="col-md-6 form-floating">
                    <input type="email" name="email" id="edit_email" class="form-control" placeholder="Email" required>
                    <label for="edit_email">Email</label>
                  </div>
                  <div class="col-md-6 form-floating">
                    <input type="password" name="password" id="edit_password" class="form-control" placeholder="Password (leave blank to keep)">
                    <label for="edit_password">Password (leave blank to keep)</label>
                  </div>
                  <div class="col-md-6 form-floating">
                    <select name="role" id="edit_role" class="form-select" required>
                      <option value="customer">Customer</option>
                      <option value="admin">Admin</option>
                      <option value="doctor">Doctor</option>
                      <option value="manager">Manager</option>
                    </select>
                    <label for="edit_role">Role</label>
                  </div>
                  <div class="col-md-6 form-floating">
                    <input type="text" name="phone" id="edit_phone" class="form-control" placeholder="Phone">
                    <label for="edit_phone">Phone</label>
                  </div>
                  <div class="col-12 form-floating">
                    <textarea name="address" id="edit_address" class="form-control" placeholder="Address" style="height:68px"></textarea>
                    <label for="edit_address">Address</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" name="edit_user" class="btn btn-primary">Save Changes</button></div>
            </form>
          </div>
        </div>
      </div>











        </div>
        </div>
        
        
        
   
  </div>
  
  <footer class="mt-4 text-center small text-muted py-3">
    &copy; <?php echo date('Y'); ?> KittyPups — Admin Panel
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Edit product button populate modal
  document.querySelectorAll('.edit-product-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
      document.getElementById('edit_product_id').value = btn.dataset.id;
      document.getElementById('edit_name').value = btn.dataset.name;
      document.getElementById('edit_price').value = btn.dataset.price;
      document.getElementById('edit_image').value = btn.dataset.image;
      document.getElementById('edit_category').value = btn.dataset.category;
      document.getElementById('edit_description').value = btn.dataset.description;
      document.getElementById('edit_brand').value = btn.dataset.brand_name;
      document.getElementById('edit_weight').value = btn.dataset.weight;
      document.getElementById('edit_stock').value = btn.dataset.stock;
      modal.show();
    });
  });



document.querySelectorAll(".edit-user-btn").forEach(btn => {
  btn.addEventListener("click", function() {
    let id = this.dataset.id;
    window.location.href = "view_profile.php?id=" + id;
  });
});



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