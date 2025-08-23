<?php
session_start();
require("db.php");
$category = isset($_GET['category']) ? $_GET['category'] : '';

include("header.php");


                    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Products - KittyPups</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f7f3f6;
            font-family: 'Poppins', sans-serif;
        }
        
        .container-split {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .sidebar-nav {
            flex: 0 0 250px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .products-section {
            flex: 1;
            min-width: 300px;
        }
        
        #all-categories-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        
        .back-to-home-btn {
            width: 100%;
            background: #ff6b6b;
            color: white;
            border: none;
            margin-bottom: 10px;
            transition: all 0.3s;
        }
        
        .back-to-home-btn:hover {
            background: #ff5252;
            transform: translateY(-2px);
        }
        
        .welcome-section {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .welcome-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .section-header h2 {
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }
        
        .card {
            border: none;
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .card-img-top {
            border-radius: 8px 8px 0 0;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-weight: 500;
            color: #333;
        }
        
        .btn-outline-primary {
            border-color: #6c63ff;
            color: #6c63ff;
        }
        
        .btn-outline-primary:hover {
            background: #6c63ff;
            color: white;
        }
        
        @media (max-width: 768px) {
            .container-split {
                flex-direction: column;
            }
            
            .sidebar-nav {
                flex: 0 0 auto;
            }
        }
    </style>
</head>
<body>

    <main class="pet-categories-main">
        <div class="container-split">
            <aside class="sidebar-nav">
                <h3 id="all-categories-title">Pet Products</h3>
           <!-- Categories (URL-encoded values) -->
<a href="?category=cat" class="btn back-to-home-btn"><i class="fas fa-cat me-2"></i>Cat</a>
<a href="?category=dog" class="btn back-to-home-btn"><i class="fas fa-dog me-2"></i>Dog</a>
<a href="?category=rabbit" class="btn back-to-home-btn"><i class="fas fa-rabbit me-2"></i>Rabbit</a>
<a href="?category=bird" class="btn back-to-home-btn"><i class="fas fa-dove me-2"></i>Bird</a>

<a href="?category=cat%20food" class="btn back-to-home-btn"><i class="fas fa-bone me-2"></i>Cat Food</a>
<a href="?category=kitten%20food" class="btn back-to-home-btn"><i class="fas fa-bone me-2"></i>Kitten Food</a>
<a href="?category=food" class="btn back-to-home-btn"><i class="fas fa-utensils me-2"></i>Food</a>
<a href="?category=medicine" class="btn back-to-home-btn"><i class="fas fa-pills me-2"></i>Medicine</a>

<a href="?category=accessories" class="btn back-to-home-btn"><i class="fas fa-box-open me-2"></i>Accessories</a>
<a href="?category=cat%20accessories" class="btn back-to-home-btn"><i class="fas fa-cat me-2"></i>Cat Accessories</a>

<a href="?category=cat%20toys" class="btn back-to-home-btn"><i class="fas fa-puzzle-piece me-2"></i>Cat Toys</a>
<a href="?category=cat%20litter" class="btn back-to-home-btn"><i class="fas fa-box-open me-2"></i>Cat Litter</a>

<a href="?category=clothing%2C%20beds%20%26%20carrier" class="btn back-to-home-btn"><i class="fas fa-tshirt me-2"></i>Clothing, Beds &amp; Carrier</a>

<a href="?category=dog%20food" class="btn back-to-home-btn"><i class="fas fa-bone me-2"></i>Dog Food</a>
<a href="?category=dog%20health%20and%20accessories" class="btn back-to-home-btn"><i class="fas fa-heartbeat me-2"></i>Dog Health &amp; Accessories</a>

<a href="?category=rabbit%20food%20and%20accessories" class="btn back-to-home-btn"><i class="fas fa-carrot me-2"></i>Rabbit Food &amp; Accessories</a>
<a href="?category=bird%20food%20and%20accessories" class="btn back-to-home-btn"><i class="fas fa-feather me-2"></i>Bird Food &amp; Accessories</a>

            </aside>

            <section class="products-section">
                <?php if(empty($category)): ?>
                    <div id="welcome-message" class="welcome-section">
                        <img src="pet all.jpg" alt="Welcome Pet" class="welcome-image">
                        <h2>Choose a category to start shopping!</h2>
                        <p>Explore a wide range of products for your beloved pet.</p>
                    </div>
                <?php else: ?>
                    <div id="products-content">
                        <div class="section-header text-center mt-2">
                            <h2 id="products-header"><?php echo ucwords($category); ?> Products</h2>
                        </div>
                       
                        <div id="product-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                            <?php
                            // Fetch products for the selected category
                            $sql = "SELECT * FROM products WHERE category LIKE '%$category%'";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                while ($product = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="col">
                                        <div class="card h-100 shadow-sm border-0 rounded-3">
                                            <!-- Product Image -->
                                            <div class="ratio ratio-4x3">
                                                <img src="<?php echo $product['image']; ?>" 
                                                     alt="<?php echo $product['name']; ?>" 
                                                     class="card-img-top rounded-top" style="object-fit: cover;">
                                            </div>

                                            <!-- Product Body -->
                                            <div class="card-body d-flex flex-column text-center">
                                                <h5 class="card-title fw-semibold mb-2">
                                                    <?php echo $product['name']; ?>
                                                </h5>
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="badge bg-primary"><?php echo $product['category']; ?></span>
                                                    <span class="fw-bold text-danger">$<?php echo $product['price']; ?></span>
                                                </div>
                                                
                                                <p class="text-warning mb-1">
                                                    <?php 
                                                    $fullStars = floor($product['rating']);
                                                    $halfStar = ($product['rating'] - $fullStars) >= 0.5;
                                                    for ($i = 0; $i < $fullStars; $i++) {
                                                        echo '<i class="fas fa-star"></i>';
                                                    }
                                                    if ($halfStar) {
                                                        echo '<i class="fas fa-star-half-alt"></i>';
                                                    }
                                                    for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++) {
                                                        echo '<i class="far fa-star"></i>';
                                                    }
                                                    ?>
                                                    <span class="text-muted small">(<?php echo $product['rating']; ?>)</span>
                                                </p>
                                                
                                                <p class="text-muted small mb-3">
                                                    Stock: <?php echo $product['stock']; ?>
                                                </p>

                                                <!-- Button -->
                                                <div class="mt-auto">
                                                    <a href="product_details.php?id=<?php echo $product['id']; ?>" 
                                                       class="btn btn-outline-primary w-100">
                                                        <i class="fas fa-info-circle me-2"></i>Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div class="col-12"><div class="alert alert-info">No products found for this category.</div></div>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
include("footer.php");
?>