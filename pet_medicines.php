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
    <title>Pet Medicines - KittyPups</title>
    <link rel="stylesheet" href="pet_categories.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background:#f7f3f6;">

    <main class="pet-categories-main ">
        <div class="container-split">
            <aside class="sidebar-nav">
                <h3 id="all-categories-title">Pet medicine</h3>
                <a href="index.php" class="btn back-to-home-btn">Back to Home</a>
                <br><br>
                <a href="?category=cat" class="btn back-to-home-btn">Cat products</a>
                <a href="?category=dog" class="btn back-to-home-btn">Dog products</a>
                <a href="?category=rabbit" class="btn back-to-home-btn">Rabbit products</a>
                <a href="?category=bird" class="btn back-to-home-btn">Bird products</a>
                <ul id="category-list">
                </ul>
            </aside>

            <section class="products-section">
                <?php if(empty($category)): ?>
                    <div id="welcome-message" class="welcome-section">
                        <img src="puppy-and-kitten-online-pet-pharmacy.jpg" alt="Welcome Pet" class="welcome-image">
                        <h2>Choose a category to start shopping!</h2>
                        <p>Explore a wide range of products for your beloved pet.</p>
                    </div>
                <?php else: ?>
    <div id="products-content">
        <div class="section-header text-center mt-2">
            <h2 id="products-header "><?php echo ucfirst($category); ?> Products</h2>
        </div>
       <div id="product-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php
    // Fetch products for the selected category
    $sql = "SELECT * FROM products WHERE category='$category'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($product = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <!-- Product Image -->
                    <div class="ratio ratio-4x3">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                             class="card-img-top rounded-top" style="object-fit: cover;">
                    </div>

                    <!-- Product Body -->
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title fw-semibold mb-2">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h5>
                        <p class="text-warning mb-1">
                            <?php echo str_repeat('⭐', $product['rating']); ?>
                            <span class="text-muted small">(<?php echo $product['rating']; ?>)</span>
                        </p>
                        <p class="fw-bold text-primary mb-3">
                            <?php echo $product['price']; ?> BDT
                        </p>

                        <!-- Button -->
                        <div class="mt-auto">
                            <a href="product_details.php?id=<?php echo $product['id']; ?>" 
                               class="btn btn-outline-primary w-100">
                                Check Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<div class="col-12"><p class="text-center">No products found for this category.</p></div>';
    }
    ?>
</div>

    </div>
<?php endif; ?>
            </section>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


<?php 
include("footer.php")
?>
</body>
</html>
