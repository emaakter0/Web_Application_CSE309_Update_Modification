<?php 
session_start();
require("db.php");

if (!isset($_SESSION['user_id'])) {
    header('Location:login.php');
    // header('Location:login.php');
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity   = intval($_POST['quantity']);
    
    $sql = "INSERT INTO cart (user_id, product_id, quantity, created_at) 
            VALUES ($user_id, $product_id, $quantity, NOW())";
    $result = mysqli_query($conn, $sql);

    if($result){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Redirecting...</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="d-flex justify-content-center align-items-center vh-100 bg-light">

            <!-- Just 1 line spinner -->
            <div class="spinner-grow text-success" role="status"></div>

            <script>
                setTimeout(function(){
                    window.location.href = "checkout.php";
                }, 1500);
            </script>
        </body>
        </html>
        <?php
    }
}
?>
