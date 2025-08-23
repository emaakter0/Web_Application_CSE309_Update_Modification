<?php

require("db.php");

// Fetch cart count for the current user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $count_sql = "SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = $user_id";
    $count_result = mysqli_query($conn, $count_sql);
    $count_row = mysqli_fetch_assoc($count_result);
    $cart_count = $count_row['total_items'] ? $count_row['total_items'] : 0;
} else {
    $cart_count = 0; // If the user is not logged in, cart count is 0
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitty Pups - Pet Care & Shop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <header>
        <div class="top-bar">
            <div class="container">
                <div class="left-links">
                    <a href="https://maps.app.goo.gl/VVHL3sAgMWqzh357A" target="_blank" class="map-location">
                        <i class="fa-solid fa-location-dot"></i> KittyPups Location
                    </a>
                    <a href="#">Track my order</a>
                     
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['role'] === "customer"): ?>
                            <a href="client_dashboard.php">My Account</a>
                        <?php elseif($_SESSION['role'] === "admin"): ?>
                            <a href="admin_dashboard.php">My Dashboard</a>
                        <?php elseif($_SESSION['role'] === "doctor"): ?>
                            <a href="doctor_dashboard.php">My Account</a>
                        <?php endif; ?>
                        <!-- Show when logged in -->
                        <a href="logout.php">Logout</a>
                    <?php else: ?>
                        <!-- Show when not logged in -->
                        <a href="signup.html">Sign Up</a>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </div>
                <div class="right-info">
                    <a href="tel:+8801767675206" class="emergency-contact">Emergency Contact Number: +8801767675206</a>
                </div>
            </div>
        </div>

        <nav class="main-nav">
            <div class="container">
                <div class="logo">
                    <img src="WhatsApp Image 2025-08-09 at 17.06.15_24840d36.jpg" alt="Kitty Pups Logo">
                    <div class="logo-text">
                        <span>KittyPups</span>
                        <p>Every Life Counts</p>
                    </div>
                </div>

                <div class="nav-links">
                    <ul>
                        <li><a href="index.php"> Pet Home</a></li>
        <li><a href="#pet-lifestyle">Pet Lifestyle</a></li>
        <li><a href="pet_categories.php">Pet Categories</a></li>
        <li><a href="pet_medicines.php"> Pet Pharmacy</a></li>
        <li><a href="pet_services.html"> Pet Treatment Services</a></li>
        <li><a href="aboutus.html">About Us</a></li>
        <li><a href="contractus.html">Contact Us</a></li>
                    </ul>
                </div>

                <div class="nav-actions">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search food, medicine, services...">
                    </div>

                    <!-- Cart Icon with Dynamic Cart Count -->
                    <a href="cart.php" class="cart-icon position-relative">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Cart</span>
                        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $cart_count; ?>
                        </span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Other content goes here -->

</body>
</html>
