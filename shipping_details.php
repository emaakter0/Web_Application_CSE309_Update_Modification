<?php
session_start();
require('db.php');

// Check if user is logged in, redirect to login if not
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?return_to=' . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

// Initialize variables
$order_total = 0;
$subtotal = 0;
$shipping_cost = 70; // Default shipping cost
$cart_items = [];
$error_message = '';

// Get cart items from session or database
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT * FROM products WHERE id IN ($product_ids)";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        $error_message = "Error fetching products: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            while ($product = mysqli_fetch_assoc($result)) {
                $quantity = $_SESSION['cart'][$product['id']];
                $product['quantity'] = $quantity;
                $product['subtotal'] = $product['price'] * $quantity;
                $subtotal += $product['subtotal'];
                $cart_items[] = $product;
            }
        } else {
            $error_message = "No products found in the database matching your cart items.";
        }
    }
} else {
    $error_message = "Your cart is empty.";
}

$order_total = $subtotal + $shipping_cost;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error_message)) {
    // Validate and sanitize inputs
    $full_name = mysqli_real_escape_string($conn, $_POST['full-name']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone-number']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $full_address = mysqli_real_escape_string($conn, $_POST['full-address']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $delivery_method = mysqli_real_escape_string($conn, $_POST['delivery-method']);
    
    // Insert order into database
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');
    $status = 'pending';
    
    $sql = "INSERT INTO orders (user_id, order_date, status, total_amount, shipping_cost, 
            delivery_method, full_name, phone, district, area, address, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $error_message = "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("issdssssssss", $user_id, $order_date, $status, $order_total, $shipping_cost,
                         $delivery_method, $full_name, $phone_number, $district, $area, $full_address, $notes);
        
        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;
            
            // Insert order items
            foreach ($cart_items as $item) {
                $product_id = $item['id'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                
                $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                        VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $error_message = "Prepare failed: " . $conn->error;
                    break;
                }
                $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                if (!$stmt->execute()) {
                    $error_message = "Execute failed: " . $stmt->error;
                    break;
                }
            }
            
            if (empty($error_message)) {
                // Clear cart
                unset($_SESSION['cart']);
                
                // Redirect to payment or confirmation page
                header("Location: payment.php?order_id=$order_id");
                exit();
            }
        } else {
            $error_message = "Error placing order: " . $stmt->error;
        }
    }
}

// Fetch districts from database
$districts = [];
$sql = "SELECT * FROM districts ORDER BY name";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $districts[] = $row;
    }
} else {
    $error_message = "Error fetching districts: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 30px auto;
        }
        .shipping-details-section, .order-summary-section {
            padding: 20px;
            margin-bottom: 20px;
        }
        .delivery-options {
            margin-bottom: 20px;
        }
        .delivery-options input[type="radio"] {
            margin-right: 5px;
        }
        .delivery-options label {
            margin-right: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .half-width {
            flex: 1;
        }
        .order-summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .ordered-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .total-amount {
            border-top: 1px solid #ddd;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 1.1em;
        }
        .coupon-section {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .coupon-input {
            flex: 1;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
<?php
session_start();
require('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if cart is empty
$sql = "SELECT COUNT(*) as count FROM cart WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row['count'] == 0) {
    header('Location: cart.php');
    exit();
}

// Get districts for dropdown
$districts = [];
$sql = "SELECT * FROM districts";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $districts[] = $row;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $delivery_method = mysqli_real_escape_string($conn, $_POST['delivery_method']);
    
    // Calculate total
    $total_amount = 0;
    $sql = "SELECT p.price, c.quantity 
            FROM products p
            JOIN cart c ON p.id = c.product_id
            WHERE c.user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $total_amount += $row['price'] * $row['quantity'];
    }
    
    // Add shipping cost based on delivery method
    $shipping_cost = ($delivery_method == 'express') ? 100 : 50;
    $total_amount += $shipping_cost;
    
    // Insert order
    $order_date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO orders 
            (user_id, order_date, status, total_amount, shipping_cost, delivery_method, 
             full_name, phone, district, area, address, notes) 
            VALUES 
            ('$user_id', '$order_date', 'pending', '$total_amount', '$shipping_cost', '$delivery_method',
             '$full_name', '$phone', '$district', '$area', '$address', '$notes')";
    
    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);
        
        // Insert order items
        $sql = "SELECT p.id, p.price, c.quantity 
                FROM products p
                JOIN cart c ON p.id = c.product_id
                WHERE c.user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        
        while ($product = mysqli_fetch_assoc($result)) {
            $product_id = $product['id'];
            $quantity = $product['quantity'];
            $price = $product['price'];
            
            $sql = "INSERT INTO orders_items 
                    (order_id, product_id, quantity, price) 
                    VALUES 
                    ('$order_id', '$product_id', '$quantity', '$price')";
            mysqli_query($conn, $sql);
        }
        
        // Clear cart
        $sql = "DELETE FROM cart WHERE user_id = $user_id";
        mysqli_query($conn, $sql);
        
        // Redirect to thank you page
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Details - KittyPups</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
    <script>
        function loadAreas(district_id) {
            if (district_id) {
                fetch('get_areas.php?district_id=' + district_id)
                    .then(response => response.json())
                    .then(data => {
                        const areaSelect = document.getElementById('area');
                        areaSelect.innerHTML = '<option value="">Select Area</option>';
                        data.forEach(area => {
                            areaSelect.innerHTML += `<option value="${area.name}">${area.name}</option>`;
                        });
                    });
            }
        }
    </script>
</head>
<body>
    <!-- Header remains the same -->

    <div class="container py-5 checkout-container">
        <div class="row">
            <div class="col-md-7">
                <h2 class="mb-4">Shipping Information</h2>
                <form method="POST" action="shipping_details.php">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select" id="district" name="district" required onchange="loadAreas(this.value)">
                                <option value="">Select District</option>
                                <?php foreach ($districts as $district): ?>
                                    <option value="<?php echo $district['id']; ?>"><?php echo $district['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Area</label>
                            <select class="form-select" id="area" name="area" required>
                                <option value="">Select Area</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="delivery_method" class="form-label">Delivery Method</label>
                        <select class="form-select" id="delivery_method" name="delivery_method" required>
                            <option value="standard">Standard Delivery (৳50)</option>
                            <option value="express">Express Delivery (৳100)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Order Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
                </form>
            </div>
            
            <div class="col-md-5">
                <div class="order-summary">
                    <h3 class="mb-3">Order Summary</h3>
                    <?php
                    $total = 0;
                    $sql = "SELECT p.name, p.price, c.quantity 
                            FROM products p
                            JOIN cart c ON p.id = c.product_id
                            WHERE c.user_id = $user_id";
                    $result = mysqli_query($conn, $sql);
                    
                    while ($product = mysqli_fetch_assoc($result)) {
                        $subtotal = $product['price'] * $product['quantity'];
                        $total += $subtotal;
                        ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo $product['name']; ?> × <?php echo $product['quantity']; ?></span>
                            <span>৳<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <?php
                    }
                    ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>৳<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Shipping</span>
                        <span>৳<span id="shipping-cost">50</span></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>৳<span id="total-amount"><?php echo number_format($total + 50, 2); ?></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('delivery_method').addEventListener('change', function() {
            const shippingCost = this.value === 'express' ? 100 : 50;
            document.getElementById('shipping-cost').textContent = shippingCost;
            
            const subtotal = <?php echo $total; ?>;
            document.getElementById('total-amount').textContent = (subtotal + shippingCost).toFixed(2);
        });
    </script>
</body>
</html>