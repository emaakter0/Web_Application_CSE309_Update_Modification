<?php
session_start();
include("db.php"); // your db connection

// ✅ Assume logged in user_id (replace with session logic)
$user_id = $_SESSION['user_id'] ?? 1;  

// --- Fetch cart items ---
$cart_sql = "SELECT c.id, c.product_id, c.quantity, p.name, p.price 
             FROM cart c 
             JOIN products p ON c.product_id = p.id 
             WHERE c.user_id = $user_id";
$cart_result = $conn->query($cart_sql);

$cart_items = [];
$total_amount = 0;

while ($row = $cart_result->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total_amount += $row['subtotal'];
    $cart_items[] = $row;
}

// --- Handle form submit ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_date = $_POST['order_date'];
    $status = $_POST['status'];
    $shipping_cost = $_POST['shipping_cost'];
    $delivery_method = $_POST['delivery_method'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $district = $_POST['district'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];

    // insert order
    $sql = "INSERT INTO orders 
            (user_id, order_date, status, total_amount, shipping_cost, delivery_method, full_name, phone, district, area, address, notes) 
            VALUES 
            ('$user_id', '$order_date', '$status', '$total_amount', '$shipping_cost', '$delivery_method', '$full_name', '$phone', '$district', '$area', '$address', '$notes')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // insert order items
        foreach ($cart_items as $item) {
            $pid = $item['product_id'];
            $qty = $item['quantity'];
            $price = $item['price'];

            $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                          VALUES ('$order_id', '$pid', '$qty', '$price')");
        }

        // clear cart
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");

        echo "<div class='alert alert-success'>✅ Order placed successfully! Redirecting...</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'client_dashboard.php';
                }, 1500); // 1500ms = 1.5 seconds
            </script>";

    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>
<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head> -->


<?php  
include("header.php")
?>
<body style="background:#f7f3f6;">
<div class="container py-5">
    <div class="row">
        <!-- Cart Summary -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🛒 Your Cart</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cart_items as $item) { ?>
                            <tr>
                                <td><?= $item['name'] ?></td>
                                <td class="text-end"><?= number_format($item['price'], 2) ?></td>
                                <td class="text-center"><?= $item['quantity'] ?></td>
                                <td class="text-end"><?= number_format($item['subtotal'], 2) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Total</td>
                                <td class="text-end text-primary"><?= number_format($total_amount, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">💳 Checkout Details</h5>
                </div>
                <div class="card-body">
                    <form method="post" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Order Date</label>
                            <input type="date" name="order_date" id="order_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" selected>Pending</option>
                                <option value="processing" disabled>Processing</option>
                                <option value="shipped" disabled>Shipped</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Shipping Cost</label>
                            <input type="number" step="0.01" name="shipping_cost" id="shipping_cost"   value="60" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Delivery Method</label>
                            <select name="delivery_method" id="delivery_method"   class="form-select">
                                <option value="Courier" selected>Courier</option>
                                <option value="Pickup">Pickup</option>
                            </select>
                        </div>

                        <hr class="my-3">

                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Example: Joynob Ema" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" placeholder="Example: 01758551245"  class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">District</label>
                            <input type="text" name="district"  placeholder="Example: Dhaka" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Area</label>
                            <input type="text" name="area"  placeholder="Example: Basundhara R/A" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control"  placeholder="Example: D block,Road 07,House 65" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control"  placeholder="If you have anything else to mention feel free to share with us" rows="2"></textarea>
                        </div>

                        <input type="hidden" name="total_amount" value="<?= $total_amount ?>">

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                ✅ Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('order_date').value = today;
});                          

    document.addEventListener('DOMContentLoaded', function() {
    const deliveryMethod = document.getElementById('delivery_method');
    const shippingCost = document.getElementById('shipping_cost');
    
    // Set initial shipping cost based on default selection
    updateShippingCost();
    
    // Update shipping cost when delivery method changes
    deliveryMethod.addEventListener('change', updateShippingCost);
    
    function updateShippingCost() {
        if (deliveryMethod.value === 'Courier') {
            shippingCost.value = '60';
            shippingCost.readOnly = true; // Make it read-only for Courier
        } else if (deliveryMethod.value === 'Pickup') {
            shippingCost.value = '0';
            shippingCost.readOnly = true; // Make it read-only for Pickup
        }
    }
});
</script>

<?php  
include("footer.php")
?>
