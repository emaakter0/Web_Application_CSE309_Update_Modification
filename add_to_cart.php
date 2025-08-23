<?php 
session_start();
require("db.php");

if (!isset($_SESSION['user_id'])) {
    header('Location:login.php');
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity   = intval($_POST['quantity']);
    
    $sql = "INSERT INTO cart (user_id, product_id, quantity, created_at) 
            VALUES ($user_id, $product_id, $quantity, NOW())";
    $result = mysqli_query($conn, $sql);

    if($result){
        // Detect which button was clicked
        if (isset($_POST['buy_now'])) {
            $redirect_url = "checkout.php";
        } else {
            $redirect_url = "cart.php";
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Redirecting...</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">

            <!-- Loader Section -->
            <div class="text-center">
                <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 fw-semibold">Processing your request...</p>
            </div>

            <script>
                setTimeout(function(){
                    window.location.href = "<?php echo $redirect_url; ?>";
                }, 1000); // 1.5 sec loader
            </script>
        </body>
        </html>
        <?php
    }
}
?>
