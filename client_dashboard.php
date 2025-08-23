<?php


session_start();
require("db.php");

$user_id = $_SESSION['user_id']; // Make sure this is set during login
$user_sql = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

if (!isset($_SESSION['loggedin']) || $user['role'] != 'customer') {
    header("Location: login.php");
    exit;
}

// Get user's orders
$orders_sql = "SELECT o.*, 
               COUNT(oi.id) AS item_count, 
               SUM(oi.quantity * oi.price) AS subtotal
               FROM orders o
               JOIN order_items oi ON o.id = oi.order_id
               WHERE o.user_id = $user_id
               GROUP BY o.id
               ORDER BY o.order_date DESC";
$orders_result = mysqli_query($conn, $orders_sql);

// Get total order count
$order_count = mysqli_num_rows($orders_result);

// Get user's appointments
$appointments_sql = "SELECT * FROM appointments WHERE user_id = $user_id ORDER BY appointment_date DESC, appointment_time DESC";
$appointments_result = mysqli_query($conn, $appointments_sql);
$appointments = mysqli_fetch_all($appointments_result, MYSQLI_ASSOC);

include("header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *{ list-style-type: none; }
        .profile-card, .orders-card, .appointments-card {
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .order-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-processing { background-color: #cce5ff; color: #eb1f48; }
        .status-shipped { background-color: #d4edda; color: #155724; }
        .status-delivered { background-color: #d1ecf1; color: #0c5460; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        .appointment-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .appointment-item:last-child {
            border-bottom: none;
        }
        .appointment-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .no-appointments {
            text-align: center;
            padding: 30px;
            color: #6c757d;
        }
        .feature-list li {
            background-color: #fcdde0;
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
        }
        .feature-list a {
            text-decoration: none;
            color: #1a1a1a;
            display: block;
            list-style: none !important;
        }
        .card-custom {
            background-color: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card-title {
            margin-bottom: var(--bs-card-title-spacer-y);
            color: var(--bs-card-title-color);
        }
        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        .bg-primary{
            background: #c04316ff !important; 
        }
    </style>
</head>
<body h-100 style="background:#f7f3f6;">
    <div class="container py-4">
        <div class="row col-12 g-4">
            <div class="col-md-4">
                <!-- Profile Card -->
                <div class="card profile-card">
                    <div class="card-header bg-primary text-white">
                        <h4>My Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h5><?php echo htmlspecialchars($user['username']); ?></h5>
                            <p class="text-muted">Customer</p>
                        </div>
                        <div class="mb-3">
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                            <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($user['address'])); ?></p>
                        </div>
                        <a href="view_profile.php?id=<?php echo $user_id; ?>" class="btn btn-outline-primary">Edit Profile</a>
                        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                    </div>
                </div>
                <!-- Appointments Card -->
                <div class="card appointments-card">
                    <div class="card-header bg-primary text-white">
                        <h4>My Appointments</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($appointments)): ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <div class="appointment-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?php echo htmlspecialchars($appointment['pet_name']); ?> 
                                                <small class="text-muted">(<?php echo htmlspecialchars($appointment['pet_type']); ?>)</small>
                                            </h6>
                                            <p class="mb-1 small">With Dr. <?php echo htmlspecialchars($appointment['doctor']); ?></p>
                                        </div>
                                        <div class="text-end">
                                            <?php
                                                $status = $appointment['status'];
                                                if ($status === null) {
                                                    $status_class = 'status-pending';
                                                    $status_text = 'Pending';
                                                } else if ($status == 1 || $status === true || $status === '1') {
                                                    $status_class = 'status-confirmed';
                                                    $status_text = 'Confirmed';
                                                } else {
                                                    $status_class = 'status-cancelled';
                                                    $status_text = 'Cancelled';
                                                }
                                            ?>
                                            <span class="appointment-status <?php echo $status_class; ?>">
                                                <?php echo $status_text; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?php echo date('M j, Y', strtotime($appointment['appointment_date'])); ?>
                                                <i class="fas fa-clock ms-2 me-1"></i>
                                                <?php 
                                                    $time = $appointment['appointment_time'];
                                                    if (strpos($time, ':') !== false && !strpos($time, ' ')) {
                                                        echo date('g:i A', strtotime($time));
                                                    } else {
                                                        echo $time;
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-appointments">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                <p class="mb-0">No appointments yet</p>
                                <a href="book_appointment.php" class="btn btn-primary btn-sm mt-2">Book Now</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Orders Card -->
                <div class="card orders-card">
                    <div class="card-header bg-primary text-white">
                        <h4>My Orders<?php if($order_count > 0) echo " ({$order_count})"; ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if ($order_count > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $serial = 1;
                                            // Reset pointer to first row
                                            mysqli_data_seek($orders_result, 0);
                                            while ($order = mysqli_fetch_assoc($orders_result)): 
                                        ?>
                                            <tr>
                                                <td><?php echo $serial++; ?></td>
                                                <td>#<?php echo $order['id']; ?></td>
                                                <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                                <td><?php echo $order['item_count']; ?></td>
                                                <td><?php echo number_format($order['subtotal'] + $order['shipping_cost'], 2); ?> BDT</td>
                                                <td>
                                                    <span class="order-status status-<?php echo strtolower($order['status']); ?>">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                                <p class="mb-0">You have not placed any orders yet.</p>
                                <a href="index.php" class="btn btn-primary btn-sm mt-2">Shop Now</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php 
include("footer.php")
?>