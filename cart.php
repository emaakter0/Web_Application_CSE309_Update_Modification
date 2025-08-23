<?php
session_start();
require("db.php");

if (!isset($_SESSION['user_id'])) {
    header('Location:login.php');
}

$user_id = $_SESSION['user_id'];

// Handle adding items to cart
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity   = intval($_POST['quantity']);

    $sql = "INSERT INTO cart (user_id, product_id, quantity, created_at) 
            VALUES ($user_id, $product_id, $quantity, NOW())";
    mysqli_query($conn, $sql);

    // Update cart count in session after adding item
    $count_sql = "SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = $user_id";
    $count_result = mysqli_query($conn, $count_sql);
    $count_row = mysqli_fetch_assoc($count_result);
    $_SESSION['cart_count'] = $count_row['total_items'];
}

// Handle removing items from cart
if (isset($_GET['remove_id'])) {
    $remove_id = intval($_GET['remove_id']);
    $delete_sql = "DELETE FROM cart WHERE id = $remove_id AND user_id = $user_id";
    mysqli_query($conn, $delete_sql);
    
    // Update cart count after item removal
    $count_sql = "SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = $user_id";
    $count_result = mysqli_query($conn, $count_sql);
    $count_row = mysqli_fetch_assoc($count_result);
    $_SESSION['cart_count'] = $count_row['total_items'];
    
    // Redirect to avoid resubmission on refresh
    header("Location: cart.php");
    exit();
}

// Fetch cart items count for the header
$count_sql = "SELECT SUM(quantity) as total_items FROM cart WHERE user_id = $user_id";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$cart_count = $count_row['total_items'] ? $count_row['total_items'] : 0;

// Fetch cart items for the current user
$sql = "SELECT cart.id, products.id as product_id, products.name, products.price, cart.quantity, 
               (products.price * cart.quantity) as total, products.image
        FROM cart 
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $user_id";

$result = mysqli_query($conn, $sql);
$grand_total = 0;

// Store cart count in session for use in header
$_SESSION['cart_count'] = $cart_count;

include("header.php"); 
?>

<body style="background:#f7f3f6;">
    <div class="container py-4 ">
        <div class="card shadow-lg border-1 rounded-4 col-12">
            <div class="card-body p-0">
                <h2 class="mb-4 text-center fw-bold text-primary">
                    🛒 Your Shopping Cart (<?php echo $cart_count; ?> items)
                </h2>

                <?php if (mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $counter = 1;
                            while ($row = mysqli_fetch_assoc($result)): 
                            ?>
                                <?php $grand_total += $row['total']; ?>
                                <tr>
                                    <td class="fw-bold text-center"><?php echo $counter++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $row['image']; ?>" 
                                                 alt="<?php echo $row['name']; ?>" 
                                                 class="rounded me-3" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            <span class="fw-semibold"><?php echo $row['name']; ?></span>
                                        </div>
                                    </td>
                                    <td class="text-muted">$<?php echo number_format($row['price'], 2); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo $row['quantity']; ?></span></td>
                                    <td class="fw-bold text-success">$<?php echo number_format($row['total'], 2); ?></td>
                                    <td>
                                        <a href="cart.php?remove_id=<?php echo $row['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to remove this item from your cart?')">
                                            <i class="fas fa-trash"></i> Remove
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Grand Total:</td>
                                    <td class="fw-bold text-danger">$<?php echo number_format($grand_total, 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                        <a href="checkout.php" class="btn btn-success btn-lg">
                            Proceed to Checkout <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="fw-semibold">Your cart is empty.</h5>
                        <a href="index.php" class="btn btn-primary mt-3">Start Shopping</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for confirmation dialog
        function confirmRemove() {
            return confirm('Are you sure you want to remove this item from your cart?');
        }
    </script>
</body>
</html>
