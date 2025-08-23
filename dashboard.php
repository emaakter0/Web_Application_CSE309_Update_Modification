<?php
// Start session and include the database connection file
session_start();
require("../includes/db.php");  // Include the database connection

// Ensure that the user is logged in and has a valid session
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Get user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch total orders count for the logged-in user
$orders_sql = "SELECT COUNT(*) AS orders_count FROM orders WHERE user_id = $user_id";
$orders_result = mysqli_query($conn, $orders_sql);
$orders_data = mysqli_fetch_assoc($orders_result);
$orders_count = $orders_data['orders_count'];  // Total Orders Count

// Fetch total cart count for the logged-in user
$cart_count_sql = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_count_sql);
$cart_data = mysqli_fetch_assoc($cart_result);
$cart_count = $cart_data['cart_count'];  // Total Cart Count

// Include the header of the page (navigation, CSS, etc.)
include("header.php");  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
</head>
<body>
    <div class="container py-4">
        <div class="row col-12 g-4">
            <!-- Main Content Area -->
            <div class="col-md-8">
                <!-- Orders Card -->
                <div class="card orders-card h-65 flex-wrap">
                    <div class="card-header bg-primary text-white">
                        <!-- Display "My Orders" and "Cart" count -->
                        <h4 class="text-center">My Orders (<?php echo $orders_count; ?>) | Cart (<?php echo $cart_count; ?>)</h4>
                    </div>
                    <div class="card-body">
                        <!-- Display Orders Table if there are orders -->
                        <?php if ($orders_count > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query to get details of each order for the user
                                        $order_details_sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
                                        $order_details_result = mysqli_query($conn, $order_details_sql);
                                        
                                        // Loop through the orders and display them
                                        while ($order = mysqli_fetch_assoc($order_details_result)) {
                                            echo "<tr>";
                                            echo "<td>#{$order['id']}</td>";
                                            echo "<td>" . date('M d, Y', strtotime($order['order_date'])) . "</td>";
                                            echo "<td>{$order['total_amount']}</td>";
                                            echo "<td>{$order['total_amount']}</td>"; // This should be based on your logic
                                            echo "<td>{$order['status']}</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                You haven't placed any orders yet. <a href="products.php">Browse our products</a> to get started!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Include footer (closing tags and footer content) -->
    <?php include("footer.php"); ?>
</body>
</html>
