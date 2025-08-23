<?php
session_start();
include("db.php");

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    // Get and sanitize form data
    $product_id = intval($_POST['product_id']);
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

    // Update product in database
    $sql = "UPDATE products SET 
            name = '$name',
            price = $price,
            image = '$image',
            category = '$category',
            description = '$description',
            brand_name = '$brand_name',
            weight = '$weight',
            stock = $stock
            WHERE id = $product_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Product updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating product: " . mysqli_error($conn);
        error_log("Failed query: " . $sql);
        error_log("MySQL error: " . mysqli_error($conn));
    }

    header("Location: admin_dashboard.php");
    exit;
}
?>