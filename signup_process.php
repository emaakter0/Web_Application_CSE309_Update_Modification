<?php
session_start();
require('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Not hashed as per requirement
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Set approved status (0 for non-customer roles)
    $approved = ($role === 'customer') ? 1 : 0;
    
    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        // User already exists
        header("Location: signup.html?error=username_or_email_exists");
        exit;
    } else {
        // Insert new user
        $insert_query = "INSERT INTO users (username, email, password, role, approved, created_at, updated_at) 
                        VALUES ('$username', '$email', '$password', '$role', $approved, NOW(), NOW())";
        
        if (mysqli_query($conn, $insert_query)) {
            // Registration successful
            header("Location: login.php?signup=success");
            exit;
        } else {
            // Database error
            header("Location: signup.html?error=database_error");
            exit;
        }
    }
} else {
    // Not a POST request
    header("Location: signup.html");
    exit;
}
?>