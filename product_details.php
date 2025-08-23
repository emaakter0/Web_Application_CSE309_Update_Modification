<?php 
session_start();
require("db.php"); 

// Check if product ID exists in URL
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // convert to integer for security

    // Read product data
    $sql = "SELECT * FROM `products` WHERE `id` = $product_id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
       
    } else {
        echo "Product not found.";
    }
} else {
    echo "No product ID provided.";
}

include("header.php");

?>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-img {
            max-height: 500px;
            object-fit: contain;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
        }
        .stock-info {
            font-size: 0.9rem;
        }
        .btn-action {
            min-width: 150px;
        }
    </style>
</head>
-->
<body  style="background:#f7f3f6;"> 


<main> 
    <div class="container py-5 d-flex justify-content-center alight-items center ">
        
        <form method="post" action="add_to_cart.php">  
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    </div>
                </div>
                
                <!-- Product Details -->
                <div class="col-md-6"> 
                    <h1 class="mb-3"><?php echo htmlspecialchars($row['name']); ?></h1>

                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="mb-3">Description</h5>
                        <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                        <input type="hidden" name="description" value="<?php echo htmlspecialchars($row['description']); ?>">
                    </div>
                    
                    <?php if (!empty($row['brand_name'])): ?>
                        <p class="text-muted mb-1">Brand: <span class="text-primary fw-bold"><?php echo htmlspecialchars($row['brand_name']); ?></span></p>
                        <?php endif; ?>
                        
                        <!-- Rating -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <span class="badge bg-success"><?php echo htmlspecialchars($row['rating']); ?> <i class="fas fa-star"></i></span>
                            </div>
                            <div>
                                <span class="text-success"><i class="fas fa-check-circle"></i> In Stock</span>
                            </div>
                        </div>
                        
                        <!-- Price -->
                        <div class="mb-2">
                            <h2 class="text-primary"><?php echo number_format($row['price'], 2); ?> BDT</h2>
                            <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                        </div>
                        
                        <!-- Specifications -->
                        <div class="mb-4">
                            <h5 class="mb-3">Specifications</h5>
                            <ul class="list-unstyled">
                                <?php if (!empty($row['brand_name'])): ?>
                                    <li class="mb-2"><strong>Brand:</strong> <?php echo htmlspecialchars($row['brand_name']); ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($row['weight'])): ?>
                                        <li class="mb-2"><strong>Weight:</strong> <?php echo htmlspecialchars($row['weight']); ?> kg</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                    
                                <!-- Quantity -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Quantity</h5>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary quantity-btn" type="button" id="decrease-qty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" class="quantity-input mx-2 py-1 text-center" value="1" min="1" max="<?php echo $row['stock']; ?>">
                                        <button class="btn btn-outline-secondary quantity-btn" type="button" id="increase-qty">
                                <i class="fas fa-plus"></i>
                            </button>
                            <span class="stock-info text-muted ms-3"><?php echo $row['stock']; ?> left in stock</span>
                        </div>
                        <input type="hidden" name="stock" value="<?php echo $row['stock']; ?>">
                    </div>
                    
                   <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <button type="submit" name="add_to_cart" class="btn btn-primary btn-lg btn-action">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                        <button type="submit" name="buy_now" class="btn btn-success btn-lg btn-action">
                            <i class="fas fa-bolt me-2"></i>Buy Now
                        </button>
                    </div>

                    
                    
                </div>
            </div>
        </form>
        
        

        
        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Quantity adjustment functionality
        document.getElementById('decrease-qty').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
        
        document.getElementById('increase-qty').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            if (parseInt(input.value) < 10) {
                input.value = parseInt(input.value) + 1;
            }
        });
        </script>
</body>
</html>
