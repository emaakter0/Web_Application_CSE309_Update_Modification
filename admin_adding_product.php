<?php
session_start();
include("db.php");

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    // Get and sanitize form data
    $name = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
    $price = floatval($_POST['price'] ?? 0);
    $category = mysqli_real_escape_string($conn, trim($_POST['category'] ?? ''));
    $description = mysqli_real_escape_string($conn, trim($_POST['description'] ?? ''));
    $brand_name = mysqli_real_escape_string($conn, trim($_POST['brand_name'] ?? ''));
    $weight = mysqli_real_escape_string($conn, trim($_POST['weight'] ?? ''));
    $stock = intval($_POST['stock'] ?? 0);
    $image = mysqli_real_escape_string($conn, trim($_POST['image'] ?? ''));

    // Simple validation
    if (empty($name) || empty($price) || empty($category) || empty($image)) {
        $_SESSION['error'] = "Please fill all required fields (Name, Price, Category, Image)";
        header("Location: admin_dashboard.php");
        exit;
    }

    // Insert into database - fixed rating to default to 0
    $sql = "INSERT INTO products 
            (name, price, image, rating, category, description, brand_name, weight, stock)
            VALUES (
                '$name', 
                $price, 
                '$image', 
                0, 
                '$category', 
                '$description', 
                '$brand_name', 
                '$weight', 
                $stock
            )";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Product added successfully!";
    } else {
        $_SESSION['error'] = "Error adding product: " . mysqli_error($conn);
        // For debugging - remove in production
        error_log("Failed query: " . $sql);
        error_log("MySQL error: " . mysqli_error($conn));
    }

    header("Location: admin_dashboard.php");
    exit;
}
?>